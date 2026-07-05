@extends('layouts.app')

@section('title', 'Ruangan')
@section('page-title', 'Ruangan')
@section('page-description', 'Kelola data ruangan perkuliahan.')

@section('content')
    <x-table
        title="Daftar Ruangan"
        description="Data ruangan yang tersedia."
    >
        <x-slot:action>
            <a
                href="{{ route('admin.ruangan.create') }}"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Tambah Ruangan
            </a>
        </x-slot:action>

        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Kode</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Gedung</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Kapasitas</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($ruangans as $ruangan)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $ruangans->firstItem() + $loop->index }}
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $ruangan->kode }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $ruangan->gedung }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $ruangan->kapasitas }} orang
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <a
                                href="{{ route('admin.ruangan.show', $ruangan) }}"
                                class="mr-2 font-medium text-gray-600 hover:text-gray-900"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('admin.ruangan.edit', $ruangan) }}"
                                class="mr-2 font-medium text-blue-600 hover:text-blue-700"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.ruangan.destroy', $ruangan) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')"
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
                            Data ruangan belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-slot:pagination>
            {{ $ruangans->links() }}
        </x-slot:pagination>
    </x-table>
@endsection