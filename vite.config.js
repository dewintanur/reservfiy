import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  root: '.', // Pastikan ini mengarah ke direktori dimana `index.html` berada
  build: {
    outDir: 'public/build',
  }
});
