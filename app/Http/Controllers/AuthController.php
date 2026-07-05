<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $request->session()->regenerate();

        return $this->redirectByRole(Auth::user()->role);
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        
        
        $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:mahasiswa,dosen',
            ];

            if ($request->role == 'mahasiswa') {
                $rules['nim'] = 'required|unique:mahasiswas,nim';
                $rules['prodi'] = 'required';
                $rules['angkatan'] = 'required';
            } else {
                $rules['nidn'] = 'required|unique:dosens,nidn';
                $rules['prodi'] = 'required';
                $rules['jabatan'] = 'nullable';
            }

            $data = $request->validate($rules);


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        if ($data['role'] === 'mahasiswa') {

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $data['nim'],
                'prodi' => $data['prodi'],
                'angkatan' => $data['angkatan'],
                'alamat' => null,
                'telp' => null,
                'foto' => null,
            ]);

        } else {

            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $data['nidn'],
                'prodi' => $data['prodi'],
                'jabatan' => $data['jabatan'] ?? null,
                'telp' => null,
                'foto' => null,
            ]);

        }

        Auth::login($user);

        $request->session()->regenerate();

        return $this->redirectByRole($user->role);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectByRole(string $role): RedirectResponse
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dosen' => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default => redirect()->route('login'),
        };
    }
}