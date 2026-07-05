@extends('layouts.app')

@section('title', 'Jadwal Ujian')
@section('page-title', 'Jadwal Ujian')
@section('page-description', 'Kelola jadwal UTS dan UAS.')

@section('content')
    <x-table
        title="Daftar Jadwal Ujian"
        description="Jadwal ujian seluruh mata kuliah."
    >
        <x-slot:action>
            <a
                href="{{ route('admin.jadwal-ujian.create') }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Tambah Jadwal
            </a>
        </x-slot:action>

        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        No
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Jenis
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Tanggal
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Waktu
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Mata Kuliah
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Ruangan
                    </th>

                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Tahun Akademik
                    </th>

                    <th class="px-4 py-3 text-right font-medium text-gray-600">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($jadwalUjians as $jadwal)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $jadwalUjians->firstItem() + $loop->index }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                {{ $jadwal->jenis }}
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                            {{ $jadwal->tanggal?->format('d-m-Y') }}
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
                            {{ $jadwal->ruangan?->kode ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $jadwal->tahunAkademik?->tahun ?? '-' }}
                            {{ $jadwal->tahunAkademik?->semester ?? '' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <a
                                href="{{ route('admin.jadwal-ujian.edit', $jadwal) }}"
                                class="mr-2 font-medium text-blue-600 hover:text-blue-700"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.jadwal-ujian.destroy', $jadwal) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus jadwal ujian ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="font-medium text-red-600 hover:text-red-700"
                                >
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="8"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            Jadwal ujian belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-slot:pagination>
            {{ $jadwalUjians->links() }}
        </x-slot:pagination>
    </x-table>
@endsection