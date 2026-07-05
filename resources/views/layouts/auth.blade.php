<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Login SIAKAD')
    </title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="w-full max-w-md">
            <div class="mb-6 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg bg-blue-600 text-white">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="h-8 w-8"
                    >
                        <path d="M11.7 1.805a.75.75 0 0 1 .6 0l9 4.5a.75.75 0 0 1 0 1.34l-9 4.5a.75.75 0 0 1-.6 0l-9-4.5a.75.75 0 0 1 0-1.34l9-4.5Z" />
                        <path d="M3.75 10.2v5.35c0 .495.24.96.645 1.245 1.665 1.17 4.035 2.205 7.605 2.205s5.94-1.035 7.605-2.205c.405-.285.645-.75.645-1.245V10.2l-7.275 3.638a2.25 2.25 0 0 1-1.95 0L3.75 10.2Z" />
                    </svg>
                </div>

                <h1 class="mt-3 text-2xl font-bold text-blue-600">
                    SIAKAD
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Sistem Informasi Akademik
                </p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6">
                <x-flash />

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>