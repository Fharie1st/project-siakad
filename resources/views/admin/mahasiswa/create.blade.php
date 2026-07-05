@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')
@section('page-title', 'Tambah Mahasiswa')
@section('page-description', 'Masukkan data mahasiswa baru.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                Form Mahasiswa
            </h2>
        </div>

        <form
            action="{{ route('admin.mahasiswa.store') }}"
            method="POST"
            class="p-5"
        >
            @csrf

            @include('admin.mahasiswa.form', [
                'mahasiswa' => null,
            ])

            <div class="mt-6 flex items-center gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Simpan
                </button>

                <a
                    href="{{ route('admin.mahasiswa.index') }}"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection