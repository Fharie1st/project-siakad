<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label
            for="name"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Nama
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $mahasiswa?->user?->name) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="email"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', $mahasiswa?->user?->email) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="nim"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            NIM
        </label>

        <input
            type="text"
            id="nim"
            name="nim"
            value="{{ old('nim', $mahasiswa?->nim) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="prodi"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Program Studi
        </label>

        <input
            type="text"
            id="prodi"
            name="prodi"
            value="{{ old('prodi', $mahasiswa?->prodi) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="angkatan"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Angkatan
        </label>

        <input
            type="number"
            id="angkatan"
            name="angkatan"
            value="{{ old('angkatan', $mahasiswa?->angkatan) }}"
            min="2000"
            max="2100"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="telp"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Nomor Telepon
        </label>

        <input
            type="text"
            id="telp"
            name="telp"
            value="{{ old('telp', $mahasiswa?->telp) }}"
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div class="md:col-span-2">
        <label
            for="alamat"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Alamat
        </label>

        <textarea
            id="alamat"
            name="alamat"
            rows="3"
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >{{ old('alamat', $mahasiswa?->alamat) }}</textarea>
    </div>

    <div>
        <label
            for="password"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Password
        </label>

        <input
            type="password"
            id="password"
            name="password"
            {{ isset($mahasiswa) ? '' : 'required' }}
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >

        @isset($mahasiswa)
            <p class="mt-1 text-xs text-gray-500">
                Kosongkan jika password tidak diubah.
            </p>
        @endisset
    </div>

    <div>
        <label
            for="password_confirmation"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Konfirmasi Password
        </label>

        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            {{ isset($mahasiswa) ? '' : 'required' }}
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>
</div>