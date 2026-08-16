@props(['route'])

<li>
    <a href="{{ route($route) }}" wire:navigate
        {{ $attributes->class([
            'text-gray-600 hover:text-gray-800 dark:hover:text-gray-600 rounded-lg py-2 px-4 text-xs font-bold',
            'bg-white  dark:bg-gray-80' => request()->routeIs($route),
        ]) }}>
        {{ $slot }}
    </a>
</li>
