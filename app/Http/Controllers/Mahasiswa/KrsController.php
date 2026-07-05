<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\MataKuliah;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class KrsController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        abort_if(
            !$userId,
            401,
            'Silakan login terlebih dahulu.'
        );

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

        $mataKuliahs = collect();
        $krsDiambil = collect();

        if ($tahunAkademikAktif) {
            $mataKuliahs = MataKuliah::query()
                ->with('dosen.user')
                ->orderBy('semester')
                ->orderBy('kode')
                ->get();

            $krsDiambil = Krs::query()
                ->where('mahasiswa_id', $mahasiswa->id)
                ->where(
                    'tahun_akademik_id',
                    $tahunAkademikAktif->id
                )
                ->where('status', 'diambil')
                ->pluck('matkul_id');
        }

        return view('mahasiswa.krs.index', compact(
            'mahasiswa',
            'tahunAkademikAktif',
            'mataKuliahs',
            'krsDiambil'
        ));
    }

    public function ambil(
        MataKuliah $mataKuliah
    ): RedirectResponse {
        $userId = Auth::id();

        abort_if(
            !$userId,
            401,
            'Silakan login terlebih dahulu.'
        );

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

        if (!$tahunAkademikAktif) {
            return back()->with(
                'error',
                'Tahun akademik aktif belum tersedia.'
            );
        }

        $sudahDiambil = Krs::query()
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('matkul_id', $mataKuliah->id)
            ->where(
                'tahun_akademik_id',
                $tahunAkademikAktif->id
            )
            ->where('status', 'diambil')
            ->exists();

        if ($sudahDiambil) {
            return back()->with(
                'error',
                'Mata kuliah tersebut sudah diambil.'
            );
        }

        $totalSks = Krs::query()
            ->where('krs.mahasiswa_id', $mahasiswa->id)
            ->where(
                'krs.tahun_akademik_id',
                $tahunAkademikAktif->id
            )
            ->where('krs.status', 'diambil')
            ->join(
                'mata_kuliahs',
                'mata_kuliahs.id',
                '=',
                'krs.matkul_id'
            )
            ->sum('mata_kuliahs.sks');

        if (($totalSks + $mataKuliah->sks) > 24) {
            return back()->with(
                'error',
                'Jumlah SKS tidak boleh melebihi 24 SKS.'
            );
        }

        Krs::updateOrCreate(
            [
                'mahasiswa_id' => $mahasiswa->id,
                'matkul_id' => $mataKuliah->id,
                'tahun_akademik_id' => $tahunAkademikAktif->id,
            ],
            [
                'status' => 'diambil',
            ]
        );

        return back()->with(
            'success',
            'Mata kuliah berhasil diambil.'
        );
    }

    public function batal(
        MataKuliah $mataKuliah
    ): RedirectResponse {
        $userId = Auth::id();

        abort_if(
            !$userId,
            401,
            'Silakan login terlebih dahulu.'
        );

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

        if (!$tahunAkademikAktif) {
            return back()->with(
                'error',
                'Tahun akademik aktif belum tersedia.'
            );
        }

        $krs = Krs::query()
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('matkul_id', $mataKuliah->id)
            ->where(
                'tahun_akademik_id',
                $tahunAkademikAktif->id
            )
            ->where('status', 'diambil')
            ->first();

        if (!$krs) {
            return back()->with(
                'error',
                'Mata kuliah tersebut tidak sedang diambil.'
            );
        }

        if ($krs->nilai()->exists()) {
            return back()->with(
                'error',
                'Mata kuliah tidak dapat dibatalkan karena nilai sudah tersedia.'
            );
        }

        $krs->status = 'dibatalkan';
        $krs->save();

        return back()->with(
            'success',
            'Mata kuliah berhasil dibatalkan.'
        );
    }

    public function pdf()
    {
        $userId = Auth::id();

        abort_if(
            !$userId,
            401,
            'Silakan login terlebih dahulu.'
        );

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

        $krs = collect();

        if ($tahunAkademikAktif) {

            $krs = Krs::query()
                ->with([
                    'mataKuliah.dosen.user',
                ])
                ->where('mahasiswa_id', $mahasiswa->id)
                ->where('tahun_akademik_id', $tahunAkademikAktif->id)
                ->where('status', 'diambil')
                ->get();
        }

        $pdf = Pdf::loadView(
            'mahasiswa.krs.pdf',
            compact(
                'mahasiswa',
                'tahunAkademikAktif',
                'krs'
            )
        );

        return $pdf->stream('KRS.pdf');
    }
}