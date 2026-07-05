<?php

namespace App\Http\Controllers\Dosen;

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
            ->with('dosen')
            ->findOrFail($userId);

        $dosen = $user->dosen;

        abort_if(!$dosen, 404, 'Data dosen tidak ditemukan.');

        return view('dosen.profile.edit', compact(
            'user',
            'dosen'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $userId = Auth::id();

        abort_if(!$userId, 401, 'Silakan login terlebih dahulu.');

        $user = User::query()
            ->with('dosen')
            ->findOrFail($userId);

        $dosen = $user->dosen;

        abort_if(!$dosen, 404, 'Data dosen tidak ditemukan.');

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

            'jabatan' => [
                'nullable',
                'string',
                'max:255',
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
            $dosen
        ): void {
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = $validated['password'];
            }

            $user->save();

            $dosen->prodi = $validated['prodi'];
            $dosen->jabatan = $validated['jabatan'] ?? null;
            $dosen->telp = $validated['telp'] ?? null;
            $dosen->save();
        });

        return redirect()
            ->route('dosen.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}