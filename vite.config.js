import { defineConfig } from 'vite';
import * as glob from 'glob';
import path from 'path';
import fs from 'fs';
import autoprefixer from 'autoprefixer';
import dotenv from 'dotenv';

// Load environment variables from .env file
dotenv.config();

// replace this line if you are using a custom theme ex: const themeName = 'theme-folder-name';
const themeName = process.env.THEME_NAME;

if (!themeName) {
  throw new Error("THEME_NAME is not defined in the .env file.");
}

const themePath = `web/app/themes/${themeName}`;

// Collect all JS files
const jsFiles = glob.sync(`${themePath}/src/js/**/*.js`);

// Collect all SCSS files, filtering out empty ones
const scssFiles = glob
  .sync(`${themePath}/src/scss/**/*.scss`, { ignore: '**/_*.scss' })
  .filter((file) => fs.statSync(file).size > 0); // Only include non-empty files

if (jsFiles.length === 0 && scssFiles.length === 0) {
  console.log('No source files to compile.');
  process.exit(0);
}

export default defineConfig(({ command }) => ({
  root: path.resolve(__dirname, themePath, 'src'),
  build: {
    outDir: path.resolve(__dirname, themePath, 'assets'),
    emptyOutDir: false,
    rollupOptions: {
      input: [
        ...jsFiles.map((file) => path.resolve(file)),
        ...scssFiles.map((file) => path.resolve(file)),
      ],
      output: {
        entryFileNames: 'js/[name].min.js',
        chunkFileNames: 'js/[name].min.js',
        assetFileNames: ({  names, originalFileNames }) => {
          if (names[0].endsWith('.css') && originalFileNames[0] !== undefined) {
              return 'css/[name].min.css';
          }
          return 'images/[name].min.[ext]';
        },
      },
    },
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src/*'),
    },
  },
  css: {
    postcss: {
      plugins: [
        require('postcss-url')({
          url: 'inline',
          fallback: 'copy',
          assetsPath: path.resolve(__dirname, themePath, 'assets/images'),
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