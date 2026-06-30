<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="komisariat" :value="__('Komisariat')" />
            <select id="komisariat" name="komisariat" class="mt-1 block w-full bg-theme-bg border-theme-border text-theme-text focus:border-theme-primary focus:ring-theme-primary rounded-xl shadow-sm transition-colors duration-200 py-2.5 px-4" required>
                <option value="" disabled>Pilih Komisariat</option>
                <option value="IMM FST" {{ old('komisariat', $user->komisariat) == 'IMM FST' ? 'selected' : '' }}>IMM FST</option>
                <option value="IMM Rosyad Sholeh" {{ old('komisariat', $user->komisariat) == 'IMM Rosyad Sholeh' ? 'selected' : '' }}>IMM Rosyad Sholeh</option>
                <option value="IMM FIKES" {{ old('komisariat', $user->komisariat) == 'IMM FIKES' ? 'selected' : '' }}>IMM FIKES</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('komisariat')" />
        </div>

        <div>
            <x-input-label :value="__('Foto Profil')" />
            
            <div x-data="{
                    isDragging: false,
                    fileName: '',
                    fileType: '',
                    previewUrl: null,
                    cropper: null,
                    showCropModal: false,
                    isRemoving: false,
                    hasExisting: {{ $user->avatar ? 'true' : 'false' }},
                    existingUrl: '{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}',
                    
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
                            aspectRatio: 1,
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
                            width: 512,
                            height: 512,
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
                            this.isRemoving = false;
                            
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
                        if (this.hasExisting) {
                            this.isRemoving = true;
                        }
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
                }" class="mt-2">
                
                <input type="hidden" name="remove_avatar" :value="isRemoving ? '1' : '0'">
                <input type="file" name="avatar" id="avatar" x-ref="fileInput" @change="handleSelect" class="hidden" accept="image/*">
                
                <div class="flex items-center gap-6">
                    <!-- Avatar Preview Area -->
                    <div class="relative w-24 h-24 sm:w-32 sm:h-32 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-800 border-2 flex items-center justify-center shrink-0 transition-colors duration-200"
                        :class="isDragging ? 'border-indigo-500' : 'border-gray-300 dark:border-gray-600'"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleDrop($event)">
                        
                        <!-- Empty State -->
                        <template x-if="!previewUrl && (!hasExisting || isRemoving)">
                            <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500 w-full h-full bg-gray-50 dark:bg-gray-900/50">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </template>

                        <!-- Existing or New Preview -->
                        <template x-if="previewUrl || (hasExisting && !isRemoving)">
                            <img :src="previewUrl || existingUrl" class="w-full h-full object-cover">
                        </template>

                        <!-- Hover Overlay for Drag & Drop -->
                        <div class="absolute inset-0 bg-indigo-500/20 backdrop-blur-sm flex items-center justify-center opacity-0 transition-opacity"
                            :class="isDragging ? 'opacity-100' : ''">
                            <svg class="w-8 h-8 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <button type="button" @click="$refs.fileInput.click()" class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm">
                                Ganti Foto
                            </button>
                            <template x-if="previewUrl || (hasExisting && !isRemoving)">
                                <button type="button" @click="removeFile" class="px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                    Hapus
                                </button>
                            </template>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Rekomendasi: 1:1 rasio, format JPG/PNG/WebP, maksimal 2MB.</p>
                        
                        <template x-if="previewUrl">
                            <div class="inline-flex items-center text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2.5 py-1 rounded-md w-fit mt-1 border border-green-200 dark:border-green-800/30">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Siap diunggah
                            </div>
                        </template>
                        <template x-if="isRemoving">
                            <div class="inline-flex items-center text-xs font-medium text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 px-2.5 py-1 rounded-md w-fit mt-1 border border-amber-200 dark:border-amber-800/30">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Foto akan dihapus saat disimpan
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- Modal Crop -->
                <div x-show="showCropModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4" x-transition x-cloak style="display: none;">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden w-full max-w-2xl shadow-2xl flex flex-col max-h-[90vh]">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sesuaikan Foto Profil</h3>
                            <button type="button" @click="cancelCrop" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="p-4 bg-gray-100 dark:bg-gray-900 flex-grow relative min-h-[300px] md:min-h-[400px]">
                            <img x-ref="cropImage" :src="previewUrl" class="block max-w-full">
                        </div>
                        
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="flex items-center gap-2 w-full sm:w-auto justify-center">
                                <button type="button" @click="zoomIn" class="p-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" title="Zoom In">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </button>
                                <button type="button" @click="zoomOut" class="p-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" title="Zoom Out">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path></svg>
                                </button>
                                <button type="button" @click="resetCrop" class="p-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" title="Reset">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </div>
                            
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <button type="button" @click="cancelCrop" class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors">
                                    Batal
                                </button>
                                <button type="button" @click="saveCrop" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium shadow-sm transition-colors flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Terapkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
