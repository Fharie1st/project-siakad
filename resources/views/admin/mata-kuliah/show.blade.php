@extends('layouts.app')

@section('title', 'Detail Mata Kuliah')
@section('page-title', 'Detail Mata Kuliah')
@section('page-description', 'Informasi lengkap mata kuliah.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                {{ $mataKuliah->nama }}
            </h2>

            <a
                href="{{ route('admin.mata-kuliah.edit', $mataKuliah) }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Edit
            </a>
        </div>

        <dl class="grid md:grid-cols-2">
            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Kode</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mataKuliah->kode }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Nama</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mataKuliah->nama }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">SKS</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mataKuliah->sks }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Semester</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mataKuliah->semester }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4 md:col-span-2">
                <dt class="text-sm text-gray-500">Dosen Pengampu</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $mataKuliah->dosen?->user?->name ?? 'Belum ditentukan' }}
                </dd>
            </div>
        </dl>

        <div class="px-5 py-4">
            <a
                href="{{ route('admin.mata-kuliah.index') }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Kembali ke daftar mata kuliah
            </a>
        </div>
    </div>
@endsection