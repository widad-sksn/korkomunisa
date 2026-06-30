<x-app-layout title="Posting Kegiatan">
    <x-slot name="header">
        <div class="max-w-3xl mx-auto">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Posting Kegiatan Baru') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Dokumentasikan portofolio kegiatan komisariat untuk ditampilkan di halaman publik.
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                        @csrf
                        
                        <!-- Title Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" for="title">Judul / Nama Kegiatan</label>
                            <input type="text" name="title" id="title" class="w-full px-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 shadow-sm" value="{{ old('title') }}" placeholder="Contoh: Darul Arqam Dasar FST 2024..." required>
                            @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description Textarea -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" for="description">Deskripsi Kegiatan</label>
                            <textarea name="description" id="description" class="w-full min-h-[160px] px-4 py-3 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 shadow-sm resize-y" placeholder="Ceritakan detail kegiatan, peserta, dan hasil yang dicapai..." required>{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- URL Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" for="url">Link Berita Eksternal / URL (Opsional)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </div>
                                <input type="url" name="url" id="url" class="w-full pl-10 px-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 shadow-sm" value="{{ old('url') }}" placeholder="https://contoh.com/berita-kegiatan">
                            </div>
                            @error('url') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image Upload (Alpine Component) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Gambar / Foto Dokumentasi Utama</label>
                            
                            <div x-data="{ 
                                    isDragging: false, 
                                    fileName: '', 
                                    handleDrop(e) {
                                        this.isDragging = false;
                                        const files = e.dataTransfer.files;
                                        if (files.length > 0) {
                                            this.$refs.fileInput.files = files;
                                            this.fileName = files[0].name;
                                        }
                                    },
                                    handleSelect(e) {
                                        const files = e.target.files;
                                        if (files.length > 0) {
                                            this.fileName = files[0].name;
                                        } else {
                                            this.fileName = '';
                                        }
                                    }
                                }"
                                class="relative border-2 border-dashed rounded-xl p-8 flex flex-col items-center justify-center text-center transition-colors duration-200"
                                :class="isDragging ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/30 bg-white dark:bg-gray-800'"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)">
                                
                                <input type="file" name="image" id="image" x-ref="fileInput" @change="handleSelect" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                
                                <div class="text-gray-500 dark:text-gray-400 pointer-events-none flex flex-col items-center">
                                    <!-- Show when no file is selected -->
                                    <template x-if="!fileName">
                                        <div class="flex flex-col items-center">
                                            <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-full mb-3">
                                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Klik untuk memilih atau drag foto ke sini</p>
                                            <p class="text-xs text-gray-500 mt-1">Mendukung JPG, PNG, GIF</p>
                                        </div>
                                    </template>
                                    
                                    <!-- Show when file is selected -->
                                    <template x-if="fileName">
                                        <div class="flex flex-col items-center text-indigo-600 dark:text-indigo-400">
                                            <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-full mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-sm font-semibold" x-text="fileName"></p>
                                            <p class="text-xs text-indigo-500 mt-1">Klik atau drag foto lain untuk menimpa</p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            @error('image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-4 mt-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit" class="px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-semibold rounded-lg hover:bg-gray-800 dark:focus:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 transition-all duration-200 shadow-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Posting Kegiatan
                            </button>
                            <a href="{{ route('portfolios.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 bg-transparent hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
