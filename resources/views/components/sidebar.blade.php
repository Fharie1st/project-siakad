@php
    $user = auth()->user();
    $role = $user?->role;

    $baseClass = 'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium';
    $activeClass = 'bg-blue-50 text-blue-700';
    $inactiveClass = 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
@endphp

<aside class="fixed inset-y-0 left-0 z-30 hidden w-64 border-r border-gray-200 bg-white md:flex md:flex-col">
    <div class="flex h-16 items-center border-b border-gray-200 px-5">
        <div class="flex h-9 w-9 items-center justify-center rounded-md bg-blue-600 text-white">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-5 w-5"
            >
                <path d="M11.7 1.805a.75.75 0 0 1 .6 0l9 4.5a.75.75 0 0 1 0 1.34l-9 4.5a.75.75 0 0 1-.6 0l-9-4.5a.75.75 0 0 1 0-1.34l9-4.5Z" />
                <path d="M3.75 10.2v5.35c0 .495.24.96.645 1.245 1.665 1.17 4.035 2.205 7.605 2.205s5.94-1.035 7.605-2.205c.405-.285.645-.75.645-1.245V10.2l-7.275 3.638a2.25 2.25 0 0 1-1.95 0L3.75 10.2Z" />
            </svg>
        </div>

        <div class="ml-3">
            <p class="font-bold text-blue-600">
                SIAKAD
            </p>

            <p class="text-xs text-gray-500">
                Sistem Akademik
            </p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto p-4">
        @if ($role === 'admin')
            <a
                href="{{ route('admin.dashboard') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="h-5 w-5"
                >
                    <path d="M3 13.125C3 12.504 3.504 12 4.125 12h3.75C8.496 12 9 12.504 9 13.125v6.75C9 20.496 8.496 21 7.875 21h-3.75A1.125 1.125 0 0 1 3 19.875v-6.75ZM10.5 4.125C10.5 3.504 11.004 3 11.625 3h.75c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-.75a1.125 1.125 0 0 1-1.125-1.125V4.125ZM15 8.625c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-3.75A1.125 1.125 0 0 1 15 19.875V8.625Z" />
                </svg>

                Dashboard
            </a>

            <a
                href="{{ route('admin.mahasiswa.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.mahasiswa.*') ? $activeClass : $inactiveClass }}"
            >
                Mahasiswa
            </a>

            <a
                href="{{ route('admin.dosen.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.dosen.*') ? $activeClass : $inactiveClass }}"
            >
                Dosen
            </a>

            <a
                href="{{ route('admin.mata-kuliah.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.mata-kuliah.*') ? $activeClass : $inactiveClass }}"
            >
                Mata Kuliah
            </a>

            <a
                href="{{ route('admin.ruangan.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.ruangan.*') ? $activeClass : $inactiveClass }}"
            >
                Ruangan
            </a>

            <a
                href="{{ route('admin.tahun-akademik.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.tahun-akademik.*') ? $activeClass : $inactiveClass }}"
            >
                Tahun Akademik
            </a>

            <a
                href="{{ route('admin.jadwal-kuliah.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.jadwal-kuliah.*') ? $activeClass : $inactiveClass }}"
            >
                Jadwal Kuliah
            </a>

            <a
                href="{{ route('admin.jadwal-ujian.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.jadwal-ujian.*') ? $activeClass : $inactiveClass }}"
            >
                Jadwal Ujian
            </a>
        @elseif ($role === 'dosen')
            <a
                href="{{ route('dosen.dashboard') }}"
                class="{{ $baseClass }} {{ request()->routeIs('dosen.dashboard') ? $activeClass : $inactiveClass }}"
            >
                Dashboard
            </a>

            <a
                href="{{ route('dosen.profile.edit') }}"
                class="{{ $baseClass }} {{ request()->routeIs('dosen.profile.*') ? $activeClass : $inactiveClass }}"
            >
                Profile
            </a>

            <a
                href="{{ route('dosen.jadwal-mengajar.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('dosen.jadwal-mengajar.*') ? $activeClass : $inactiveClass }}"
            >
                Jadwal Mengajar
            </a>

            <a
                href="{{ route('dosen.jadwal-ujian.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('dosen.jadwal-ujian.*') ? $activeClass : $inactiveClass }}"
            >
                Jadwal Ujian
            </a>

            <a
                href="{{ route('dosen.nilai.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('dosen.nilai.*') ? $activeClass : $inactiveClass }}"
            >
                Input Nilai
            </a>
        @elseif ($role === 'mahasiswa')
            <a
                href="{{ route('mahasiswa.dashboard') }}"
                class="{{ $baseClass }} {{ request()->routeIs('mahasiswa.dashboard') ? $activeClass : $inactiveClass }}"
            >
                Dashboard
            </a>

            <a
                href="{{ route('mahasiswa.profile.edit') }}"
                class="{{ $baseClass }} {{ request()->routeIs('mahasiswa.profile.*') ? $activeClass : $inactiveClass }}"
            >
                Profile
            </a>

            <a
                href="{{ route('mahasiswa.krs.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('mahasiswa.krs.*') ? $activeClass : $inactiveClass }}"
            >
                KRS
            </a>

            <a
                href="{{ route('mahasiswa.khs.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('mahasiswa.khs.*') ? $activeClass : $inactiveClass }}"
            >
                KHS
            </a>

            <a
                href="{{ route('mahasiswa.jadwal-kuliah.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('mahasiswa.jadwal-kuliah.*') ? $activeClass : $inactiveClass }}"
            >
                Jadwal Kuliah
            </a>

            <a
                href="{{ route('mahasiswa.jadwal-ujian.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('mahasiswa.jadwal-ujian.*') ? $activeClass : $inactiveClass }}"
            >
                Jadwal Ujian
            </a>
        @endif
    </nav>

    <div class="border-t border-gray-200 p-4">
        <div class="mb-3">
            <p class="truncate text-sm font-medium text-gray-800">
                {{ $user?->name }}
            </p>

            <p class="truncate text-xs text-gray-500">
                {{ $user?->email }}
            </p>
        </div>

        <form
            action="{{ route('logout') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="h-5 w-5"
                >
                    <path fill-rule="evenodd" d="M7.5 3.75A2.25 2.25 0 0 1 9.75 1.5h6A2.25 2.25 0 0 1 18 3.75v16.5a2.25 2.25 0 0 1-2.25 2.25h-6a2.25 2.25 0 0 1-2.25-2.25V18a.75.75 0 0 1 1.5 0v2.25c0 .414.336.75.75.75h6a.75.75 0 0 0 .75-.75V3.75a.75.75 0 0 0-.75-.75h-6a.75.75 0 0 0-.75.75V6a.75.75 0 0 1-1.5 0V3.75Zm3.97 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H3.75a.75.75 0 0 1 0-1.5h9.44l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>

                Logout
            </button>
        </form>
    </div>
</aside>