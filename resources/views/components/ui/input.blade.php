<div>
    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
    <input {{ $attributes }}
        class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">

    <x-ui.error name="{{ $attributes->get('name') }}" />
