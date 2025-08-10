import { defineConfig } from 'vite';
import * as glob from 'glob';
import path from 'path';
import autoprefixer from 'autoprefixer';

// Collect all SCSS files, filtering out empty ones
const scssFiles = glob.sync(`templates/**/**/assets/src/scss/*.scss`, { ignore: '**/_*.scss' });

// Collect all JS files
const jsFiles = glob.sync(`templates/**/**/assets/src/js/*.js`);

export default defineConfig(() => ({
    root: path.resolve(__dirname, `templates`),
    build: {
        outDir: path.resolve(__dirname , `templates`),
        emptyOutDir: false,
        rollupOptions: {
            input: [
                ...scssFiles.map((file) => path.resolve(file)),
                ...jsFiles.map((file) => path.resolve(file)), // Add JS files here
            ],
            output: {
                entryFileNames:  ({ facadeModuleId }) => {
                    if (facadeModuleId && facadeModuleId.endsWith('.js')) {
                        const regex = /themes\/[^\/]+\/assets\//;
                        const match = facadeModuleId.match(regex);
                        if (match) {
                            return match[0] + 'js/[name].min.js';
                        }
                    }
                    return `[name].min.js`;
                },
                assetFileNames: ({ names, originalFileNames }) => {
                    if (names[0].endsWith('.css') && originalFileNames[0] !== undefined) {
                        const regex = /themes\/[^\/]+\/assets\//;
                        const match = originalFileNames[0].match(regex);

                        if (match) {
                            return match[0] + 'css/[name].min.[ext]';
                        }
                    }
                  
                    return `[name].min.[ext]`;
                },
            },
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'templates/*'),
        },
    },
    css: {
        postcss: {
            plugins: [
                require('postcss-url')({
                    url: 'inline',
                    fallback: 'copy',
                    assetsPath: path.resolve(__dirname, 'templates'),
                }),
                require('postcss-nested')(),
                autoprefixer(), // Added autoprefixer here
                require('postcss-sort-media-queries')({
                    sort: 'mobile-first'
                }),
            ],
        },
    },
}));