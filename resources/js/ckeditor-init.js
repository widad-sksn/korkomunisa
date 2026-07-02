import {
    ClassicEditor,
    Essentials,
    Paragraph,
    Heading,
    Bold,
    Italic,
    Underline,
    Strikethrough,
    FontFamily,
    FontSize,
    FontColor,
    FontBackgroundColor,
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
    WordCount,
    Autosave,
    PasteFromOffice,
    RemoveFormat,
    FileRepository
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';

/**
 * Custom Upload Adapter - sends images to Laravel backend
 */
class UploadAdapter {
    constructor(loader, module) {
        this.loader = loader;
        this.module = module;
    }

    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const xhr = this.xhr = new XMLHttpRequest();
            xhr.open('POST', '/media/upload-image', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
            xhr.responseType = 'json';

            xhr.addEventListener('error', () => reject('Upload gagal.'));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const res = xhr.response;
                if (!res || res.error) {
                    return reject(res && res.error ? res.error : 'Upload gagal.');
                }
                resolve({ default: res.url });
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        this.loader.uploadTotal = evt.total;
                        this.loader.uploaded = evt.loaded;
                    }
                });
            }

            const data = new FormData();
            data.append('upload', file);
            data.append('module', this.module);
            xhr.send(data);
        }));
    }

    abort() {
        if (this.xhr) this.xhr.abort();
    }
}

/**
 * All CKEditor plugins used across the CMS
 */
const PLUGINS = [
    Essentials, Paragraph, Heading,
    Bold, Italic, Underline, Strikethrough,
    FontFamily, FontSize, FontColor, FontBackgroundColor,
    Alignment, BlockQuote, HorizontalLine,
    List, ListProperties, TodoList,
    Indent, IndentBlock,
    Table, TableToolbar, TableProperties, TableCellProperties, TableColumnResize,
    Image, ImageInsert, ImageUpload, ImageResize, ImageCaption, ImageStyle, ImageToolbar, ImageBlock, ImageInline,
    MediaEmbed, Link, AutoLink,
    Code, CodeBlock,
    WordCount, Autosave, PasteFromOffice, RemoveFormat,
    FileRepository
];

/**
 * Standard toolbar configuration
 */
const TOOLBAR = {
    items: [
        'undo', 'redo', '|',
        'heading', '|',
        'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
        'bold', 'italic', 'underline', 'strikethrough', 'removeFormat', '|',
        'alignment', '|',
        'bulletedList', 'numberedList', 'todoList', '|',
        'outdent', 'indent', '|',
        'link', 'insertImage', 'mediaEmbed', 'insertTable', 'blockQuote', 'codeBlock', 'horizontalLine'
    ],
    shouldNotGroupWhenFull: false
};

/**
 * Initialize all CKEditor instances on the page
 */
function initEditors() {
    const containers = document.querySelectorAll('[data-ckeditor]');

    containers.forEach(wrapper => {
        const textarea = wrapper.querySelector('textarea');
        if (!textarea || textarea.dataset.ckReady === 'true') return;

        const module = wrapper.dataset.module || 'general';
        const draftKey = `ck-draft:${location.pathname}:${textarea.name}`;

        // Restore draft
        const draft = localStorage.getItem(draftKey);
        if (draft && !textarea.value.trim()) {
            textarea.value = draft;
        }

        // Upload adapter factory — must be registered via extraPlugins BEFORE creation
        function UploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = loader => {
                return new UploadAdapter(loader, module);
            };
        }

        ClassicEditor
            .create(textarea, {
                plugins: PLUGINS,
                extraPlugins: [UploadAdapterPlugin],
                toolbar: TOOLBAR,
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                },
                fontFamily: { supportAllValues: true },
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22, 24, 28, 32],
                    supportAllValues: true
                },
                image: {
                    resizeOptions: [
                        { name: 'resizeImage:original', value: null, label: 'Original' },
                        { name: 'resizeImage:25', value: '25', label: '25%' },
                        { name: 'resizeImage:50', value: '50', label: '50%' },
                        { name: 'resizeImage:75', value: '75', label: '75%' }
                    ],
                    toolbar: [
                        'imageTextAlternative', 'toggleImageCaption', '|',
                        'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|',
                        'resizeImage'
                    ]
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
                },
                list: {
                    properties: { styles: true, startIndex: true, reversed: true }
                },
                autosave: {
                    save(editor) {
                        const data = editor.getData();
                        if (data.trim()) localStorage.setItem(draftKey, data);
                        return Promise.resolve();
                    }
                },
                wordCount: {
                    onUpdate(stats) {
                        const wcWords = wrapper.querySelector('[data-ck-words]');
                        const wcChars = wrapper.querySelector('[data-ck-chars]');
                        const wcTime = wrapper.querySelector('[data-ck-time]');
                        if (wcWords) wcWords.textContent = stats.words;
                        if (wcChars) wcChars.textContent = stats.characters;
                        if (wcTime) wcTime.textContent = Math.max(1, Math.ceil(stats.words / 200));
                    }
                }
            })
            .then(editor => {
                textarea.dataset.ckReady = 'true';

                // Clear draft on form submit
                const form = wrapper.closest('form');
                if (form) {
                    form.addEventListener('submit', () => localStorage.removeItem(draftKey));
                }
            })
            .catch(err => {
                console.error('CKEditor init error:', err);
            });
    });
}

// Run on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEditors);
} else {
    initEditors();
}
