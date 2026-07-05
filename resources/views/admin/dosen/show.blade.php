@extends('layouts.app')

@section('title', 'Detail Dosen')
@section('page-title', 'Detail Dosen')
@section('page-description', 'Informasi lengkap dosen.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                {{ $dosen->user?->name }}
            </h2>

            <a
                href="{{ route('admin.dosen.edit', $dosen) }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Edit
            </a>
        </div>

        <dl class="grid gap-0 md:grid-cols-2">
            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">NIDN</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $dosen->nidn }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Email</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $dosen->user?->email }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Program Studi</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $dosen->prodi }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Jabatan</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $dosen->jabatan ?: '-' }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Telepon</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $dosen->telp ?: '-' }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Mata Kuliah Diampu</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $dosen->mataKuliahs()->count() }}
                </dd>
            </div>
        </dl>

        <div class="px-5 py-4">
            <a
                href="{{ route('admin.dosen.index') }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Kembali ke daftar dosen
            </a>
        </div>
    </div>
@endsection