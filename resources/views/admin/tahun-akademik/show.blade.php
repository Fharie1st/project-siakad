@extends('layouts.app')

@section('title', 'Detail Tahun Akademik')
@section('page-title', 'Detail Tahun Akademik')
@section('page-description', 'Informasi periode akademik.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                {{ $tahunAkademik->tahun }} - {{ $tahunAkademik->semester }}
            </h2>

            <a
                href="{{ route('admin.tahun-akademik.edit', $tahunAkademik) }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Edit
            </a>
        </div>

        <dl class="grid md:grid-cols-3">
            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Tahun</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $tahunAkademik->tahun }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Semester</dt>
                <dd class="mt-1 font-medium text-gray-800">
                    {{ $tahunAkademik->semester }}
                </dd>
            </div>

            <div class="border-b border-gray-200 px-5 py-4">
                <dt class="text-sm text-gray-500">Status</dt>

                <dd class="mt-1">
                    @if ($tahunAkademik->is_aktif)
                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                            Tidak Aktif
                        </span>
                    @endif
                </dd>
            </div>
        </dl>

        <div class="px-5 py-4">
            <a
                href="{{ route('admin.tahun-akademik.index') }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Kembali ke daftar tahun akademik
            </a>
        </div>
    </div>
@endsection