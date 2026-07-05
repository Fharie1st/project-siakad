@extends('layouts.app')

@section('title', 'KHS')
@section('page-title', 'Kartu Hasil Studi')
@section('page-description', 'Lihat hasil studi dan nilai akademik Anda.')

@section('header-action')
    <a href="{{ route('mahasiswa.khs.pdf') }}"
       target="_blank"
       class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition-colors duration-200">
        📄 Cetak PDF
    </a>
@endsection
@section('content')
    <div class="mb-5 grid gap-4 sm:grid-cols-2">
        <div class="border border-gray-200 bg-white p-5">
            <p class="text-sm text-gray-500">
                Mahasiswa
            </p>

            <p class="mt-2 font-semibold text-gray-800">
                {{ $mahasiswa->user?->name ?? '-' }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                {{ $mahasiswa->nim }}
            </p>
        </div>

        <div class="border border-gray-200 bg-white p-5">
            <p class="text-sm text-gray-500">
                IPS
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ number_format((float) $ips, 2) }}
            </p>
        </div>
    </div>

    <div class="mb-5 border border-gray-200 bg-white p-5">
        <form
            action="{{ route('mahasiswa.khs.index') }}"
            method="GET"
            class="flex flex-col gap-3 sm:flex-row sm:items-end"
        >
            <div class="w-full sm:max-w-sm">
                <label
                    for="tahun_akademik_id"
                    class="mb-1 block text-sm font-medium text-gray-700"
                >
                    Tahun Akademik
                </label>

                <select
                    id="tahun_akademik_id"
                    name="tahun_akademik_id"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                >
                    @foreach ($tahunAkademiks as $tahunAkademik)
                        <option
                            value="{{ $tahunAkademik->id }}"
                            @selected(
                                $tahunAkademikDipilih &&
                                $tahunAkademikDipilih->id === $tahunAkademik->id
                            )
                        >
                            {{ $tahunAkademik->tahun }}
                            -
                            {{ $tahunAkademik->semester }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button
                type="submit"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Tampilkan
            </button>
        </form>
    </div>

    <x-table
        title="Daftar Nilai"
        description="{{ $tahunAkademikDipilih
            ? $tahunAkademikDipilih->tahun . ' - ' . $tahunAkademikDipilih->semester
            : 'Tahun akademik belum tersedia' }}"
    >
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        No
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Kode
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Mata Kuliah
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        SKS
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        UTS
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        UAS
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Tugas
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Nilai Akhir
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Grade
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($dataKhs as $krs)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $krs->mataKuliah?->kode ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $krs->mataKuliah?->nama ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $krs->mataKuliah?->sks ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $krs->nilai?->nilai_uts ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $krs->nilai?->nilai_uas ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $krs->nilai?->nilai_tugas ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $krs->nilai?->nilai_akhir !== null
                                ? number_format((float) $krs->nilai->nilai_akhir, 2)
                                : '-' }}
                        </td>

                        <td class="px-4 py-3">
                            @if ($krs->nilai?->grade)
                                <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                    {{ $krs->nilai->grade }}
                                </span>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="9"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            Data nilai belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-table>
@endsection