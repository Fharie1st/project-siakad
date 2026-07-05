<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use App\Models\Krs;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
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

        $tahunAkademikAktif = TahunAkademik::query()
            ->where('is_aktif', true)
            ->first();

        $totalSks = 0;
        $ipk = 0;
        $jadwalHariIni = collect();

        if ($tahunAkademikAktif) {
            $totalSks = Krs::query()
                ->where('mahasiswa_id', $mahasiswa->id)
                ->where(
                    'tahun_akademik_id',
                    $tahunAkademikAktif->id
                )
                ->where('status', 'diambil')
                ->join(
                    'mata_kuliahs',
                    'mata_kuliahs.id',
                    '=',
                    'krs.matkul_id'
                )
                ->sum('mata_kuliahs.sks');

            $namaHari = $this->namaHariIndonesia(
                now()->dayOfWeek
            );

            if ($namaHari !== 'Minggu') {
                $matkulIds = Krs::query()
                    ->where('mahasiswa_id', $mahasiswa->id)
                    ->where(
                        'tahun_akademik_id',
                        $tahunAkademikAktif->id
                    )
                    ->where('status', 'diambil')
                    ->pluck('matkul_id');

                $jadwalHariIni = JadwalKuliah::query()
                    ->with([
                        'mataKuliah.dosen.user',
                        'ruangan',
                    ])
                    ->whereIn('matkul_id', $matkulIds)
                    ->where(
                        'tahun_akademik_id',
                        $tahunAkademikAktif->id
                    )
                    ->where('hari', $namaHari)
                    ->orderBy('jam_mulai')
                    ->get();
            }
        }

        $krsDenganNilai = Krs::query()
            ->with([
                'mataKuliah',
                'nilai',
            ])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'diambil')
            ->whereHas('nilai', function ($query) {
                $query->whereNotNull('nilai_akhir');
            })
            ->get();

        $totalBobot = 0;
        $totalSksNilai = 0;

        foreach ($krsDenganNilai as $krs) {
            $sks = $krs->mataKuliah->sks;
            $bobot = $this->bobotGrade(
                $krs->nilai?->grade
            );

            $totalBobot += $bobot * $sks;
            $totalSksNilai += $sks;
        }

        if ($totalSksNilai > 0) {
            $ipk = round(
                $totalBobot / $totalSksNilai,
                2
            );
        }

        return view('mahasiswa.dashboard', compact(
            'mahasiswa',
            'tahunAkademikAktif',
            'totalSks',
            'ipk',
            'jadwalHariIni'
        ));
    }

    private function namaHariIndonesia(int $dayOfWeek): string
    {
        return match ($dayOfWeek) {
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            default => 'Minggu',
        };
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