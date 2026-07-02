@props(['name', 'id' => null, 'value' => '', 'module' => 'general', 'label' => ''])

@php
    $inputId = $id ?? $name;
@endphp

<div class="ck-editor-component w-full" data-module="{{ $module }}" x-data="{ wordCount: 0, charCount: 0, readingTime: 0 }" x-init="
    $el.addEventListener('ckeditor-word-count', (e) => {
        wordCount = e.detail.words;
        charCount = e.detail.characters;
        readingTime = Math.ceil(wordCount / 200);
    })
">
    @if($label)
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" for="{{ $inputId }}">
            {{ $label }}
        </label>
    @endif
    
    <textarea name="{{ $name }}" id="{{ $inputId }}" class="hidden ck-textarea">{!! $value !!}</textarea>
    
    <!-- Editor Footer (Word Count) -->
    <div class="flex flex-wrap gap-2 items-center justify-between mt-0 text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/80 px-4 py-2.5 rounded-b-xl border-x border-b border-gray-300 dark:border-gray-600/60 shadow-sm relative -top-1 z-0">
        <div class="flex items-center gap-4">
            <span class="flex items-center" title="Jumlah Kata">
                <svg class="w-3.5 h-3.5 mr-1 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                <span x-text="wordCount" class="mr-1 text-gray-700 dark:text-gray-300 font-semibold">0</span> kata
            </span>
            <span class="flex items-center" title="Jumlah Karakter">
                <svg class="w-3.5 h-3.5 mr-1 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                <span x-text="charCount" class="mr-1 text-gray-700 dark:text-gray-300 font-semibold">0</span> karakter
            </span>
        </div>
        <div class="flex items-center text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 px-2 py-1 rounded-md">
            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Estimasi baca: <span x-text="readingTime" class="mx-1 font-semibold">0</span> mnt
        </div>
    </div>
    @error($name) <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
</div>
