/**
 * CKEditor 5 Self-Hosted — Official Implementation
 * Package: ckeditor5 (modular, latest)
 * Framework: Laravel 12 + Vite
 * No CDN, No API Key
 */
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

// Expose ClassicEditor globally for debugging
window.ClassicEditor = ClassicEditor;

/**
 * Upload Adapter — sends files to /media/upload-image
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
            const token = document.querySelector('meta[name="csrf-token"]');
            if (token) xhr.setRequestHeader('X-CSRF-TOKEN', token.content);
            xhr.responseType = 'json';
            xhr.addEventListener('error', () => reject('Upload gagal.'));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const res = xhr.response;
                if (!res || res.error) return reject(res?.error || 'Upload gagal.');
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
            const fd = new FormData();
            fd.append('upload', file);
            fd.append('module', this.module);
            xhr.send(fd);
        }));
    }
    abort() { if (this.xhr) this.xhr.abort(); }
}

/**
 * Create a CKEditor instance on a textarea
 */
function createEditor(textarea) {
    if (textarea.dataset.ckInitialized === '1') return;
    textarea.dataset.ckInitialized = '1';

    const wrapper = textarea.closest('[data-ckeditor]');
    const module = wrapper ? wrapper.dataset.module || 'general' : 'general';
    const draftKey = `ck-draft:${location.pathname}:${textarea.name || textarea.id}`;

    // Restore draft
    const draft = localStorage.getItem(draftKey);
    if (draft && !textarea.value.trim()) {
        textarea.value = draft;
    }

    // Upload adapter plugin — registered via extraPlugins BEFORE create
    function UploadPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = loader => {
            return new UploadAdapter(loader, module);
        };
    }

    console.log('[CKEditor] Initializing on:', textarea.name || textarea.id);

    ClassicEditor.create(textarea, {
        plugins: [
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
        ],
        extraPlugins: [UploadPlugin],
        toolbar: {
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
                if (!wrapper) return;
                const wEl = wrapper.querySelector('[data-ck-words]');
                const cEl = wrapper.querySelector('[data-ck-chars]');
                const tEl = wrapper.querySelector('[data-ck-time]');
                if (wEl) wEl.textContent = stats.words;
                if (cEl) cEl.textContent = stats.characters;
                if (tEl) tEl.textContent = Math.max(1, Math.ceil(stats.words / 200));
            }
        }
    })
    .then(editor => {
        console.log('[CKEditor] ✅ Ready:', textarea.name || textarea.id);
        // Clear draft on form submit
        const form = textarea.closest('form');
        if (form) {
            form.addEventListener('submit', () => localStorage.removeItem(draftKey));
        }
    })
    .catch(err => {
        console.error('[CKEditor] ❌ Error:', err);
    });
}

/**
 * Find and initialize all CKEditor textareas
 */
function initAll() {
    const wrappers = document.querySelectorAll('[data-ckeditor]');
    console.log('[CKEditor] Found', wrappers.length, 'editor wrapper(s)');
    wrappers.forEach(wrapper => {
        const ta = wrapper.querySelector('textarea');
        if (ta) createEditor(ta);
    });
}

// Strategy 1: DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('[CKEditor] DOMContentLoaded fired');
    initAll();
});

// Strategy 2: If DOM is already ready (module scripts run deferred)
if (document.readyState !== 'loading') {
    console.log('[CKEditor] DOM already ready');
    initAll();
}

// Strategy 3: MutationObserver fallback — catches late-rendered elements (e.g. Livewire, Turbo)
const observer = new MutationObserver(() => {
    const uninit = document.querySelectorAll('[data-ckeditor] textarea:not([data-ck-initialized="1"])');
    if (uninit.length > 0) {
        console.log('[CKEditor] MutationObserver found', uninit.length, 'new textarea(s)');
        uninit.forEach(ta => createEditor(ta));
    }
});
observer.observe(document.body || document.documentElement, { childList: true, subtree: true });
