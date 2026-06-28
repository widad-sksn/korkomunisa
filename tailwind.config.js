import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                theme: {
                    bg: 'var(--color-bg)',
                    surface: 'var(--color-surface)',
                    navbar: 'var(--color-navbar)',
                    primary: 'var(--color-primary)',
                    hover: 'var(--color-hover)',
                    text: 'var(--color-text)',
                    secondary: 'var(--color-text-secondary)',
                    border: 'var(--color-border)',
                }
            }
        },
    },

    plugins: [forms],
};
