@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')
@section('page-title', 'Edit Mata Kuliah')
@section('page-description', 'Perbarui data mata kuliah.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">Form Edit Mata Kuliah</h2>
        </div>

        <form
            action="{{ route('admin.mata-kuliah.update', $mataKuliah) }}"
            method="POST"
            class="p-5"
        >
            @csrf
            @method('PUT')

            @include('admin.mata-kuliah.form', [
                'mataKuliah' => $mataKuliah,
            ])

            <div class="mt-6 flex gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.mata-kuliah.index') }}"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection