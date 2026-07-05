@props([
    'title' => null,
    'description' => null,
])

<div class="overflow-hidden border border-gray-200 bg-white">
    @if ($title || $description || isset($action))
        <div class="flex flex-col gap-3 border-b border-gray-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                @if ($title)
                    <h2 class="font-semibold text-gray-800">
                        {{ $title }}
                    </h2>
                @endif

                @if ($description)
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $description }}
                    </p>
                @endif
            </div>

            @isset($action)
                <div>
                    {{ $action }}
                </div>
            @endisset
        </div>
    @endif

    <div class="overflow-x-auto">
        {{ $slot }}
    </div>

    @isset($pagination)
        <div class="border-t border-gray-200 px-4 py-3">
            {{ $pagination }}
        </div>
    @endisset
</div>