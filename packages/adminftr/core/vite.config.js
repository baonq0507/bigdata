import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

const packageEntrys = [
    './resources/assets/sass/app.scss',
    './resources/assets/js/app.js'
];


export default defineConfig({
    plugins: [
        laravel({
            input: packageEntrys,
            refresh: true,
        }),
    ],
});

export const paths = [
    'packages/adminftr/core/resources/assets/sass/app.scss',
    'packages/adminftr/core/resources/assets/js/app.js'
];
