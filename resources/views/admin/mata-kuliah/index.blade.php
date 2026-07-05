@extends('layouts.app')

@section('title', 'Mata Kuliah')
@section('page-title', 'Mata Kuliah')
@section('page-description', 'Kelola data mata kuliah.')

@section('content')
    <x-table
        title="Daftar Mata Kuliah"
        description="Data mata kuliah yang tersedia."
    >
        <x-slot:action>
            <a
                href="{{ route('admin.mata-kuliah.create') }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Tambah Mata Kuliah
            </a>
        </x-slot:action>

        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Kode</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Nama</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">SKS</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Semester</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Dosen</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
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
                            {{ $mataKuliah->dosen?->user?->name ?? 'Belum ditentukan' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <a
                                href="{{ route('admin.mata-kuliah.show', $mataKuliah) }}"
                                class="mr-2 font-medium text-gray-600 hover:text-gray-900"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('admin.mata-kuliah.edit', $mataKuliah) }}"
                                class="mr-2 font-medium text-blue-600 hover:text-blue-700"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.mata-kuliah.destroy', $mataKuliah) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?')"
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
                            colspan="7"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            Data mata kuliah belum tersedia.
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