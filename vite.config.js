import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Fonts are downloaded and self-hosted at build time, so the running
            // site never reaches out to a third-party CDN.
            fonts: [
                // Display — editorial serif. Cormorant carries the Latin side,
                // Amiri the Arabic side; they share the same high-contrast voice.
                bunny('Cormorant Garamond', { weights: [300, 400, 500, 600, 700] }),
                bunny('Amiri', { weights: [400, 700] }),
                // Body.
                bunny('Inter', { weights: [400, 500, 600] }),
                bunny('Cairo', { weights: [400, 500, 600, 700] }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5175,
        strictPort: true,
        // The browser talks to the host-published port, not the container's.
        hmr: { host: 'localhost', port: 5175 },
        watch: {
            usePolling: true,
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
