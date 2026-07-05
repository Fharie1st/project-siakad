@extends('layouts.app')

@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa')
@section('page-description', 'Informasi lengkap mahasiswa.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                {{ $mahasiswa->user?->name }}
            </h2>

            <a
                href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Edit
            </a>
        </div>

        <dl class="grid gap-0 md:grid-cols-2">
            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">NIM</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mahasiswa->nim }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Email</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mahasiswa->user?->email }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Program Studi</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mahasiswa->prodi }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Angkatan</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mahasiswa->angkatan }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Telepon</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mahasiswa->telp ?: '-' }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Alamat</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mahasiswa->alamat ?: '-' }}
                </dd>
            </div>
        </dl>

        <div class="px-5 py-4">
            <a
                href="{{ route('admin.mahasiswa.index') }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Kembali ke daftar mahasiswa
            </a>
        </div>
    </div>
@endsection