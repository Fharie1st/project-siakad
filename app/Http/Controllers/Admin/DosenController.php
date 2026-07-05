<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(): View
    {
        $dosens = Dosen::query()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('admin.dosen.index', compact('dosens'));
    }

    public function create(): View
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nidn' => ['required', 'string', 'max:30', 'unique:dosens,nidn'],
            'prodi' => ['required', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'telp' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'dosen',
            ]);

            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $validated['nidn'],
                'prodi' => $validated['prodi'],
                'jabatan' => $validated['jabatan'] ?? null,
                'telp' => $validated['telp'] ?? null,
                'foto' => null,
            ]);
        });

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function show(Dosen $dosen): View
    {
        $dosen->load('user');

        return view('admin.dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen): View
    {
        $dosen->load('user');

        return view('admin.dosen.edit', compact('dosen'));
    }

    public function update(
        Request $request,
        Dosen $dosen
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($dosen->user_id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'nidn' => [
                'required',
                'string',
                'max:30',
                Rule::unique('dosens', 'nidn')
                    ->ignore($dosen->id),
            ],

            'prodi' => ['required', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'telp' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated, $dosen) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            $dosen->user->update($userData);

            $dosen->update([
                'nidn' => $validated['nidn'],
                'prodi' => $validated['prodi'],
                'jabatan' => $validated['jabatan'] ?? null,
                'telp' => $validated['telp'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        if ($dosen->mataKuliahs()->exists()) {
            return back()->with(
                'error',
                'Dosen tidak dapat dihapus karena masih memiliki mata kuliah.'
            );
        }

        DB::transaction(function () use ($dosen) {
            $user = $dosen->user;

            $dosen->delete();
            $user?->delete();
        });

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }
}