@props(['name', 'id' => null, 'value' => '', 'module' => 'general', 'label' => ''])

@php
    $inputId = $id ?? $name;
@endphp

<div data-ckeditor data-module="{{ $module }}" class="w-full">
    @if($label)
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" for="{{ $inputId }}">
            {{ $label }}
        </label>
    @endif

    <textarea name="{{ $name }}" id="{{ $inputId }}">{!! $value !!}</textarea>

    {{-- Status bar --}}
    <div class="ck-status-bar flex flex-wrap gap-3 items-center justify-between text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/80 px-4 py-2 rounded-b-lg border border-t-0 border-gray-300 dark:border-gray-600/60">
        <div class="flex items-center gap-4">
            <span>
                <span data-ck-words>0</span> kata
            </span>
            <span>
                <span data-ck-chars>0</span> karakter
            </span>
        </div>
        <span class="text-indigo-600 dark:text-indigo-400">
            ≈ <span data-ck-time>0</span> mnt baca
        </span>
    </div>

    @error($name)
        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
    @enderror
</div>
