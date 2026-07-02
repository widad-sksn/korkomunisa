<x-app-layout title="Posting Kegiatan">
    <x-slot name="header">
        <div class="w-full">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Posting Kegiatan Baru') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Dokumentasikan portofolio kegiatan komisariat untuk ditampilkan di halaman publik.
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                        @csrf
                        
                        <!-- Title Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" for="title">Judul / Nama Kegiatan</label>
                            <input type="text" name="title" id="title" class="w-full px-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 shadow-sm" value="{{ old('title') }}" placeholder="Contoh: Darul Arqam Dasar FST 2024..." required>
                            @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image Upload (Alpine Component with Cropper) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Gambar / Foto Dokumentasi Utama</label>
                            
                            <div x-data="{
                                    isDragging: false,
                                    fileName: '',
                                    fileType: '',
                                    previewUrl: null,
                                    cropper: null,
                                    showCropModal: false,
                                    
                                    handleDrop(e) {
                                        this.isDragging = false;
                                        const files = e.dataTransfer.files;
                                        this.processFiles(files);
                                    },
                                    handleSelect(e) {
                                        const files = e.target.files;
                                        this.processFiles(files);
                                    },
                                    processFiles(files) {
                                        if (files.length > 0) {
                                            const selectedFile = files[0];
                                            this.fileType = selectedFile.type;
                                            this.fileName = selectedFile.name;
                                            
                                            if (this.fileType.startsWith('image/')) {
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    this.previewUrl = e.target.result;
                                                    this.showCropModal = true;
                                                    this.$nextTick(() => {
                                                        this.initCropper();
                                                    });
                                                };
                                                reader.readAsDataURL(selectedFile);
                                            }
                                        }
                                    },
                                    initCropper() {
                                        if (this.cropper) {
                                            this.cropper.destroy();
                                        }
                                        const image = this.$refs.cropImage;
                                        this.cropper = new Cropper(image, {
                                            aspectRatio: 16 / 9,
                                            viewMode: 1,
                                            dragMode: 'move',
                                            autoCropArea: 1,
                                            restore: false,
                                            guides: true,
                                            center: true,
                                            highlight: false,
                                            cropBoxMovable: true,
                                            cropBoxResizable: true,
                                            toggleDragModeOnDblclick: false,
                                        });
                                    },
                                    saveCrop() {
                                        if (!this.cropper) return;
                                        
                                        const canvas = this.cropper.getCroppedCanvas({
                                            width: 1200,
                                            height: 675,
                                            imageSmoothingEnabled: true,
                                            imageSmoothingQuality: 'high',
                                        });
                                        
                                        canvas.toBlob((blob) => {
                                            if (!blob) return;
                                            
                                            const newFile = new File([blob], this.fileName.replace(/\.[^/.]+$/, '') + '.webp', {
                                                type: 'image/webp',
                                                lastModified: new Date().getTime()
                                            });
                                            
                                            const dataTransfer = new DataTransfer();
                                            dataTransfer.items.add(newFile);
                                            this.$refs.fileInput.files = dataTransfer.files;
                                            
                                            this.previewUrl = URL.createObjectURL(blob);
                                            this.showCropModal = false;
                                            this.fileType = 'image/webp';
                                            this.fileName = newFile.name;
                                            
                                            this.cropper.destroy();
                                            this.cropper = null;
                                        }, 'image/webp', 0.8);
                                    },
                                    cancelCrop() {
                                        this.showCropModal = false;
                                        if (this.cropper) {
                                            this.cropper.destroy();
                                            this.cropper = null;
                                        }
                                        if (!this.$refs.fileInput.files.length) {
                                            this.fileName = '';
                                            this.fileType = '';
                                            this.previewUrl = null;
                                        }
                                    },
                                    removeFile() {
                                        this.$refs.fileInput.value = '';
                                        this.fileName = '';
                                        this.fileType = '';
                                        this.previewUrl = null;
                                        this.showCropModal = false;
                                    },
                                    zoomIn() {
                                        if(this.cropper) this.cropper.zoom(0.1);
                                    },
                                    zoomOut() {
                                        if(this.cropper) this.cropper.zoom(-0.1);
                                    },
                                    resetCrop() {
                                        if(this.cropper) this.cropper.reset();
                                    }
                                }">
                                
                                <div class="relative border-2 border-dashed rounded-xl p-2 flex flex-col items-center justify-center text-center transition-colors duration-200 overflow-hidden"
                                    :class="isDragging ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/30 bg-white dark:bg-gray-800'"
                                    @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false"
                                    @drop.prevent="handleDrop($event)"
                                    :style="previewUrl ? 'padding: 0; border-style: solid;' : ''">
                                    
                                    <input type="file" name="image" id="image" x-ref="fileInput" @change="handleSelect" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" :class="previewUrl ? 'hidden' : ''" required>
                                    
                                    <!-- State 1: Kosong -->
                                    <template x-if="!fileName">
                                        <div class="p-8 flex flex-col items-center pointer-events-none">
                                            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                                <svg class="w-8 h-8 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <p class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Foto atau Tarik ke sini</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Rasio 16:9 (JPG, PNG, WebP)</p>
                                        </div>
                                    </template>
                                    
                                    <!-- State 3: Preview Gambar Crop -->
                                    <template x-if="fileName && previewUrl">
                                        <div class="w-full relative group">
                                            <img :src="previewUrl" class="w-full h-auto aspect-video object-cover rounded-lg">
                                            
                                            <!-- Overlay Actions -->
                                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4 rounded-lg backdrop-blur-sm">
                                                <button type="button" @click="$refs.fileInput.click()" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg backdrop-blur-md font-medium transition-colors flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                    Ganti
                                                </button>
                                                <button type="button" @click="removeFile" class="px-4 py-2 bg-red-500/80 hover:bg-red-600/90 text-white rounded-lg backdrop-blur-md font-medium transition-colors flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Hapus
                                                </button>
                                            </div>
                                            
                                            <!-- Badge -->
                                            <div class="absolute bottom-3 left-3 bg-black/70 text-white text-xs px-2.5 py-1 rounded-md backdrop-blur-md border border-white/10 flex items-center">
                                                <svg class="w-3 h-3 mr-1.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Siap Diunggah (<span x-text="fileName"></span>)
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- Modal Crop -->
                                <div x-show="showCropModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4" x-transition x-cloak style="display: none;">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden w-full max-w-4xl shadow-2xl flex flex-col max-h-[90vh]">
                                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sesuaikan Foto (16:9)</h3>
                                            <button type="button" @click="cancelCrop" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        
                                        <div class="p-4 bg-gray-100 dark:bg-gray-900 flex-grow relative min-h-[300px] md:min-h-[500px]">
                                            <img x-ref="cropImage" :src="previewUrl" class="block max-w-full">
                                        </div>
                                        
                                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-col md:flex-row justify-between items-center gap-4">
                                            <div class="flex items-center gap-2 w-full md:w-auto justify-center">
                                                <button type="button" @click="zoomIn" class="p-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" title="Zoom In">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                                </button>
                                                <button type="button" @click="zoomOut" class="p-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" title="Zoom Out">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path></svg>
                                                </button>
                                                <button type="button" @click="resetCrop" class="p-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" title="Reset">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </button>
                                            </div>
                                            
                                            <div class="flex items-center gap-3 w-full md:w-auto">
                                                <button type="button" @click="cancelCrop" class="w-full md:w-auto px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors">
                                                    Batal
                                                </button>
                                                <button type="button" @click="saveCrop" class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium shadow-sm transition-colors flex items-center justify-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Terapkan Crop
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
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

                        <!-- Description Textarea -->
                        <div>
                            <x-editor name="description" module="events" :value="old('description')" label="Deskripsi Kegiatan" />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-4 mt-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit" :disabled="isSubmitting" :class="isSubmitting ? 'opacity-70 cursor-not-allowed' : 'hover:bg-gray-800 dark:hover:bg-gray-100'" class="px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-semibold rounded-lg focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 transition-all duration-200 shadow-sm flex items-center">
                                <svg x-show="!isSubmitting" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                <svg x-show="isSubmitting" class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" x-cloak style="display: none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span x-text="isSubmitting ? 'Memproses...' : 'Posting Kegiatan'"></span>
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
