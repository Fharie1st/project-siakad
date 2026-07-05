<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label for="tahun" class="mb-1 block text-sm font-medium text-gray-700">
            Tahun Akademik
        </label>

        <input
            type="text"
            id="tahun"
            name="tahun"
            value="{{ old('tahun', $tahunAkademik?->tahun) }}"
            placeholder="Contoh: 2025/2026"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label for="semester" class="mb-1 block text-sm font-medium text-gray-700">
            Semester
        </label>

        <select
            id="semester"
            name="semester"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
            <option value="">Pilih semester</option>

            <option
                value="Ganjil"
                @selected(old('semester', $tahunAkademik?->semester) === 'Ganjil')
            >
                Ganjil
            </option>

            <option
                value="Genap"
                @selected(old('semester', $tahunAkademik?->semester) === 'Genap')
            >
                Genap
            </option>
        </select>
    </div>

    <div class="md:col-span-2">
        <input type="hidden" name="is_aktif" value="0">

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input
                type="checkbox"
                name="is_aktif"
                value="1"
                @checked(old('is_aktif', $tahunAkademik?->is_aktif ?? false))
                class="rounded border-gray-300 text-blue-600"
            >

            Jadikan tahun akademik aktif
        </label>

        <p class="mt-1 text-xs text-gray-500">
            Tahun akademik aktif sebelumnya akan dinonaktifkan otomatis.
        </p>
    </div>
</div>