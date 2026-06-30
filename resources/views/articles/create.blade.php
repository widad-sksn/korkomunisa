<x-app-layout>
    <x-slot name="header">
        <div class="max-w-3xl mx-auto">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Buat Tulisan Baru') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Tulis artikel yang akan dikirim untuk ditinjau oleh administrator sebelum dipublikasikan.
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                        @csrf
                        
                        <!-- Title Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" for="title">Judul Tulisan</label>
                            <input type="text" name="title" id="title" class="w-full px-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 shadow-sm" value="{{ old('title') }}" placeholder="Contoh: Peran Mahasiswa dalam Era Digital..." required>
                            @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Content Textarea -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300" for="content">Isi Tulisan</label>
                                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Format Markdown didukung
                                </span>
                            </div>
                            <textarea name="content" id="content" class="w-full min-h-[250px] px-4 py-3 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 shadow-sm resize-y" placeholder="Mulai menulis karya Anda di sini..." required>{{ old('content') }}</textarea>
                            @error('content') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Media Upload (Alpine Component) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Foto / Video (Opsional)</label>
                            
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
                                
                                <input type="file" name="media" id="media" x-ref="fileInput" @change="handleSelect" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*,video/*">
                                
                                <div class="text-gray-500 dark:text-gray-400 pointer-events-none flex flex-col items-center">
                                    <!-- Show when no file is selected -->
                                    <template x-if="!fileName">
                                        <div class="flex flex-col items-center">
                                            <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-full mb-3">
                                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            </div>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Klik untuk memilih atau drag and drop file di sini</p>
                                            <p class="text-xs text-gray-500 mt-1">Mendukung JPG, PNG, GIF, MP4 (Maks 20MB)</p>
                                        </div>
                                    </template>
                                    
                                    <!-- Show when file is selected -->
                                    <template x-if="fileName">
                                        <div class="flex flex-col items-center text-indigo-600 dark:text-indigo-400">
                                            <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-full mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-sm font-semibold" x-text="fileName"></p>
                                            <p class="text-xs text-indigo-500 mt-1">Klik atau drag file lain untuk menimpa</p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            @error('media') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-4 mt-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit" class="px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-semibold rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 transition-all duration-200 shadow-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim untuk Persetujuan
                            </button>
                            <a href="{{ route('articles.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 bg-transparent hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
