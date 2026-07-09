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
                        
                        <div x-data="{ langTab: 'id' }" class="border border-theme-border rounded-xl overflow-hidden mb-6">
                            <div class="flex bg-theme-surface border-b border-theme-border">
                                <button type="button" @click="langTab = 'id'" :class="langTab == 'id' ? 'border-theme-primary text-theme-primary' : 'border-transparent text-theme-text opacity-70 hover:opacity-100'" class="flex-1 px-4 py-3 border-b-2 font-medium text-sm transition-colors">Indonesia</button>
                                <button type="button" @click="langTab = 'en'" :class="langTab == 'en' ? 'border-theme-primary text-theme-primary' : 'border-transparent text-theme-text opacity-70 hover:opacity-100'" class="flex-1 px-4 py-3 border-b-2 font-medium text-sm transition-colors">English</button>
                                <button type="button" @click="langTab = 'ar'" :class="langTab == 'ar' ? 'border-theme-primary text-theme-primary' : 'border-transparent text-theme-text opacity-70 hover:opacity-100'" class="flex-1 px-4 py-3 border-b-2 font-medium text-sm transition-colors">Arabic</button>
                            </div>
                            
                            <div class="p-6 space-y-6">
                                <!-- Indonesia -->
                                <div x-show="langTab == 'id'" class="space-y-6">
                                    <div>
                                        <x-input-label for="title_id" :value="__('Judul Halaman (ID)')" />
                                        <x-text-input id="title_id" name="title[id]" type="text" class="mt-1 block w-full bg-theme-bg border-theme-border text-theme-text" :value="old('title.id', $about->getTranslation('title', 'id', false))" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('title.id')" />
                                    </div>
                                    <div>
                                        <x-editor name="content[id]" id="content_id" module="about" :value="old('content.id', $about->getTranslation('content', 'id', false))" label="Konten Halaman (ID)" />
                                    </div>
                                </div>
                                
                                <!-- English -->
                                <div x-show="langTab == 'en'" style="display: none;" class="space-y-6">
                                    <div>
                                        <x-input-label for="title_en" :value="__('Title (EN)')" />
                                        <x-text-input id="title_en" name="title[en]" type="text" class="mt-1 block w-full bg-theme-bg border-theme-border text-theme-text" :value="old('title.en', $about->getTranslation('title', 'en', false))" />
                                    </div>
                                    <div>
                                        <x-editor name="content[en]" id="content_en" module="about" :value="old('content.en', $about->getTranslation('content', 'en', false))" label="Content (EN)" />
                                    </div>
                                </div>

                                <!-- Arabic -->
                                <div x-show="langTab == 'ar'" style="display: none;" class="space-y-6">
                                    <div>
                                        <x-input-label for="title_ar" :value="__('Title (AR)')" />
                                        <x-text-input id="title_ar" name="title[ar]" dir="rtl" type="text" class="mt-1 block w-full bg-theme-bg border-theme-border text-theme-text text-right" :value="old('title.ar', $about->getTranslation('title', 'ar', false))" />
                                    </div>
                                    <div>
                                        <x-editor name="content[ar]" id="content_ar" module="about" :value="old('content.ar', $about->getTranslation('content', 'ar', false))" label="Content (AR)" />
                                    </div>
                                </div>
                            </div>
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
