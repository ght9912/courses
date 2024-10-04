import './bootstrap';
import '../css/app.css';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});

// composer create-project laravel/laravel:^9.0 example-app
// composer require laravel/breeze --dev
// php artisan breeze:install react --ssr
// php artisan migrate
// npm install
// npm run dev

// Abrir otra consola
// // php artisan serve

// "scripts": {
//     "dev": "vite",
//     "build": "vite build && vite build --ssr && vite build && vite build --ssr --ssr"
// }
