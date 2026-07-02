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
                            <x-input-label for="content" :value="__('Konten Halaman')" class="mb-2" />
                            <textarea id="content" name="content" class="mt-1 block w-full bg-theme-bg border-theme-border text-theme-text">{{ old('content', $about->content) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
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
    
    <!-- CKEditor Initialization -->
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
    <script>
        class MyUploadAdapter {
            constructor( loader ) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then( file => new Promise( ( resolve, reject ) => {
                        this._initRequest();
                        this._initListeners( resolve, reject, file );
                        this._sendRequest( file );
                    } ) );
            }

            abort() {
                if ( this.xhr ) {
                    this.xhr.abort();
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open( 'POST', '{{ route("admin.about-imm.upload") }}', true );
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }

            _initListeners( resolve, reject, file ) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                xhr.addEventListener( 'error', () => reject( genericErrorText ) );
                xhr.addEventListener( 'abort', () => reject() );
                xhr.addEventListener( 'load', () => {
                    const response = xhr.response;
                    if ( !response || response.error ) {
                        return reject( response && response.error ? response.error.message : genericErrorText );
                    }
                    resolve( {
                        default: response.url
                    } );
                } );

                if ( xhr.upload ) {
                    xhr.upload.addEventListener( 'progress', evt => {
                        if ( evt.lengthComputable ) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    } );
                }
            }

            _sendRequest( file ) {
                const data = new FormData();
                data.append( 'upload', file );
                this.xhr.send( data );
            }
        }

        function MyCustomUploadAdapterPlugin( editor ) {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                return new MyUploadAdapter( loader );
            };
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (window.ClassicEditor) {
                ClassicEditor
                    .create( document.querySelector( '#content' ), {
                        plugins: window.CKEditorPlugins || [],
                        extraPlugins: [ MyCustomUploadAdapterPlugin ],
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                                'imageUpload', 'blockQuote', 'insertTable', 'undo', 'redo'
                            ]
                        },
                        image: {
                            resizeOptions: [
                                { name: 'resizeImage:original', value: null, label: 'Original' },
                                { name: 'resizeImage:50', value: '50', label: '50%' },
                                { name: 'resizeImage:75', value: '75', label: '75%' }
                            ],
                            toolbar: [
                                'imageTextAlternative',
                                'toggleImageCaption',
                                '|',
                                'imageStyle:inline',
                                'imageStyle:block',
                                'imageStyle:side',
                                '|',
                                'resizeImage'
                            ]
                        },
                        table: {
                            contentToolbar: [
                                'tableColumn',
                                'tableRow',
                                'mergeTableCells'
                            ]
                        }
                    } )
                    .catch( error => {
                        console.error( error );
                    } );
            } else {
                console.error("CKEditor tidak termuat. Pastikan npm run dev / build sudah dijalankan.");
            }
        });
    </script>
</x-app-layout>
