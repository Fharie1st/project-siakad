@extends('layouts.auth')

@section('title', 'Register SIAKAD')

@section('content')
    <div class="mb-5">
        <h2 class="text-xl font-semibold text-gray-800">
            Register
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Buat akun baru dulu, jangan cuma jadi penonton sistem 😏
        </p>
    </div>

    <form
        action="{{ route('register.process') }}"
        method="POST"
        class="space-y-4"
    >
        @csrf

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Nama</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
            >
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
            >
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Password</label>
            <input
                type="password"
                name="password"
                required
                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>
        </div>

        <div id="mahasiswa">
                    <input type="text" name="nim" placeholder="NIM">
                    <input type="number" name="angkatan" placeholder="Angkatan">
                </div>

                <div id="dosen" style="display:none">
                    <input type="text" name="nidn" placeholder="NIDN">
                    <input type="text" name="jabatan" placeholder="Jabatan">
                </div>

                <div>
                    <input
                        type="text"
                        name="prodi"
                        placeholder="Prodi"
                        required
                    >
                </div>

        <button
            type="submit"
            class="w-full rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700"
        >
            Register
        </button>
    </form>

    <script>
        const role = document.querySelector('[name=role]');
        const m = document.getElementById('mahasiswa');
        const d = document.getElementById('dosen');

        role.addEventListener('change', function () {
            if (this.value === 'mahasiswa') {
                m.style.display = 'block';
                d.style.display = 'none';
            } else if (this.value === 'dosen') {
                m.style.display = 'none';
                d.style.display = 'block';
            } else {
                m.style.display = 'none';
                d.style.display = 'none';
            }
        });
    </script>
@endsection