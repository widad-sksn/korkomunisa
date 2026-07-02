import {
    ClassicEditor,
    Essentials,
    Paragraph,
    Heading,
    Bold,
    Italic,
    Underline,
    Strikethrough,
    Subscript,
    Superscript,
    FontFamily,
    FontSize,
    FontColor,
    FontBackgroundColor,
    Highlight,
    Alignment,
    BlockQuote,
    HorizontalLine,
    List,
    ListProperties,
    TodoList,
    Indent,
    IndentBlock,
    Table,
    TableToolbar,
    TableProperties,
    TableCellProperties,
    TableColumnResize,
    TableCaption,
    Image,
    ImageInsert,
    ImageUpload,
    ImageResize,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageBlock,
    ImageInline,
    MediaEmbed,
    Link,
    AutoLink,
    Code,
    CodeBlock,
    SpecialCharacters,
    SpecialCharactersEssentials,
    FindAndReplace,
    WordCount,
    Autosave,
    PasteFromOffice,
    RemoveFormat
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

class MyUploadAdapter {
    constructor(loader, moduleName) {
        this.loader = loader;
        this.moduleName = moduleName;
    }

    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            this._initRequest();
            this._initListeners(resolve, reject, file);
            this._sendRequest(file);
        }));
    }

    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        // Route upload global dengan parameter module
        xhr.open('POST', '/media/upload-image', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        xhr.responseType = 'json';
    }

    _initListeners(resolve, reject, file) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Gagal mengupload file: ${file.name}.`;

        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;
            if (!response || response.error) {
                return reject(response && response.error ? response.error.message || response.error : genericErrorText);
            }
            resolve({
                default: response.url
            });
        });

        if (xhr.upload) {
            xhr.upload.addEventListener('progress', evt => {
                if (evt.lengthComputable) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            });
        }
    }

    _sendRequest(file) {
        const data = new FormData();
        data.append('upload', file);
        data.append('module', this.moduleName);
        this.xhr.send(data);
    }
}

function MyCustomUploadAdapterPlugin(editor, moduleName) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader, moduleName);
    };
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.ck-editor-component').forEach(container => {
        const textarea = container.querySelector('.ck-textarea');
        if (!textarea) return;

        const moduleName = container.dataset.module || 'general';
        const pageKey = 'ckeditor-draft-' + window.location.pathname + '-' + textarea.name;

        // Restore draft if exists and textarea is empty
        const savedDraft = localStorage.getItem(pageKey);
        if (savedDraft && !textarea.value.trim()) {
            textarea.value = savedDraft;
        }

        ClassicEditor
            .create(textarea, {
                plugins: [
                    Essentials, Paragraph, Heading, Bold, Italic, Underline, Strikethrough,
                    Subscript, Superscript, FontFamily, FontSize, FontColor, FontBackgroundColor,
                    Highlight, Alignment, BlockQuote, HorizontalLine, List, ListProperties, TodoList,
                    Indent, IndentBlock, Table, TableToolbar, TableProperties, TableCellProperties,
                    TableColumnResize, TableCaption, Image, ImageInsert, ImageUpload, ImageResize,
                    ImageCaption, ImageStyle, ImageToolbar, ImageBlock, ImageInline, MediaEmbed, Link,
                    AutoLink, Code, CodeBlock, SpecialCharacters, SpecialCharactersEssentials,
                    FindAndReplace, WordCount, Autosave, PasteFromOffice, RemoveFormat
                ],
                toolbar: {
                    items: [
                        'undo', 'redo', '|',
                        'heading', '|',
                        'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', 'removeFormat', '|',
                        'alignment', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'link', 'insertImage', 'mediaEmbed', 'insertTable', 'blockQuote', 'code', 'codeBlock', 'horizontalLine', 'specialCharacters', '|',
                        'findAndReplace'
                    ],
                    shouldNotGroupWhenFull: false
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                },
                fontFamily: {
                    supportAllValues: true
                },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                image: {
                    resizeOptions: [
                        { name: 'resizeImage:original', value: null, label: 'Original' },
                        { name: 'resizeImage:50', value: '50', label: '50%' },
                        { name: 'resizeImage:75', value: '75', label: '75%' }
                    ],
                    toolbar: [
                        'imageTextAlternative', 'toggleImageCaption', '|',
                        'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                        'resizeImage'
                    ],
                    insert: {
                        integrations: [ 'upload', 'assetManager', 'url' ]
                    }
                },
                table: {
                    contentToolbar: [
                        'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties'
                    ]
                },
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                autosave: {
                    save(editor) {
                        return new Promise(resolve => {
                            const data = editor.getData();
                            // Save only if not empty or previously saved
                            if (data.trim() !== '') {
                                localStorage.setItem(pageKey, data);
                            }
                            resolve();
                        });
                    }
                },
                wordCount: {
                    onUpdate: stats => {
                        // Dispatch custom event to update Alpine component
                        container.dispatchEvent(new CustomEvent('ckeditor-word-count', {
                            detail: {
                                words: stats.words,
                                characters: stats.characters
                            }
                        }));
                    }
                }
            })
            .then(editor => {
                // Hook up the custom upload adapter
                MyCustomUploadAdapterPlugin(editor, moduleName);

                // Add form submit listener to clear draft
                const form = container.closest('form');
                if (form) {
                    form.addEventListener('submit', () => {
                        localStorage.removeItem(pageKey);
                    });
                }
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    });
});
