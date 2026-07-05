<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class KhsController extends Controller
{
    public function index(Request $request): View
    {
        $userId = Auth::id();

        abort_if(!$userId, 401, 'Silakan login terlebih dahulu.');

        $user = User::query()
            ->with('mahasiswa')
            ->findOrFail($userId);

        $mahasiswa = $user->mahasiswa;

        abort_if(
            !$mahasiswa,
            404,
            'Data mahasiswa tidak ditemukan.'
        );

        $tahunAkademiks = TahunAkademik::query()
            ->orderByDesc('tahun')
            ->orderByDesc('semester')
            ->get();

        $tahunAkademikDipilih = null;

        if ($request->filled('tahun_akademik_id')) {
            $tahunAkademikDipilih = TahunAkademik::query()
                ->find($request->integer('tahun_akademik_id'));
        }

        if (!$tahunAkademikDipilih) {
            $tahunAkademikDipilih = TahunAkademik::query()
                ->where('is_aktif', true)
                ->first();
        }

        $dataKhs = collect();
        $ips = 0;

        if ($tahunAkademikDipilih) {
            $dataKhs = Krs::query()
                ->with([
                    'mataKuliah',
                    'nilai',
                ])
                ->where('mahasiswa_id', $mahasiswa->id)
                ->where('tahun_akademik_id', $tahunAkademikDipilih->id)
                ->where('status', 'diambil')
                ->whereHas('nilai')
                ->get();

            $totalBobot = 0;
            $totalSks = 0;

            foreach ($dataKhs as $krs) {
                if (!$krs->nilai?->grade) {
                    continue;
                }

                $sks = $krs->mataKuliah->sks;
                $bobot = $this->bobotGrade($krs->nilai->grade);

                $totalBobot += $bobot * $sks;
                $totalSks += $sks;
            }

            if ($totalSks > 0) {
                $ips = round($totalBobot / $totalSks, 2);
            }
        }

        return view('mahasiswa.khs.index', compact(
            'mahasiswa',
            'tahunAkademiks',
            'tahunAkademikDipilih',
            'dataKhs',
            'ips'
        ));
    }

    public function pdf(Request $request): Response
    {
        $userId = Auth::id();

        abort_if(!$userId, 401, 'Silakan login terlebih dahulu.');

        $user = User::query()
            ->with('mahasiswa')
            ->findOrFail($userId);

        $mahasiswa = $user->mahasiswa;

        abort_if(
            !$mahasiswa,
            404,
            'Data mahasiswa tidak ditemukan.'
        );

        $tahunAkademikDipilih = null;

        if ($request->filled('tahun_akademik_id')) {
            $tahunAkademikDipilih = TahunAkademik::query()
                ->find($request->integer('tahun_akademik_id'));
        }

        if (!$tahunAkademikDipilih) {
            $tahunAkademikDipilih = TahunAkademik::query()
                ->where('is_aktif', true)
                ->first();
        }

        $dataKhs = collect();
        $ips = 0;

        if ($tahunAkademikDipilih) {
            $dataKhs = Krs::query()
                ->with([
                    'mataKuliah',
                    'nilai',
                ])
                ->where('mahasiswa_id', $mahasiswa->id)
                ->where('tahun_akademik_id', $tahunAkademikDipilih->id)
                ->where('status', 'diambil')
                ->whereHas('nilai')
                ->get();

            $totalBobot = 0;
            $totalSks = 0;

            foreach ($dataKhs as $krs) {
                if (!$krs->nilai?->grade) {
                    continue;
                }

                $sks = $krs->mataKuliah->sks;
                $bobot = $this->bobotGrade($krs->nilai->grade);

                $totalBobot += $bobot * $sks;
                $totalSks += $sks;
            }

            if ($totalSks > 0) {
                $ips = round($totalBobot / $totalSks, 2);
            }
        }

        $pdf = Pdf::loadView(
            'mahasiswa.khs.pdf',
            compact(
                'mahasiswa',
                'tahunAkademikDipilih',
                'dataKhs',
                'ips'
            )
        );

        return $pdf->stream('KHS.pdf');
    }

    private function bobotGrade(?string $grade): float
    {
        return match ($grade) {
            'A' => 4.00,
            'B+' => 3.50,
            'B' => 3.00,
            'C+' => 2.50,
            'C' => 2.00,
            'D' => 1.00,
            default => 0.00,
        };
    }
}