<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\Krs;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalUjianController extends Controller
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

        $jadwalUjians = collect();

        if ($tahunAkademikAktif) {
            $matkulIds = Krs::query()
                ->where('mahasiswa_id', $mahasiswa->id)
                ->where(
                    'tahun_akademik_id',
                    $tahunAkademikAktif->id
                )
                ->where('status', 'diambil')
                ->pluck('matkul_id');

            $jadwalUjians = JadwalUjian::query()
                ->with([
                    'mataKuliah.dosen.user',
                    'ruangan',
                    'tahunAkademik',
                ])
                ->whereIn('matkul_id', $matkulIds)
                ->where(
                    'tahun_akademik_id',
                    $tahunAkademikAktif->id
                )
                ->orderBy('tanggal')
                ->orderBy('jam_mulai')
                ->get();
        }

        return view(
            'mahasiswa.jadwal-ujian.index',
            compact(
                'jadwalUjians',
                'tahunAkademikAktif'
            )
        );
    }
}