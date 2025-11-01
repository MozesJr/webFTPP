import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

const HMR_HOST = process.env.VITE_HMR_HOST || "localhost";
const HMR_PORT = Number(process.env.VITE_HMR_PORT || 5173);
const HMR_PROTOCOL = process.env.VITE_HMR_PROTOCOL || "ws";

export default defineConfig({
    plugins: [
        laravel({ input: "resources/js/app.js", refresh: true }),
        vue({
            template: {
                transformAssetUrls: { base: null, includeAbsolute: false },
            },
        }),
    ],
    resolve: { alias: { "@": "/resources/js" } },
    server: {
        host: true, // 0.0.0.0
        port: HMR_PORT,
        strictPort: true,
        hmr: {
            host: HMR_HOST, // 148.230.97.68
            port: HMR_PORT, // 5173
            protocol: HMR_PROTOCOL,
            clientPort: HMR_PORT,
        },
        watch: {
            usePolling: true,
            interval: 300,
        },
    },
    optimizeDeps: {
        include: ["@heroicons/vue/24/outline", "@heroicons/vue/24/solid"],
    },
});
