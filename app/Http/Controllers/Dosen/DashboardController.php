<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use App\Models\Krs;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
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

        $jumlahMataKuliah = $dosen->mataKuliahs()->count();

        $mahasiswaDibimbing = Krs::query()
            ->whereHas('mataKuliah', function ($query) use ($dosen) {
                $query->where('dosen_id', $dosen->id);
            })
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
            ->where('status', 'diambil')
            ->distinct()
            ->count('mahasiswa_id');

        $jadwalHariIni = collect();

        if ($tahunAkademikAktif) {
            $namaHari = $this->namaHariIndonesia(
                now()->dayOfWeek
            );

            if ($namaHari !== 'Minggu') {
                $jadwalHariIni = JadwalKuliah::query()
                    ->with([
                        'mataKuliah',
                        'ruangan',
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
                    ->where(
                        'tahun_akademik_id',
                        $tahunAkademikAktif->id
                    )
                    ->where('hari', $namaHari)
                    ->orderBy('jam_mulai')
                    ->get();
            }
        }

        return view('dosen.dashboard', compact(
            'dosen',
            'tahunAkademikAktif',
            'jumlahMataKuliah',
            'mahasiswaDibimbing',
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
}