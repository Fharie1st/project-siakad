<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DosenController as AdminDosenController;
use App\Http\Controllers\Admin\JadwalKuliahController as AdminJadwalKuliahController;
use App\Http\Controllers\Admin\JadwalUjianController as AdminJadwalUjianController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController as AdminMataKuliahController;
use App\Http\Controllers\Admin\RuanganController as AdminRuanganController;
use App\Http\Controllers\Admin\TahunAkademikController as AdminTahunAkademikController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\JadwalMengajarController as DosenJadwalMengajarController;
use App\Http\Controllers\Dosen\JadwalUjianController as DosenJadwalUjianController;
use App\Http\Controllers\Dosen\NilaiController as DosenNilaiController;
use App\Http\Controllers\Dosen\ProfileController as DosenProfileController;

use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\JadwalKuliahController as MahasiswaJadwalKuliahController;
use App\Http\Controllers\Mahasiswa\JadwalUjianController as MahasiswaJadwalUjianController;
use App\Http\Controllers\Mahasiswa\KhsController as MahasiswaKhsController;
use App\Http\Controllers\Mahasiswa\KrsController as MahasiswaKrsController;
use App\Http\Controllers\Mahasiswa\ProfileController as MahasiswaProfileController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'dosen' => redirect()->route('dosen.dashboard'),
        'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
        default => redirect()->route('login'),
    };
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // LOGIN
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.process');

    // REGISTER
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('mahasiswa', AdminMahasiswaController::class);

        Route::resource('dosen', AdminDosenController::class);

        Route::resource('mata-kuliah', AdminMataKuliahController::class)
            ->parameters(['mata-kuliah' => 'mataKuliah']);

        Route::resource('ruangan', AdminRuanganController::class);

        Route::resource('tahun-akademik', AdminTahunAkademikController::class)
            ->parameters(['tahun-akademik' => 'tahunAkademik']);

        Route::resource('jadwal-kuliah', AdminJadwalKuliahController::class)
            ->except(['show'])
            ->parameters(['jadwal-kuliah' => 'jadwalKuliah']);

        Route::resource('jadwal-ujian', AdminJadwalUjianController::class)
            ->except(['show'])
            ->parameters(['jadwal-ujian' => 'jadwalUjian']);
    });

/*
|--------------------------------------------------------------------------
| Dosen
|--------------------------------------------------------------------------
*/

Route::prefix('dosen')
    ->name('dosen.')
    ->middleware(['auth', 'role:dosen'])
    ->group(function () {

        Route::get('/dashboard', [DosenDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/profile', [DosenProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [DosenProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/jadwal-mengajar', [DosenJadwalMengajarController::class, 'index'])
            ->name('jadwal-mengajar.index');

        Route::get('/jadwal-ujian', [DosenJadwalUjianController::class, 'index'])
            ->name('jadwal-ujian.index');

        Route::get('/nilai', [DosenNilaiController::class, 'index'])
            ->name('nilai.index');

        Route::get('/nilai/{mataKuliah}/edit', [DosenNilaiController::class, 'edit'])
            ->name('nilai.edit');

        Route::put('/nilai/{mataKuliah}', [DosenNilaiController::class, 'update'])
            ->name('nilai.update');
    });

/*
|--------------------------------------------------------------------------
| Mahasiswa
|--------------------------------------------------------------------------
*/

Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/profile', [MahasiswaProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [MahasiswaProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/krs', [MahasiswaKrsController::class, 'index'])
            ->name('krs.index');
        
        Route::get('/krs/pdf', [MahasiswaKrsController::class, 'pdf'])
            ->name('krs.pdf');

        Route::post('/krs/{mataKuliah}/ambil', [MahasiswaKrsController::class, 'ambil'])
            ->name('krs.ambil');

        Route::patch('/krs/{mataKuliah}/batal', [MahasiswaKrsController::class, 'batal'])
            ->name('krs.batal');

        Route::get('/khs', [MahasiswaKhsController::class, 'index'])
            ->name('khs.index');
        
        Route::get('/khs/pdf', [MahasiswaKhsController::class, 'pdf'])
            ->name('khs.pdf');

        Route::get('/jadwal-kuliah', [MahasiswaJadwalKuliahController::class, 'index'])
            ->name('jadwal-kuliah.index');
        
        Route::get('/jadwal-kuliah/pdf', [MahasiswaJadwalKuliahController::class, 'cetakPdf'])
            ->name('jadwal-kuliah.pdf');

        Route::get('/jadwal-ujian', [MahasiswaJadwalUjianController::class, 'index'])
            ->name('jadwal-ujian.index');
    });