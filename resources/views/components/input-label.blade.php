@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-theme-text mb-2']) }}>
    {{ $value ?? $slot }}
</label>
