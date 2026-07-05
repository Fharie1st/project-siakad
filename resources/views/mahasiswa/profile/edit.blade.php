@extends('layouts.app')

@section('title', 'Profil Mahasiswa')
@section('page-title', 'Profil Mahasiswa')
@section('page-description', 'Lihat dan perbarui data profil Anda.')

@section('content')
    <div class="border border-gray-200 bg-white">
        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="font-semibold text-gray-800">
                Data Profil
            </h2>
        </div>

        <form
            action="{{ route('mahasiswa.profile.update') }}"
            method="POST"
            class="p-5"
        >
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        Nama
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                    >
                </div>

                <div>
                    <label for="email"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                    >
                </div>

                <div>
                    <label for="nim"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        NIM
                    </label>

                    <input
                        type="text"
                        id="nim"
                        value="{{ $mahasiswa->nim }}"
                        disabled
                        class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-500"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        NIM hanya dapat diubah oleh admin.
                    </p>
                </div>

                <div>
                    <label for="angkatan"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        Angkatan
                    </label>

                    <input
                        type="text"
                        id="angkatan"
                        value="{{ $mahasiswa->angkatan }}"
                        disabled
                        class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-500"
                    >
                </div>

                <div>
                    <label for="prodi"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        Program Studi
                    </label>

                    <input
                        type="text"
                        id="prodi"
                        name="prodi"
                        value="{{ old('prodi', $mahasiswa->prodi) }}"
                        required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                    >
                </div>

                <div>
                    <label for="telp"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        Nomor Telepon
                    </label>

                    <input
                        type="text"
                        id="telp"
                        name="telp"
                        value="{{ old('telp', $mahasiswa->telp) }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                    >
                </div>

                <div class="md:col-span-2">
                    <label for="alamat"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                    >{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                </div>

                <div>
                    <label for="password"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        Kosongkan jika password tidak diubah.
                    </p>
                </div>

                <div>
                    <label for="password_confirmation"
                           class="mb-1 block text-sm font-medium text-gray-700">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                    >
                </div>
            </div>

            <div class="mt-6">
                <button
                    type="submit"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection