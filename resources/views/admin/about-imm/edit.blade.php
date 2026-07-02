<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-theme-text leading-tight">
            {{ __('Kelola Halaman Tentang IMM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-theme-surface overflow-hidden shadow-sm sm:rounded-lg border border-theme-border">
                <div class="p-6 text-theme-text">
                    <form action="{{ route('admin.about-imm.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Judul Halaman')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full bg-theme-bg border-theme-border text-theme-text" :value="old('title', $about->title)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        
                        <div class="mb-6">
                            <x-editor name="content" module="about" :value="old('content', $about->content)" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="bg-theme-primary hover:bg-theme-hover">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>
