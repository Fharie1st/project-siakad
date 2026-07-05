<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Nilai;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            /*
            |--------------------------------------------------------------------------
            | Admin
            |--------------------------------------------------------------------------
            */

            User::create([
                'name' => 'Administrator',
                'email' => 'admin@siakad.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Dosen
            |--------------------------------------------------------------------------
            */

            $userDosen1 = User::create([
                'name' => 'Budi Santoso',
                'email' => 'dosen1@siakad.com',
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);

            $dosen1 = Dosen::create([
                'user_id' => $userDosen1->id,
                'nidn' => '0123456789',
                'prodi' => 'Informatika',
                'jabatan' => 'Dosen Tetap',
                'telp' => '081234567801',
                'foto' => null,
            ]);

            $userDosen2 = User::create([
                'name' => 'Siti Rahma',
                'email' => 'dosen2@siakad.com',
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);

            $dosen2 = Dosen::create([
                'user_id' => $userDosen2->id,
                'nidn' => '0123456790',
                'prodi' => 'Informatika',
                'jabatan' => 'Asisten Ahli',
                'telp' => '081234567802',
                'foto' => null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Mahasiswa
            |--------------------------------------------------------------------------
            */

            $dataMahasiswa = [
                [
                    'name' => 'Andi Pratama',
                    'email' => 'mhs1@siakad.com',
                    'nim' => '23010001',
                    'prodi' => 'Informatika',
                    'angkatan' => 2023,
                    'alamat' => 'Jakarta',
                    'telp' => '081234567811',
                ],
                [
                    'name' => 'Rina Oktavia',
                    'email' => 'mhs2@siakad.com',
                    'nim' => '23010002',
                    'prodi' => 'Informatika',
                    'angkatan' => 2023,
                    'alamat' => 'Bandung',
                    'telp' => '081234567812',
                ],
                [
                    'name' => 'Dimas Saputra',
                    'email' => 'mhs3@siakad.com',
                    'nim' => '23010003',
                    'prodi' => 'Informatika',
                    'angkatan' => 2023,
                    'alamat' => 'Bogor',
                    'telp' => '081234567813',
                ],
                [
                    'name' => 'Nadia Putri',
                    'email' => 'mhs4@siakad.com',
                    'nim' => '23010004',
                    'prodi' => 'Informatika',
                    'angkatan' => 2023,
                    'alamat' => 'Depok',
                    'telp' => '081234567814',
                ],
                [
                    'name' => 'Fajar Ramadhan',
                    'email' => 'mhs5@siakad.com',
                    'nim' => '23010005',
                    'prodi' => 'Informatika',
                    'angkatan' => 2023,
                    'alamat' => 'Tangerang',
                    'telp' => '081234567815',
                ],
            ];

            $mahasiswas = collect();

            foreach ($dataMahasiswa as $data) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make('password'),
                    'role' => 'mahasiswa',
                ]);

                $mahasiswa = Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $data['nim'],
                    'prodi' => $data['prodi'],
                    'angkatan' => $data['angkatan'],
                    'alamat' => $data['alamat'],
                    'telp' => $data['telp'],
                    'foto' => null,
                ]);

                $mahasiswas->push($mahasiswa);
            }

            /*
            |--------------------------------------------------------------------------
            | Tahun Akademik
            |--------------------------------------------------------------------------
            */

            $tahunAkademik = TahunAkademik::create([
                'tahun' => '2025/2026',
                'semester' => 'Genap',
                'is_aktif' => true,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Mata Kuliah
            |--------------------------------------------------------------------------
            */

            $pemrogramanWeb = MataKuliah::create([
                'kode' => 'IF201',
                'nama' => 'Pemrograman Web',
                'sks' => 3,
                'semester' => 2,
                'dosen_id' => $dosen1->id,
            ]);

            $basisData = MataKuliah::create([
                'kode' => 'IF202',
                'nama' => 'Basis Data',
                'sks' => 3,
                'semester' => 2,
                'dosen_id' => $dosen1->id,
            ]);

            $strukturData = MataKuliah::create([
                'kode' => 'IF203',
                'nama' => 'Struktur Data',
                'sks' => 3,
                'semester' => 2,
                'dosen_id' => $dosen2->id,
            ]);

            $jaringanKomputer = MataKuliah::create([
                'kode' => 'IF204',
                'nama' => 'Jaringan Komputer',
                'sks' => 3,
                'semester' => 2,
                'dosen_id' => $dosen2->id,
            ]);

            $mataKuliahs = collect([
                $pemrogramanWeb,
                $basisData,
                $strukturData,
                $jaringanKomputer,
            ]);

            /*
            |--------------------------------------------------------------------------
            | KRS dan Nilai
            |--------------------------------------------------------------------------
            */

            foreach ($mahasiswas as $indexMahasiswa => $mahasiswa) {
                foreach ($mataKuliahs as $indexMatkul => $mataKuliah) {
                    $krs = Krs::create([
                        'mahasiswa_id' => $mahasiswa->id,
                        'matkul_id' => $mataKuliah->id,
                        'tahun_akademik_id' => $tahunAkademik->id,
                        'status' => 'diambil',
                    ]);

                    $nilaiUts = 75 + $indexMahasiswa + $indexMatkul;
                    $nilaiUas = 78 + $indexMahasiswa + $indexMatkul;
                    $nilaiTugas = 80 + $indexMahasiswa + $indexMatkul;

                    $nilaiAkhir = round(
                        ($nilaiUts * 0.30) +
                        ($nilaiUas * 0.40) +
                        ($nilaiTugas * 0.30),
                        2
                    );

                    Nilai::create([
                        'krs_id' => $krs->id,
                        'nilai_uts' => $nilaiUts,
                        'nilai_uas' => $nilaiUas,
                        'nilai_tugas' => $nilaiTugas,
                        'nilai_akhir' => $nilaiAkhir,
                        'grade' => $this->tentukanGrade($nilaiAkhir),
                    ]);
                }
            }
        });
    }

    private function tentukanGrade(float $nilai): string
    {
        return match (true) {
            $nilai >= 85 => 'A',
            $nilai >= 80 => 'B+',
            $nilai >= 75 => 'B',
            $nilai >= 70 => 'C+',
            $nilai >= 65 => 'C',
            $nilai >= 55 => 'D',
            default => 'E',
        };
    }
}