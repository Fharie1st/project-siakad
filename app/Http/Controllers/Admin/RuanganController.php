<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RuanganController extends Controller
{
    public function index(): View
    {
        $ruangans = Ruangan::query()
            ->orderBy('gedung')
            ->orderBy('kode')
            ->paginate(10);

        return view('admin.ruangan.index', compact('ruangans'));
    }

    public function create(): View
    {
        return view('admin.ruangan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:30',
                'unique:ruangans,kode',
            ],
            'kapasitas' => [
                'required',
                'integer',
                'min:1',
                'max:1000',
            ],
            'gedung' => ['required', 'string', 'max:255'],
        ]);

        Ruangan::create($validated);

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function show(Ruangan $ruangan): View
    {
        return view('admin.ruangan.show', compact('ruangan'));
    }

    public function edit(Ruangan $ruangan): View
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    public function update(
        Request $request,
        Ruangan $ruangan
    ): RedirectResponse {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:30',
                Rule::unique('ruangans', 'kode')
                    ->ignore($ruangan->id),
            ],
            'kapasitas' => [
                'required',
                'integer',
                'min:1',
                'max:1000',
            ],
            'gedung' => ['required', 'string', 'max:255'],
        ]);

        $ruangan->update($validated);

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan): RedirectResponse
    {
        if (
            $ruangan->jadwalKuliahs()->exists() ||
            $ruangan->jadwalUjians()->exists()
        ) {
            return back()->with(
                'error',
                'Ruangan tidak dapat dihapus karena masih digunakan.'
            );
        }

        $ruangan->delete();

        return redirect()
            ->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}