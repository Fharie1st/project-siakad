@extends('layouts.app')

@section('title', 'Tahun Akademik')
@section('page-title', 'Tahun Akademik')
@section('page-description', 'Kelola semester dan tahun akademik.')

@section('content')
    <x-table
        title="Daftar Tahun Akademik"
        description="Hanya satu tahun akademik yang dapat diaktifkan."
    >
        <x-slot:action>
            <a
                href="{{ route('admin.tahun-akademik.create') }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Tambah Tahun Akademik
            </a>
        </x-slot:action>

        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Tahun</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Semester</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($tahunAkademiks as $tahunAkademik)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $tahunAkademiks->firstItem() + $loop->index }}
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $tahunAkademik->tahun }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $tahunAkademik->semester }}
                        </td>

                        <td class="px-4 py-3">
                            @if ($tahunAkademik->is_aktif)
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <a
                                href="{{ route('admin.tahun-akademik.show', $tahunAkademik) }}"
                                class="mr-2 font-medium text-gray-600 hover:text-gray-900"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('admin.tahun-akademik.edit', $tahunAkademik) }}"
                                class="mr-2 font-medium text-blue-600 hover:text-blue-700"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.tahun-akademik.destroy', $tahunAkademik) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus tahun akademik ini?')"
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
                            colspan="5"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            Data tahun akademik belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-slot:pagination>
            {{ $tahunAkademiks->links() }}
        </x-slot:pagination>
    </x-table>
@endsection