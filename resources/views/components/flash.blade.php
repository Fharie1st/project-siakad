@if (session('success'))
    <div class="mb-4 border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-medium">
            Terdapat kesalahan:
        </p>

        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif