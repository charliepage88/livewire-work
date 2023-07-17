const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        // colors: {
        //     transparent: 'transparent',
        //     current: 'currentColor',
        //     black: colors.black,
        //     white: colors.white,
        //     gray: colors.neutral,
        //     red: colors.red,
        //     blue: colors.blue,
        //     yellow: colors.yellow,
        //     orange: colors.orange,
        //     indigo: colors.indigo,
        //     green: colors.green,
        //     purple: colors.purple,
        //     pink: colors.pink
        // }
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
    corePlugins: {
        space: true,
        width: true,
        padding: true,
    }
};
