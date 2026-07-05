@extends('layouts.app')

@section('title', 'KRS')
@section('page-title', 'Kartu Rencana Studi')
@section('page-description', 'Pilih mata kuliah pada semester aktif.')

@section('header-action')
    <a href="{{ route('mahasiswa.krs.pdf') }}"
       target="_blank"
       class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors duration-200">
        📄 Cetak PDF
    </a>

@endsection
@section('content')

    <div class="mb-5 grid gap-4 sm:grid-cols-2">
        <div class="border border-gray-200 bg-white p-5">
            <p class="text-sm text-gray-500">
                Tahun Akademik Aktif
            </p>

            @if ($tahunAkademikAktif)
                <p class="mt-2 font-semibold text-gray-800">
                    {{ $tahunAkademikAktif->tahun }}
                    -
                    {{ $tahunAkademikAktif->semester }}
                </p>
            @else
                <p class="mt-2 font-medium text-red-600">
                    Belum tersedia
                </p>
            @endif
        </div>

        <div class="border border-gray-200 bg-white p-5">
            <p class="text-sm text-gray-500">
                Mahasiswa
            </p>

            <p class="mt-2 font-semibold text-gray-800">
                {{ $mahasiswa->user?->name }}
            </p>

            <p class="mt-1 text-sm text-gray-500">
                {{ $mahasiswa->nim }}
            </p>
        </div>
    </div>

    <x-table
        title="Daftar Mata Kuliah"
        description="Klik ambil untuk memasukkan mata kuliah ke KRS."
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
                        Dosen
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Status
                    </th>

                    <th class="px-4 py-3 text-right font-medium text-gray-600">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($mataKuliahs as $mataKuliah)
                    @php
                        $sudahDiambil = $krsDiambil->contains($mataKuliah->id);
                    @endphp

                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $loop->iteration }}
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
                            {{ $mataKuliah->dosen?->user?->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            @if ($sudahDiambil)
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Diambil
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                    Belum Diambil
                                </span>
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            @if ($sudahDiambil)
                                <form
                                    action="{{ route('mahasiswa.krs.batal', $mataKuliah) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Batalkan mata kuliah ini dari KRS?')"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="rounded-md border border-red-300 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
                                    >
                                        Batalkan
                                    </button>
                                </form>
                            @else
                                <form
                                    action="{{ route('mahasiswa.krs.ambil', $mataKuliah) }}"
                                    method="POST"
                                    class="inline"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700"
                                    >
                                        Ambil
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="8"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            Mata kuliah untuk semester Anda belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-table>
@endsection