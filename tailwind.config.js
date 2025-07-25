// tailwind.config.js
import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: "#eff6ff",
                    100: "#dbeafe",
                    200: "#bfdbfe",
                    300: "#93c5fd",
                    400: "#60a5fa",
                    500: "#3b82f6",
                    600: "#2563eb",
                    700: "#1d4ed8",
                    800: "#1e40af",
                    900: "#1e3a8a",
                },
            },
            animation: {
                "fade-in": "fadeIn 0.3s ease-out",
                "slide-in": "slideIn 0.3s ease-out",
                "bounce-slow": "bounce 2s infinite",
            },
            keyframes: {
                fadeIn: {
                    "0%": { opacity: "0", transform: "translateY(10px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                slideIn: {
                    "0%": { opacity: "0", transform: "translateX(-10px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
            },
            spacing: {
                18: "4.5rem",
                88: "22rem",
                128: "32rem",
            },
            maxWidth: {
                "8xl": "88rem",
                "9xl": "96rem",
            },
            typography: {
                DEFAULT: {
                    css: {
                        maxWidth: "none",
                    },
                },
            },
        },
    },

    plugins: [
        forms,
        require("@tailwindcss/typography"),
        require("@tailwindcss/aspect-ratio"),
    ],
};
