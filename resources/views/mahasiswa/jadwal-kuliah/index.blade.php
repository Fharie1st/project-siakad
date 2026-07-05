@extends('layouts.app')

@section('page-action')

@endsection
@section('title', 'Jadwal Kuliah')
@section('page-title', 'Jadwal Kuliah')
@section('page-description', 'Jadwal kuliah berdasarkan mata kuliah yang Anda ambil.')

@section('header-action')
<a href="{{ route('mahasiswa.jadwal-kuliah.pdf') }}"
   target="_blank"
   class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors duration-200">
    📄 Cetak PDF
</a>
@endsection

@section('content')
    <x-table
        title="Daftar Jadwal Kuliah"
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
                        Dosen
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Ruangan
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($jadwalKuliahs as $jadwal)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $loop->iteration }}
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
                            {{ $jadwal->mataKuliah?->dosen?->user?->name ?? '-' }}
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
                            Jadwal kuliah belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-table>
@endsection