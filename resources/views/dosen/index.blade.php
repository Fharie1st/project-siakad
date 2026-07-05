@extends('layouts.app')

@section('title', 'Data Dosen')
@section('page-title', 'Data Dosen')
@section('page-description', 'Kelola data dosen SIAKAD.')

@section('content')
    <x-table
        title="Daftar Dosen"
        description="Data dosen yang terdaftar pada sistem."
    >
        <x-slot:action>
            <a
                href="{{ route('admin.dosen.create') }}"
                class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Tambah Dosen
            </a>
        </x-slot:action>

        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        No
                    </th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        NIDN
                    </th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Nama
                    </th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Email
                    </th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Prodi
                    </th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">
                        Jabatan
                    </th>
                    <th class="px-4 py-3 text-right font-medium text-gray-600">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($dosens as $dosen)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">
                            {{ $dosens->firstItem() + $loop->index }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-800">
                            {{ $dosen->nidn }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $dosen->user?->name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $dosen->user?->email ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $dosen->prodi }}
                        </td>

                        <td class="px-4 py-3 text-gray-700">
                            {{ $dosen->jabatan ?: '-' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 text-right">
                            <a
                                href="{{ route('admin.dosen.show', $dosen) }}"
                                class="mr-2 text-sm font-medium text-gray-600 hover:text-gray-900"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('admin.dosen.edit', $dosen) }}"
                                class="mr-2 text-sm font-medium text-blue-600 hover:text-blue-700"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.dosen.destroy', $dosen) }}"
                                method="POST"
                                class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus data dosen ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="text-sm font-medium text-red-600 hover:text-red-700"
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
                            Data dosen belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <x-slot:pagination>
            {{ $dosens->links() }}
        </x-slot:pagination>
    </x-table>
@endsection