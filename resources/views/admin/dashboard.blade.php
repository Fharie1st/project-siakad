@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-description', 'Ringkasan data sistem akademik.')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="border border-gray-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Total Mahasiswa
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalMahasiswa }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-md bg-blue-50 text-blue-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-6 w-6"
                    >
                        <path d="M11.7 1.805a.75.75 0 0 1 .6 0l9 4.5a.75.75 0 0 1 0 1.34l-9 4.5a.75.75 0 0 1-.6 0l-9-4.5a.75.75 0 0 1 0-1.34l9-4.5Z" />
                        <path d="M3.75 10.2v5.35c0 .495.24.96.645 1.245 1.665 1.17 4.035 2.205 7.605 2.205s5.94-1.035 7.605-2.205c.405-.285.645-.75.645-1.245V10.2l-7.275 3.638a2.25 2.25 0 0 1-1.95 0L3.75 10.2Z" />
                    </svg>
                </div>
            </div>

            <a
                href="{{ route('admin.mahasiswa.index') }}"
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Lihat mahasiswa
            </a>
        </div>

        <div class="border border-gray-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Total Dosen
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalDosen }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-md bg-blue-50 text-blue-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-6 w-6"
                    >
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM3.75 20.105a8.25 8.25 0 0 1 16.5 0 .75.75 0 0 1-.437.681A18.683 18.683 0 0 1 12 22.5a18.683 18.683 0 0 1-7.813-1.714.75.75 0 0 1-.437-.681Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <a
                href="{{ route('admin.dosen.index') }}"
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Lihat dosen
            </a>
        </div>

        <div class="border border-gray-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">
                        Total Mata Kuliah
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalMataKuliah }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-md bg-blue-50 text-blue-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-6 w-6"
                    >
                        <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.82.707 5.25 1.887V4.533Z" />
                        <path d="M12.75 4.533v16.104A8.237 8.237 0 0 1 18 18.75c.968 0 1.897.166 2.75.469a.75.75 0 0 0 1-.707V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533Z" />
                    </svg>
                </div>
            </div>

            <a
                href="{{ route('admin.mata-kuliah.index') }}"
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Lihat mata kuliah
            </a>
        </div>

        <div class="border border-gray-200 bg-white p-5">
            <div>
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
                        Belum ditentukan
                    </p>
                @endif
            </div>

            <a
                href="{{ route('admin.tahun-akademik.index') }}"
                class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Kelola tahun akademik
            </a>
        </div>
    </div>

    <div class="mt-6 border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                Menu Cepat
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Akses cepat untuk mengelola data akademik.
            </p>
        </div>

        <div class="grid gap-3 p-5 sm:grid-cols-2 lg:grid-cols-3">
            <a
                href="{{ route('admin.mahasiswa.create') }}"
                class="border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
            >
                Tambah Mahasiswa
            </a>

            <a
                href="{{ route('admin.dosen.create') }}"
                class="border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
            >
                Tambah Dosen
            </a>

            <a
                href="{{ route('admin.mata-kuliah.create') }}"
                class="border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
            >
                Tambah Mata Kuliah
            </a>

            <a
                href="{{ route('admin.ruangan.create') }}"
                class="border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
            >
                Tambah Ruangan
            </a>

            <a
                href="{{ route('admin.jadwal-kuliah.create') }}"
                class="border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
            >
                Buat Jadwal Kuliah
            </a>

            <a
                href="{{ route('admin.jadwal-ujian.create') }}"
                class="border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700"
            >
                Buat Jadwal Ujian
            </a>
        </div>
    </div>
@endsection