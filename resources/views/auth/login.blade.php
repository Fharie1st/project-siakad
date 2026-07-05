@extends('layouts.auth')

@section('title', 'Login SIAKAD')

@section('content')
    <div class="mb-5">
        <h2 class="text-xl font-semibold text-gray-800">
            Login
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Masukkan email dan password akun Anda.
        </p>
    </div>

    <form
        action="{{ route('login.process') }}"
        method="POST"
        class="space-y-4"
    >
        @csrf

        <div>
            <label
                for="email"
                class="mb-1 block text-sm font-medium text-gray-700"
            >
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
            >
        </div>

        <div>
            <label
                for="password"
                class="mb-1 block text-sm font-medium text-gray-700"
            >
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
            >
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input
                type="checkbox"
                name="remember"
                value="1"
                class="rounded border-gray-300 text-blue-600"
            >

            Ingat saya
        </label>

        <button
            type="submit"
            class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
        >
            Login
        </button>
    </form>
    <div class="mt-4 text-center text-sm">
    Belum punya akun?
    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
        Register
    </a>
</div>
@endsection