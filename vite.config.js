import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss'
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
















// import {defineConfig} from "vite";
// import laravel from "laravel-vite-plugin";
// import vue from "@vitejs/plugin-vue"
// import legacy from '@vitejs/plugin-legacy';
//
// export default defineConfig({
//     plugins: [
//         laravel([
//             'resources/sass/app.scss',
//             'resources/js/app.js',
//         ]),
//         vue(),
//
//         legacy({
//             targets: ['defaults', 'not IE 11']
//         })
//     ],
//     resolve: {
//         alias: {
//             '@': '/resources/js'
//         }
//     }
// });
