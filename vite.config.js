import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import collectModuleAssetsPaths from './vite-module-loader.js';

async function getConfig() {
    const paths = [
        'resources/css/app.scss',
        'resources/css/app.css',
        'resources/js/app.js'
    ];
    const allPaths = await collectModuleAssetsPaths(paths, 'packages');
    console.log(allPaths);
    return defineConfig({
        server: {
            host: '0.0.0.0',
            port: '3001',
        },
        plugins: [
            laravel({
                input: allPaths,
                refresh: true,
            })
        ]
    });
}

export default getConfig();
