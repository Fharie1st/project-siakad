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
            value="{{ old('name', $dosen?->user?->name) }}"
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
            value="{{ old('email', $dosen?->user?->email) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="nidn"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            NIDN
        </label>

        <input
            type="text"
            id="nidn"
            name="nidn"
            value="{{ old('nidn', $dosen?->nidn) }}"
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
            value="{{ old('prodi', $dosen?->prodi) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="jabatan"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Jabatan
        </label>

        <input
            type="text"
            id="jabatan"
            name="jabatan"
            value="{{ old('jabatan', $dosen?->jabatan) }}"
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
            value="{{ old('telp', $dosen?->telp) }}"
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
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
            {{ isset($dosen) ? '' : 'required' }}
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >

        @isset($dosen)
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
            {{ isset($dosen) ? '' : 'required' }}
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>
</div>