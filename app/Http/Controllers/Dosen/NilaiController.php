<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\TahunAkademik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NilaiController extends Controller
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

        $mataKuliahs = MataKuliah::query()
            ->where('dosen_id', $dosen->id)
            ->withCount([
                'krs as jumlah_mahasiswa' => function ($query) use (
                    $tahunAkademikAktif
                ) {
                    $query->where('status', 'diambil');

                    if ($tahunAkademikAktif) {
                        $query->where(
                            'tahun_akademik_id',
                            $tahunAkademikAktif->id
                        );
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                },
            ])
            ->orderBy('kode')
            ->paginate(10);

        return view(
            'dosen.nilai.index',
            compact(
                'mataKuliahs',
                'tahunAkademikAktif'
            )
        );
    }

    public function edit(MataKuliah $mataKuliah): View
    {
        $user = Auth::user();

        abort_if(!$user, 401, 'Silakan login terlebih dahulu.');

        $dosen = $user->dosen;

        abort_if(!$dosen, 404, 'Data dosen tidak ditemukan.');

        abort_if(
            $mataKuliah->dosen_id !== $dosen->id,
            403,
            'Anda tidak memiliki akses ke mata kuliah ini.'
        );

        $tahunAkademikAktif = TahunAkademik::query()
            ->where('is_aktif', true)
            ->first();

        $dataKrs = collect();

        if ($tahunAkademikAktif) {
            $dataKrs = Krs::query()
                ->with([
                    'mahasiswa.user',
                    'nilai',
                ])
                ->where('matkul_id', $mataKuliah->id)
                ->where(
                    'tahun_akademik_id',
                    $tahunAkademikAktif->id
                )
                ->where('status', 'diambil')
                ->orderBy(
                    Mahasiswa::query()
                        ->select('nim')
                        ->whereColumn(
                            'mahasiswas.id',
                            'krs.mahasiswa_id'
                        )
                )
                ->get();
        }

        return view(
            'dosen.nilai.edit',
            compact(
                'mataKuliah',
                'tahunAkademikAktif',
                'dataKrs'
            )
        );
    }

    public function update(
        Request $request,
        MataKuliah $mataKuliah
    ): RedirectResponse {
        $user = Auth::user();

        abort_if(!$user, 401, 'Silakan login terlebih dahulu.');

        $dosen = $user->dosen;

        abort_if(!$dosen, 404, 'Data dosen tidak ditemukan.');

        abort_if(
            $mataKuliah->dosen_id !== $dosen->id,
            403,
            'Anda tidak memiliki akses ke mata kuliah ini.'
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

        $validated = $request->validate([
            'nilai' => [
                'required',
                'array',
            ],

            'nilai.*.krs_id' => [
                'required',
                'integer',
                'exists:krs,id',
            ],

            'nilai.*.nilai_uts' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'nilai.*.nilai_uas' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'nilai.*.nilai_tugas' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $mataKuliah,
            $tahunAkademikAktif
        ) {
            foreach ($validated['nilai'] as $item) {
                $krs = Krs::query()
                    ->whereKey($item['krs_id'])
                    ->where(
                        'matkul_id',
                        $mataKuliah->id
                    )
                    ->where(
                        'tahun_akademik_id',
                        $tahunAkademikAktif->id
                    )
                    ->where('status', 'diambil')
                    ->firstOrFail();

                $nilaiUts = $item['nilai_uts'] ?? null;
                $nilaiUas = $item['nilai_uas'] ?? null;
                $nilaiTugas = $item['nilai_tugas'] ?? null;

                $nilaiAkhir = null;
                $grade = null;

                if (
                    $nilaiUts !== null &&
                    $nilaiUas !== null &&
                    $nilaiTugas !== null
                ) {
                    $nilaiAkhir = round(
                        ((float) $nilaiUts * 0.30) +
                        ((float) $nilaiUas * 0.40) +
                        ((float) $nilaiTugas * 0.30),
                        2
                    );

                    $grade = $this->tentukanGrade(
                        $nilaiAkhir
                    );
                }

                Nilai::updateOrCreate(
                    [
                        'krs_id' => $krs->id,
                    ],
                    [
                        'nilai_uts' => $nilaiUts,
                        'nilai_uas' => $nilaiUas,
                        'nilai_tugas' => $nilaiTugas,
                        'nilai_akhir' => $nilaiAkhir,
                        'grade' => $grade,
                    ]
                );
            }
        });

        return redirect()
            ->route(
                'dosen.nilai.edit',
                $mataKuliah
            )
            ->with(
                'success',
                'Nilai mahasiswa berhasil disimpan.'
            );
    }

    private function tentukanGrade(float $nilai): string
    {
        return match (true) {
            $nilai >= 85 => 'A',
            $nilai >= 80 => 'B+',
            $nilai >= 75 => 'B',
            $nilai >= 70 => 'C+',
            $nilai >= 65 => 'C',
            $nilai >= 55 => 'D',
            default => 'E',
        };
    }
}