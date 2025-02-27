import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/js/**/*.svelte',
    ],
    theme: {
        extend: {
            margin: {
                'body': '0px'
            },
            transitionProperty: {
                'height': 'position',
            }
        }
    },
    plugins: [
        require('daisyui'),
    ]
};
