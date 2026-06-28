@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-theme-bg border-theme-border text-theme-text focus:border-theme-primary focus:ring-theme-primary rounded-xl shadow-sm transition-colors duration-200 py-2.5 px-4']) }}>
