<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'SIAKAD')
    </title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen">
        <x-sidebar />

        <div class="min-h-screen md:ml-64">
            <header class="border-b border-gray-200 bg-white">

                <div class="px-4 py-3 md:px-6">

                    <div class="flex items-start justify-between">

                        <div>
                            <h1 class="text-lg font-semibold text-gray-800">
                                @yield('page-title', 'Dashboard')
                            </h1>

                            @hasSection('page-description')
                                <p class="mt-1 text-sm text-gray-500">
                                    @yield('page-description')
                                </p>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">

                            @yield('page-action')

                            <div class="flex items-center gap-3">

    @hasSection('header-action')
        @yield('header-action')
    @endif

                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-800">
                                    {{ auth()->user()?->name }}
                                </p>

                                <p class="text-xs capitalize text-gray-500">
                                    {{ auth()->user()?->role }}
                                </p>
                            </div>

                        </div>

                        </div>

                    </div>

                </div>

            </header>

            <main class="p-4 md:p-6">
                <x-flash />

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>