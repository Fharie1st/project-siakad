<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\TahunAkademik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Services\SmartScheduleService;

class JadwalUjianController extends Controller
{
    public function index(): View
    {
        $jadwalUjians = JadwalUjian::query()
            ->with([
                'mataKuliah.dosen.user',
                'ruangan',
                'tahunAkademik',
            ])
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view(
            'admin.jadwal-ujian.index',
            compact('jadwalUjians')
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
            'admin.jadwal-ujian.create',
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
            'jenis' => [
                'required',
                Rule::in(['UTS', 'UAS']),
            ],
            'tanggal' => ['required', 'date'],
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

        $sudahAda = JadwalUjian::query()
            ->where('matkul_id', $validated['matkul_id'])
            ->where(
                'tahun_akademik_id',
                $validated['tahun_akademik_id']
            )
            ->where('jenis', $validated['jenis'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'jenis' => 'Jadwal ujian mata kuliah tersebut sudah tersedia.',
                ]);
        }

        $bentrokRuangan = JadwalUjian::query()
            ->where('ruangan_id', $validated['ruangan_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where(function ($query) use ($validated) {
                $query
                    ->where('jam_mulai', '<', $validated['jam_selesai'])
                    ->where('jam_selesai', '>', $validated['jam_mulai']);
            })
            ->exists();

        if ($bentrokRuangan) {

    $smart = new SmartScheduleService();

    $rekomendasi = $smart->rekomendasiUjian($validated);

    if ($rekomendasi) {

        return back()
            ->withInput()
            ->withErrors([
                'ruangan_id' =>
                    "❌ Ruangan sudah dipakai.<br><br>" .
                    "<b>=== REKOMENDASI SISTEM ===</b><br>" .
                    "📅 Tanggal : <b>{$rekomendasi['tanggal']}</b><br>" .
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

        JadwalUjian::create($validated);

        return redirect()
            ->route('admin.jadwal-ujian.index')
            ->with('success', 'Jadwal ujian berhasil dibuat.');
    }

    public function edit(JadwalUjian $jadwalUjian): View
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
            'admin.jadwal-ujian.edit',
            compact(
                'jadwalUjian',
                'mataKuliahs',
                'ruangans',
                'tahunAkademiks'
            )
        );
    }

    public function update(
        Request $request,
        JadwalUjian $jadwalUjian
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
            'jenis' => [
                'required',
                Rule::in(['UTS', 'UAS']),
            ],
            'tanggal' => ['required', 'date'],
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

        $sudahAda = JadwalUjian::query()
            ->whereKeyNot($jadwalUjian->id)
            ->where('matkul_id', $validated['matkul_id'])
            ->where(
                'tahun_akademik_id',
                $validated['tahun_akademik_id']
            )
            ->where('jenis', $validated['jenis'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'jenis' => 'Jadwal ujian mata kuliah tersebut sudah tersedia.',
                ]);
        }

        $bentrokRuangan = JadwalUjian::query()
            ->whereKeyNot($jadwalUjian->id)
            ->where('ruangan_id', $validated['ruangan_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where(function ($query) use ($validated) {
                $query
                    ->where('jam_mulai', '<', $validated['jam_selesai'])
                    ->where('jam_selesai', '>', $validated['jam_mulai']);
            })
            ->exists();

        if ($bentrokRuangan) {

    $smart = new SmartScheduleService();

    $rekomendasi = $smart->rekomendasiUjian($validated);

    if ($rekomendasi) {

        return back()
            ->withInput()
            ->withErrors([
                'ruangan_id' =>
                    "❌ Ruangan sudah dipakai.<br><br>" .
                    "<b>=== REKOMENDASI SISTEM ===</b><br>" .
                    "📅 Tanggal : <b>{$rekomendasi['tanggal']}</b><br>" .
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

        $jadwalUjian->update($validated);

        return redirect()
            ->route('admin.jadwal-ujian.index')
            ->with('success', 'Jadwal ujian berhasil diperbarui.');
    }

    public function destroy(
        JadwalUjian $jadwalUjian
    ): RedirectResponse {
        $jadwalUjian->delete();

        return redirect()
            ->route('admin.jadwal-ujian.index')
            ->with('success', 'Jadwal ujian berhasil dihapus.');
    }
}