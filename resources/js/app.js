import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

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

// Replace history entry on language switch so back button returns immediately to previous page
document.addEventListener('click', (e) => {
    const langLink = e.target.closest('a[href*="/lang/"]');
    if (langLink) {
        e.preventDefault();
        window.location.replace(langLink.href);
    }
});
