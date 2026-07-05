@extends('layouts.app')

@section('title', 'Jadwal Mengajar')
@section('page-title', 'Jadwal Mengajar')
@section('page-description', 'Jadwal kuliah yang Anda ampu pada semester aktif.')

@section('content')
    <x-table
        title="Daftar Jadwal Mengajar"
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
                        Hari
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Waktu
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Mata Kuliah
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        SKS
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Ruangan
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($jadwalMengajars as $jadwal)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $jadwalMengajars->firstItem() + $loop->index }}
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $jadwal->hari }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                            {{ substr($jadwal->jam_mulai, 0, 5) }}
                            -
                            {{ substr($jadwal->jam_selesai, 0, 5) }}
                        </td>

                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-800">
                                {{ $jadwal->mataKuliah?->nama ?? '-' }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $jadwal->mataKuliah?->kode ?? '-' }}
                            </p>
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $jadwal->mataKuliah?->sks ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $jadwal->ruangan?->kode ?? '-' }}

                            @if ($jadwal->ruangan?->gedung)
                                <p class="text-xs text-gray-500">
                                    {{ $jadwal->ruangan->gedung }}
                                </p>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="6"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            Jadwal mengajar belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-slot:pagination>
            {{ $jadwalMengajars->links() }}
        </x-slot:pagination>
    </x-table>
@endsection