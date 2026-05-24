import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                serif: ['Lora', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                cream: {
                    50: '#F8F5EF', // Cream Base
                    100: '#F3EFE6',
                    200: '#EAE5D5',
                    300: '#F4EEDC',
                    400: '#EADBB9',
                    500: '#D5BE8A',
                },
                coral: {
                    50: '#FDF5F3',
                    100: '#FCEAE6',
                    200: '#F8CDCE',
                    300: '#F39E8E',
                    400: '#EB7057',
                    500: '#E85A3A', // Coral Accent
                    600: '#CD4223',
                    700: '#A23218',
                },
                navy: {
                    50: '#F4F6F8',
                    100: '#E9ECF1',
                    200: '#CAD3DF',
                    300: '#A2B1C7',
                    400: '#788CA7',
                    500: '#556D8C',
                    600: '#42556F',
                    700: '#223149', // Secondary Navy
                    800: '#172132', // Primary Navy
                    900: '#1E293B', // Text Dark
                    950: '#1E293B', // Text Dark Alt
                },
            },
        },
    },

    plugins: [forms],
};
