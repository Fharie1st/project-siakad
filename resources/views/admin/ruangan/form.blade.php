<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label for="kode" class="mb-1 block text-sm font-medium text-gray-700">
            Kode Ruangan
        </label>

        <input
            type="text"
            id="kode"
            name="kode"
            value="{{ old('kode', $ruangan?->kode) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label for="kapasitas" class="mb-1 block text-sm font-medium text-gray-700">
            Kapasitas
        </label>

        <input
            type="number"
            id="kapasitas"
            name="kapasitas"
            value="{{ old('kapasitas', $ruangan?->kapasitas) }}"
            min="1"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div class="md:col-span-2">
        <label for="gedung" class="mb-1 block text-sm font-medium text-gray-700">
            Gedung
        </label>

        <input
            type="text"
            id="gedung"
            name="gedung"
            value="{{ old('gedung', $ruangan?->gedung) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>
</div>