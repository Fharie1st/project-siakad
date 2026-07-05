<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalUjianController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        abort_if(!$user, 401, 'Silakan login terlebih dahulu.');

        $dosen = $user->dosen;

        abort_if(!$dosen, 404, 'Data dosen tidak ditemukan.');

        $tahunAkademikAktif = TahunAkademik::query()
            ->where('is_aktif', true)
            ->first();

        $jadwalUjians = JadwalUjian::query()
            ->with([
                'mataKuliah',
                'ruangan',
                'tahunAkademik',
            ])
            ->whereHas(
                'mataKuliah',
                function ($query) use ($dosen) {
                    $query->where(
                        'dosen_id',
                        $dosen->id
                    );
                }
            )
            ->when(
                $tahunAkademikAktif,
                function ($query) use ($tahunAkademikAktif) {
                    $query->where(
                        'tahun_akademik_id',
                        $tahunAkademikAktif->id
                    );
                },
                function ($query) {
                    $query->whereRaw('1 = 0');
                }
            )
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view(
            'dosen.jadwal-ujian.index',
            compact(
                'jadwalUjians',
                'tahunAkademikAktif'
            )
        );
    }
}