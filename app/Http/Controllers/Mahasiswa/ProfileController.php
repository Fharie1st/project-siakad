<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $userId = Auth::id();

        abort_if(!$userId, 401, 'Silakan login terlebih dahulu.');

        $user = User::query()
            ->with('mahasiswa')
            ->findOrFail($userId);

        $mahasiswa = $user->mahasiswa;

        abort_if(
            !$mahasiswa,
            404,
            'Data mahasiswa tidak ditemukan.'
        );

        return view('mahasiswa.profile.edit', compact(
            'user',
            'mahasiswa'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $userId = Auth::id();

        abort_if(!$userId, 401, 'Silakan login terlebih dahulu.');

        $user = User::query()
            ->with('mahasiswa')
            ->findOrFail($userId);

        $mahasiswa = $user->mahasiswa;

        abort_if(
            !$mahasiswa,
            404,
            'Data mahasiswa tidak ditemukan.'
        );

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'prodi' => [
                'required',
                'string',
                'max:255',
            ],

            'alamat' => [
                'nullable',
                'string',
            ],

            'telp' => [
                'nullable',
                'string',
                'max:20',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $user,
            $mahasiswa
        ): void {
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = $validated['password'];
            }

            $user->save();

            $mahasiswa->prodi = $validated['prodi'];
            $mahasiswa->alamat = $validated['alamat'] ?? null;
            $mahasiswa->telp = $validated['telp'] ?? null;
            $mahasiswa->save();
        });

        return redirect()
            ->route('mahasiswa.profile.edit')
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }
}