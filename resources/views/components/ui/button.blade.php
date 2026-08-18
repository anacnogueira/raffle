@props([
    'primary' => false,
    'secondary' => false,
    'danger' => false,
])

@php

    $primary = $primary || (!$secondary && !$danger);

@endphp

<button
    {{ $attributes->class([
        'text-xs text-white py-1 px-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2',
        'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' => $primary,
        'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500' => $secondary,
        'bg-red-600 hover:bg-red-700 focus:ring-red-500' => $danger,
    ]) }}
    type="submit">

    {{ $slot }}

</button>
