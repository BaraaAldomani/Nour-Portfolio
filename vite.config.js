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
                // Display. Fraunces carries the Latin side -- a warm,
                // high-character serif that reads like a fine-dining menu at
                // large sizes. El Messiri is its Arabic counterpart: tall,
                // elegant, far more presence than a bookish naskh face.
                bunny('Fraunces', { weights: [300, 400, 500, 600, 700] }),
                bunny('El Messiri', { weights: [400, 500, 600, 700] }),
                // Body.
                bunny('Figtree', { weights: [400, 500, 600] }),
                bunny('Tajawal', { weights: [400, 500, 700] }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5175,
        strictPort: true,
        // The page is served from :8082 but dev assets come from :5175, so the
        // dev server must both advertise a browser-reachable URL and allow the
        // cross-origin fetches (fonts especially).
        origin: 'http://localhost:5175',
        cors: true,
        // The browser talks to the host-published port, not the container's.
        hmr: { host: 'localhost', port: 5175 },
        watch: {
            usePolling: true,
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
