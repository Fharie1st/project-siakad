@extends('layouts.app')

@section('title', 'Dashboard Dosen')
@section('page-title', 'Dashboard Dosen')
@section('page-description', 'Ringkasan kegiatan akademik dan jadwal mengajar.')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="border border-gray-200 bg-white p-5">
            <p class="text-sm text-gray-500">
                Mata Kuliah Diampu
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $jumlahMataKuliah }}
            </p>

            <a
                href="{{ route('dosen.jadwal-mengajar.index') }}"
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Lihat jadwal mengajar
            </a>
        </div>

        <div class="border border-gray-200 bg-white p-5">
            <p class="text-sm text-gray-500">
                Jumlah Mahasiswa
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ $mahasiswaDibimbing }}
            </p>

            <a
                href="{{ route('dosen.nilai.index') }}"
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Kelola nilai
            </a>
        </div>

        <div class="border border-gray-200 bg-white p-5">
            <p class="text-sm text-gray-500">
                Semester Aktif
            </p>

            @if ($tahunAkademikAktif)
                <p class="mt-2 text-xl font-bold text-gray-800">
                    {{ $tahunAkademikAktif->tahun }}
                </p>

                <p class="mt-1 text-sm text-blue-600">
                    {{ $tahunAkademikAktif->semester }}
                </p>
            @else
                <p class="mt-2 text-sm font-medium text-red-600">
                    Belum tersedia
                </p>
            @endif
        </div>
    </div>

    <div class="mt-6 border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                Jadwal Mengajar Hari Ini
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Jadwal mata kuliah yang perlu Anda ajar hari ini.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">
                            Waktu
                        </th>

                        <th class="px-4 py-3 text-left font-medium text-gray-600">
                            Mata Kuliah
                        </th>

                        <th class="px-4 py-3 text-left font-medium text-gray-600">
                            Ruangan
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($jadwalHariIni as $jadwal)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                {{ substr($jadwal->jam_mulai, 0, 5) }}
                                -
                                {{ substr($jadwal->jam_selesai, 0, 5) }}
                            </td>

                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">
                                    {{ $jadwal->mataKuliah->nama }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $jadwal->mataKuliah->kode }}
                                </p>
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $jadwal->ruangan?->kode ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="3"
                                class="px-4 py-8 text-center text-gray-500"
                            >
                                Tidak ada jadwal mengajar hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection