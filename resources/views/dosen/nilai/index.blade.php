@extends('layouts.app')

@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai')
@section('page-description', 'Pilih mata kuliah untuk mengisi nilai mahasiswa.')

@section('content')
    <x-table
        title="Mata Kuliah Diampu"
        description="{{ $tahunAkademikAktif
            ? $tahunAkademikAktif->tahun . ' - ' . $tahunAkademikAktif->semester
            : 'Tahun akademik aktif belum tersedia' }}"
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
                        Semester
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Mahasiswa
                    </th>

                    <th class="px-4 py-3 text-right font-medium text-gray-600">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($mataKuliahs as $mataKuliah)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $mataKuliahs->firstItem() + $loop->index }}
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $mataKuliah->kode }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $mataKuliah->nama }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $mataKuliah->sks }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $mataKuliah->semester }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $mataKuliah->jumlah_mahasiswa }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            <a
                                href="{{ route('dosen.nilai.edit', $mataKuliah) }}"
                                class="rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700"
                            >
                                Input Nilai
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="7"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            Mata kuliah yang diampu belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-slot:pagination>
            {{ $mataKuliahs->links() }}
        </x-slot:pagination>
    </x-table>
@endsection