@extends('layouts.app')

@section('title', 'Detail Ruangan')
@section('page-title', 'Detail Ruangan')
@section('page-description', 'Informasi lengkap ruangan.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                {{ $ruangan->kode }}
            </h2>

            <a
                href="{{ route('admin.ruangan.edit', $ruangan) }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Edit
            </a>
        </div>

        <dl class="grid md:grid-cols-2">
            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Kode</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $ruangan->kode }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Kapasitas</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $ruangan->kapasitas }} orang
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4 md:col-span-2">
                <dt class="text-sm text-gray-500">Gedung</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $ruangan->gedung }}
                </dd>
            </div>
        </dl>

        <div class="px-5 py-4">
            <a
                href="{{ route('admin.ruangan.index') }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Kembali ke daftar ruangan
            </a>
        </div>
    </div>
@endsection