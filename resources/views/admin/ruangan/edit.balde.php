@extends('layouts.app')

@section('title', 'Edit Ruangan')
@section('page-title', 'Edit Ruangan')
@section('page-description', 'Perbarui data ruangan.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">Form Edit Ruangan</h2>
        </div>

        <form
            action="{{ route('admin.ruangan.update', $ruangan) }}"
            method="POST"
            class="p-5"
        >
            @csrf
            @method('PUT')

            @include('admin.ruangan.form', [
                'ruangan' => $ruangan,
            ])

            <div class="mt-6 flex gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.ruangan.index') }}"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection