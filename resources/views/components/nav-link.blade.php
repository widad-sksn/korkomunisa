@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full px-4 py-3 rounded-xl text-sm font-bold text-white bg-theme-primary shadow-md transition duration-200 ease-in-out'
            : 'flex items-center w-full px-4 py-3 rounded-xl text-sm font-medium text-theme-secondary hover:text-theme-text hover:bg-theme-bg focus:outline-none focus:bg-theme-bg transition duration-200 ease-in-out group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
