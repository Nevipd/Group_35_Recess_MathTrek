import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./src/**/*.{html,js}",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                mauve: {
                  100: '#EDE7F6',
                },
                cream: {
                  100: '#FFF9C4',
                },
                slate: {
                  800: '#2E3440',
                },
                blue: {
                  300: '#B3C7E6',
                },
              },
        },
    },

    plugins: [forms],
};
