const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ['./resources/**/*.blade.php', './vendor/filament/**/*.blade.php'],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.amber,
                success: colors.green,
                warning: colors.amber,
            },
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
