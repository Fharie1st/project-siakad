<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(): View
    {
        $mataKuliahs = MataKuliah::query()
            ->with('dosen.user')
            ->orderBy('semester')
            ->orderBy('kode')
            ->paginate(10);

        return view(
            'admin.mata-kuliah.index',
            compact('mataKuliahs')
        );
    }

    public function create(): View
    {
        $dosens = Dosen::query()
            ->with('user')
            ->orderBy('nidn')
            ->get();

        return view(
            'admin.mata-kuliah.create',
            compact('dosens')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:30',
                'unique:mata_kuliahs,kode',
            ],
            'nama' => ['required', 'string', 'max:255'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'dosen_id' => [
                'nullable',
                'exists:dosens,id',
            ],
        ]);

        MataKuliah::create($validated);

        return redirect()
            ->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function show(MataKuliah $mataKuliah): View
    {
        $mataKuliah->load('dosen.user');

        return view(
            'admin.mata-kuliah.show',
            compact('mataKuliah')
        );
    }

    public function edit(MataKuliah $mataKuliah): View
    {
        $dosens = Dosen::query()
            ->with('user')
            ->orderBy('nidn')
            ->get();

        return view(
            'admin.mata-kuliah.edit',
            compact('mataKuliah', 'dosens')
        );
    }

    public function update(
        Request $request,
        MataKuliah $mataKuliah
    ): RedirectResponse {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:30',
                Rule::unique('mata_kuliahs', 'kode')
                    ->ignore($mataKuliah->id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'dosen_id' => [
                'nullable',
                'exists:dosens,id',
            ],
        ]);

        $mataKuliah->update($validated);

        return redirect()
            ->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(
        MataKuliah $mataKuliah
    ): RedirectResponse {
        if (
            $mataKuliah->krs()->exists() ||
            $mataKuliah->jadwalKuliahs()->exists() ||
            $mataKuliah->jadwalUjians()->exists()
        ) {
            return back()->with(
                'error',
                'Mata kuliah tidak dapat dihapus karena sudah digunakan.'
            );
        }

        $mataKuliah->delete();

        return redirect()
            ->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus.');
    }
}