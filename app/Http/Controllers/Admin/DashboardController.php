<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TahunAkademik;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalMataKuliah = MataKuliah::count();

        $tahunAkademikAktif = TahunAkademik::query()
            ->where('is_aktif', true)
            ->first();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalMataKuliah',
            'tahunAkademikAktif'
        ));
    }
}