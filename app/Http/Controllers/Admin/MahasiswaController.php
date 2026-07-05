<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        $mahasiswas = Mahasiswa::query()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function create(): View
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nim' => ['required', 'string', 'max:30', 'unique:mahasiswas,nim'],
            'prodi' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'integer', 'digits:4'],
            'alamat' => ['nullable', 'string'],
            'telp' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'prodi' => $validated['prodi'],
                'angkatan' => $validated['angkatan'],
                'alamat' => $validated['alamat'] ?? null,
                'telp' => $validated['telp'] ?? null,
                'foto' => null,
            ]);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load('user');

        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        $mahasiswa->load('user');

        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(
        Request $request,
        Mahasiswa $mahasiswa
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($mahasiswa->user_id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'nim' => [
                'required',
                'string',
                'max:30',
                Rule::unique('mahasiswas', 'nim')
                    ->ignore($mahasiswa->id),
            ],

            'prodi' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'integer', 'digits:4'],
            'alamat' => ['nullable', 'string'],
            'telp' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated, $mahasiswa) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            $mahasiswa->user->update($userData);

            $mahasiswa->update([
                'nim' => $validated['nim'],
                'prodi' => $validated['prodi'],
                'angkatan' => $validated['angkatan'],
                'alamat' => $validated['alamat'] ?? null,
                'telp' => $validated['telp'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        DB::transaction(function () use ($mahasiswa) {
            $user = $mahasiswa->user;

            $mahasiswa->delete();
            $user?->delete();
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}