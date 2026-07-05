<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\TahunAkademik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Services\SmartScheduleService;

class JadwalKuliahController extends Controller
{
    public function index(): View
    {
        $jadwalKuliahs = JadwalKuliah::query()
            ->with([
                'mataKuliah.dosen.user',
                'ruangan',
                'tahunAkademik',
            ])
            ->orderByRaw(
                "FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')"
            )
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view(
            'admin.jadwal-kuliah.index',
            compact('jadwalKuliahs')
        );
    }

    public function create(): View
    {
        $mataKuliahs = MataKuliah::query()
            ->orderBy('kode')
            ->get();

        $ruangans = Ruangan::query()
            ->orderBy('kode')
            ->get();

        $tahunAkademiks = TahunAkademik::query()
            ->orderByDesc('is_aktif')
            ->orderByDesc('tahun')
            ->get();

        return view(
            'admin.jadwal-kuliah.create',
            compact(
                'mataKuliahs',
                'ruangans',
                'tahunAkademiks'
            )
        );
    }

    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'matkul_id' => [
            'required',
            'exists:mata_kuliahs,id',
        ],
        'ruangan_id' => [
            'required',
            'exists:ruangans,id',
        ],
        'tahun_akademik_id' => [
            'required',
            'exists:tahun_akademiks,id',
        ],
        'hari' => [
            'required',
            Rule::in([
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
            ]),
        ],
        'jam_mulai' => [
            'required',
            'date_format:H:i',
        ],
        'jam_selesai' => [
            'required',
            'date_format:H:i',
            'after:jam_mulai',
        ],
    ]);

    $bentrokRuangan = JadwalKuliah::query()
        ->where('ruangan_id', $validated['ruangan_id'])
        ->where('tahun_akademik_id', $validated['tahun_akademik_id'])
        ->where('hari', $validated['hari'])
        ->where(function ($query) use ($validated) {
            $query
                ->where('jam_mulai', '<', $validated['jam_selesai'])
                ->where('jam_selesai', '>', $validated['jam_mulai']);
        })
        ->exists();

    if ($bentrokRuangan) {

    $smart = new SmartScheduleService();

    $rekomendasi = $smart->rekomendasiKuliah($validated);

    if ($rekomendasi) {

        return back()
    ->withInput()
    ->withErrors([
        'ruangan_id' =>
            "❌ Ruangan sudah dipakai.<br><br>" .
            "<b>=== REKOMENDASI SISTEM ===</b><br>" .
            "📅 Hari : <b>{$rekomendasi['hari']}</b><br>" .
            "🕒 Jam : <b>{$rekomendasi['jam_mulai']} - {$rekomendasi['jam_selesai']}</b><br>" .
            "🏫 Ruangan : <b>{$rekomendasi['ruangan']}</b><br>" .
            "💡 Alasan : {$rekomendasi['alasan']}",
    ]);
    }

    return back()
        ->withInput()
        ->withErrors([
            'ruangan_id' =>
                'Ruangan sudah dipakai dan sistem tidak menemukan jadwal alternatif.',
        ]);
}

        JadwalKuliah::create($validated);

        return redirect()
            ->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil dibuat.');
    }

    public function edit(JadwalKuliah $jadwalKuliah): View
    {
        $mataKuliahs = MataKuliah::query()
            ->orderBy('kode')
            ->get();

        $ruangans = Ruangan::query()
            ->orderBy('kode')
            ->get();

        $tahunAkademiks = TahunAkademik::query()
            ->orderByDesc('is_aktif')
            ->orderByDesc('tahun')
            ->get();

        return view(
            'admin.jadwal-kuliah.edit',
            compact(
                'jadwalKuliah',
                'mataKuliahs',
                'ruangans',
                'tahunAkademiks'
            )
        );
    }

    public function update(
        Request $request,
        JadwalKuliah $jadwalKuliah
    ): RedirectResponse {
        $validated = $request->validate([
            'matkul_id' => [
                'required',
                'exists:mata_kuliahs,id',
            ],
            'ruangan_id' => [
                'required',
                'exists:ruangans,id',
            ],
            'tahun_akademik_id' => [
                'required',
                'exists:tahun_akademiks,id',
            ],
            'hari' => [
                'required',
                Rule::in([
                    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu',
                ]),
            ],
            'jam_mulai' => [
                'required',
                'date_format:H:i',
            ],
            'jam_selesai' => [
                'required',
                'date_format:H:i',
                'after:jam_mulai',
            ],
        ]);

        $bentrokRuangan = JadwalKuliah::query()
            ->whereKeyNot($jadwalKuliah->id)
            ->where('ruangan_id', $validated['ruangan_id'])
            ->where(
                'tahun_akademik_id',
                $validated['tahun_akademik_id']
            )
            ->where('hari', $validated['hari'])
            ->where(function ($query) use ($validated) {
                $query
                    ->where('jam_mulai', '<', $validated['jam_selesai'])
                    ->where('jam_selesai', '>', $validated['jam_mulai']);
            })
            ->exists();

        if ($bentrokRuangan) {
            return back()
                ->withInput()
                ->withErrors([
                    'ruangan_id' => 'Ruangan sudah dipakai pada waktu tersebut.',
                ]);
        }

        $jadwalKuliah->update($validated);

        return redirect()
            ->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil diperbarui.');
    }

    public function destroy(
        JadwalKuliah $jadwalKuliah
    ): RedirectResponse {
        $jadwalKuliah->delete();

        return redirect()
            ->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil dihapus.');
    }
}