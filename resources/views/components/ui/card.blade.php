@props([
    'href' => null,
])

<div>
    @if ($href)
        <a href="{{ $href }}"
            {{ $attributes->class(['flex flex-col bg-white rounded-lg shadow-md p-8 dark:bg-gray-800 hover:shadow-gray-500 hover:shadow transition-shadow duration-300 ']) }}>
            {{ $slot }}
        </a>
    @else
        <div {{ $attributes->class(['bg-white rounded-lg shadow-md p-8 dark:bg-gray-800']) }}>
            {{ $slot }}
        </div>
    @endif
</div>
