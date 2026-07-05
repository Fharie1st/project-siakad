@extends('layouts.app')

@section('title', 'Input Nilai Mahasiswa')
@section('page-title', 'Input Nilai Mahasiswa')
@section('page-description', 'Masukkan nilai UTS, UAS, dan tugas mahasiswa.')

@section('content')
    <div class="mb-5 border border-gray-200 bg-white p-5">
        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <p class="text-sm text-gray-500">
                    Mata Kuliah
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    {{ $mataKuliah->nama }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Kode
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    {{ $mataKuliah->kode }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Tahun Akademik
                </p>

                <p class="mt-1 font-semibold text-gray-800">
                    @if ($tahunAkademikAktif)
                        {{ $tahunAkademikAktif->tahun }}
                        -
                        {{ $tahunAkademikAktif->semester }}
                    @else
                        Belum tersedia
                    @endif
                </p>
            </div>
        </div>
    </div>

    <form
        action="{{ route('dosen.nilai.update', $mataKuliah) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <x-table
            title="Daftar Mahasiswa"
            description="Nilai akhir dihitung dari UTS 30%, UAS 40%, dan Tugas 30%."
        >
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-600">
                            No
                        </th>

                        <th class="px-4 py-3 text-left font-medium text-gray-600">
                            NIM
                        </th>

                        <th class="px-4 py-3 text-left font-medium text-gray-600">
                            Nama
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
                    @forelse ($dataKrs as $index => $krs)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $krs->mahasiswa?->nim ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $krs->mahasiswa?->user?->name ?? '-' }}

                                <input
                                    type="hidden"
                                    name="nilai[{{ $index }}][krs_id]"
                                    value="{{ $krs->id }}"
                                >
                            </td>

                            <td class="px-4 py-3">
                                <input
                                    type="number"
                                    name="nilai[{{ $index }}][nilai_uts]"
                                    value="{{ old(
                                        "nilai.$index.nilai_uts",
                                        $krs->nilai?->nilai_uts
                                    ) }}"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    class="w-24 rounded-md border border-gray-300 px-2 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                                >
                            </td>

                            <td class="px-4 py-3">
                                <input
                                    type="number"
                                    name="nilai[{{ $index }}][nilai_uas]"
                                    value="{{ old(
                                        "nilai.$index.nilai_uas",
                                        $krs->nilai?->nilai_uas
                                    ) }}"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    class="w-24 rounded-md border border-gray-300 px-2 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                                >
                            </td>

                            <td class="px-4 py-3">
                                <input
                                    type="number"
                                    name="nilai[{{ $index }}][nilai_tugas]"
                                    value="{{ old(
                                        "nilai.$index.nilai_tugas",
                                        $krs->nilai?->nilai_tugas
                                    ) }}"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    class="w-24 rounded-md border border-gray-300 px-2 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                                >
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
                                    <span class="text-gray-500">
                                        -
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="8"
                                class="px-4 py-8 text-center text-gray-500"
                            >
                                Belum ada mahasiswa yang mengambil mata kuliah ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-table>

        @if ($dataKrs->isNotEmpty())
            <div class="mt-5 flex gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Simpan Nilai
                </button>

                <a
                    href="{{ route('dosen.nilai.index') }}"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                >
                    Kembali
                </a>
            </div>
        @else
            <div class="mt-5">
                <a
                    href="{{ route('dosen.nilai.index') }}"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                >
                    Kembali
                </a>
            </div>
        @endif
    </form>
@endsection