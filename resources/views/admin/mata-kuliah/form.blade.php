<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label for="kode" class="mb-1 block text-sm font-medium text-gray-700">
            Kode Mata Kuliah
        </label>

        <input
            type="text"
            id="kode"
            name="kode"
            value="{{ old('kode', $mataKuliah?->kode) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label for="nama" class="mb-1 block text-sm font-medium text-gray-700">
            Nama Mata Kuliah
        </label>

        <input
            type="text"
            id="nama"
            name="nama"
            value="{{ old('nama', $mataKuliah?->nama) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label for="sks" class="mb-1 block text-sm font-medium text-gray-700">
            SKS
        </label>

        <input
            type="number"
            id="sks"
            name="sks"
            value="{{ old('sks', $mataKuliah?->sks) }}"
            min="1"
            max="6"
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

            @for ($semester = 1; $semester <= 14; $semester++)
                <option
                    value="{{ $semester }}"
                    @selected(old('semester', $mataKuliah?->semester) == $semester)
                >
                    Semester {{ $semester }}
                </option>
            @endfor
        </select>
    </div>

    <div class="md:col-span-2">
        <label for="dosen_id" class="mb-1 block text-sm font-medium text-gray-700">
            Dosen Pengampu
        </label>

        <select
            id="dosen_id"
            name="dosen_id"
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
            <option value="">Belum ditentukan</option>

            @foreach ($dosens as $dosen)
                <option
                    value="{{ $dosen->id }}"
                    @selected(old('dosen_id', $mataKuliah?->dosen_id) == $dosen->id)
                >
                    {{ $dosen->nidn }} - {{ $dosen->user?->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>