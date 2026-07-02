import './bootstrap';

import Alpine from 'alpinejs';

import { ClassicEditor, Essentials, Bold, Italic, Link, Paragraph, Image, ImageUpload, ImageToolbar, ImageStyle, ImageResize, ImageCaption, List, BlockQuote, Table, Undo } from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

window.Alpine = Alpine;
window.ClassicEditor = ClassicEditor;
window.CKEditorPlugins = [ Essentials, Bold, Italic, Link, Paragraph, Image, ImageUpload, ImageToolbar, ImageStyle, ImageResize, ImageCaption, List, BlockQuote, Table, Undo ];

// Initialization moved to inline script in head to prevent flicker

Alpine.data('themeSwitcher', () => ({
    isDark: localStorage.theme === 'dark',
    toggleTheme() {
        this.isDark = !this.isDark;
        if (this.isDark) {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        }
    }
}));

Alpine.start();
