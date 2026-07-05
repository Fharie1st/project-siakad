<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label
            for="matkul_id"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Mata Kuliah
        </label>

        <select
            id="matkul_id"
            name="matkul_id"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
            <option value="">Pilih mata kuliah</option>

            @foreach ($mataKuliahs as $mataKuliah)
                <option
                    value="{{ $mataKuliah->id }}"
                    @selected(old('matkul_id', $jadwalUjian?->matkul_id) == $mataKuliah->id)
                >
                    {{ $mataKuliah->kode }} - {{ $mataKuliah->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label
            for="jenis"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Jenis Ujian
        </label>

        <select
            id="jenis"
            name="jenis"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
            <option value="">Pilih jenis ujian</option>

            <option
                value="UTS"
                @selected(old('jenis', $jadwalUjian?->jenis) === 'UTS')
            >
                UTS
            </option>

            <option
                value="UAS"
                @selected(old('jenis', $jadwalUjian?->jenis) === 'UAS')
            >
                UAS
            </option>
        </select>
    </div>

    <div>
        <label
            for="tanggal"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Tanggal
        </label>

        <input
            type="date"
            id="tanggal"
            name="tanggal"
            value="{{ old('tanggal', $jadwalUjian?->tanggal?->format('Y-m-d')) }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="ruangan_id"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Ruangan
        </label>

        <select
            id="ruangan_id"
            name="ruangan_id"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
            <option value="">Pilih ruangan</option>

            @foreach ($ruangans as $ruangan)
                <option
                    value="{{ $ruangan->id }}"
                    @selected(old('ruangan_id', $jadwalUjian?->ruangan_id) == $ruangan->id)
                >
                    {{ $ruangan->kode }} - {{ $ruangan->gedung }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label
            for="tahun_akademik_id"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Tahun Akademik
        </label>

        <select
            id="tahun_akademik_id"
            name="tahun_akademik_id"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
            <option value="">Pilih tahun akademik</option>

            @foreach ($tahunAkademiks as $tahunAkademik)
                <option
                    value="{{ $tahunAkademik->id }}"
                    @selected(
                        old(
                            'tahun_akademik_id',
                            $jadwalUjian?->tahun_akademik_id
                        ) == $tahunAkademik->id
                    )
                >
                    {{ $tahunAkademik->tahun }}
                    -
                    {{ $tahunAkademik->semester }}
                    {{ $tahunAkademik->is_aktif ? '(Aktif)' : '' }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label
            for="jam_mulai"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Jam Mulai
        </label>

        <input
            type="time"
            id="jam_mulai"
            name="jam_mulai"
            value="{{ old('jam_mulai', $jadwalUjian ? substr($jadwalUjian->jam_mulai, 0, 5) : '') }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div>
        <label
            for="jam_selesai"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            Jam Selesai
        </label>

        <input
            type="time"
            id="jam_selesai"
            name="jam_selesai"
            value="{{ old('jam_selesai', $jadwalUjian ? substr($jadwalUjian->jam_selesai, 0, 5) : '') }}"
            required
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
        >
    </div>
</div>