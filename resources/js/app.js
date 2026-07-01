import './bootstrap';

import Alpine from 'alpinejs';

import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

window.Alpine = Alpine;
window.ClassicEditor = ClassicEditor;

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
