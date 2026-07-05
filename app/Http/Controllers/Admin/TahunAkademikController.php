<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TahunAkademikController extends Controller
{
    public function index(): View
    {
        $tahunAkademiks = TahunAkademik::query()
            ->orderByDesc('tahun')
            ->orderBy('semester')
            ->paginate(10);

        return view(
            'admin.tahun-akademik.index',
            compact('tahunAkademiks')
        );
    }

    public function create(): View
    {
        return view('admin.tahun-akademik.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tahun' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\/\d{4}$/',
            ],
            'semester' => [
                'required',
                Rule::in(['Ganjil', 'Genap']),
            ],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        $exists = TahunAkademik::query()
            ->where('tahun', $validated['tahun'])
            ->where('semester', $validated['semester'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'tahun' => 'Tahun dan semester tersebut sudah tersedia.',
                ]);
        }

        DB::transaction(function () use ($validated) {
            $isAktif = (bool) ($validated['is_aktif'] ?? false);

            if ($isAktif) {
                TahunAkademik::query()->update([
                    'is_aktif' => false,
                ]);
            }

            TahunAkademik::create([
                'tahun' => $validated['tahun'],
                'semester' => $validated['semester'],
                'is_aktif' => $isAktif,
            ]);
        });

        return redirect()
            ->route('admin.tahun-akademik.index')
            ->with('success', 'Tahun akademik berhasil ditambahkan.');
    }

    public function show(
        TahunAkademik $tahunAkademik
    ): View {
        return view(
            'admin.tahun-akademik.show',
            compact('tahunAkademik')
        );
    }

    public function edit(
        TahunAkademik $tahunAkademik
    ): View {
        return view(
            'admin.tahun-akademik.edit',
            compact('tahunAkademik')
        );
    }

    public function update(
        Request $request,
        TahunAkademik $tahunAkademik
    ): RedirectResponse {
        $validated = $request->validate([
            'tahun' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\/\d{4}$/',
            ],
            'semester' => [
                'required',
                Rule::in(['Ganjil', 'Genap']),
            ],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        $exists = TahunAkademik::query()
            ->where('tahun', $validated['tahun'])
            ->where('semester', $validated['semester'])
            ->whereKeyNot($tahunAkademik->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'tahun' => 'Tahun dan semester tersebut sudah tersedia.',
                ]);
        }

        DB::transaction(function () use (
            $validated,
            $tahunAkademik
        ) {
            $isAktif = (bool) ($validated['is_aktif'] ?? false);

            if ($isAktif) {
                TahunAkademik::query()
                    ->whereKeyNot($tahunAkademik->id)
                    ->update([
                        'is_aktif' => false,
                    ]);
            }

            $tahunAkademik->update([
                'tahun' => $validated['tahun'],
                'semester' => $validated['semester'],
                'is_aktif' => $isAktif,
            ]);
        });

        return redirect()
            ->route('admin.tahun-akademik.index')
            ->with('success', 'Tahun akademik berhasil diperbarui.');
    }

    public function destroy(
        TahunAkademik $tahunAkademik
    ): RedirectResponse {
        if ($tahunAkademik->is_aktif) {
            return back()->with(
                'error',
                'Tahun akademik aktif tidak dapat dihapus.'
            );
        }

        if (
            $tahunAkademik->krs()->exists() ||
            $tahunAkademik->jadwalKuliahs()->exists() ||
            $tahunAkademik->jadwalUjians()->exists()
        ) {
            return back()->with(
                'error',
                'Tahun akademik tidak dapat dihapus karena sudah digunakan.'
            );
        }

        $tahunAkademik->delete();

        return redirect()
            ->route('admin.tahun-akademik.index')
            ->with('success', 'Tahun akademik berhasil dihapus.');
    }
}