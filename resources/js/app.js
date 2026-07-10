// =====================================================================
//  Safe MutationObserver Patch (mencegah crash observe(null))
// =====================================================================
(function () {
    const NativeMO = window.MutationObserver;
    if (!NativeMO) return;
    class SafeMO extends NativeMO {
        observe(target, options) {
            if (!(target instanceof Node)) {
                console.warn("[SafeMO] target is not a Node:", target);
                return; // no-op agar tidak throw error
            }
            try {
                return super.observe(target, options);
            } catch (e) {
                console.warn("[SafeMO] observe error:", e);
            }
        }
    }
    window.MutationObserver = SafeMO;
})();

// =====================================================================
//  Imports bawaan proyek
// =====================================================================
import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "ziggy-js";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// =====================================================================
//  Inertia + Vue Bootstrap
//  - Panggil vendor scripts SETELAH root sudah mounted
//  - Jalankan hanya di halaman non-admin, dan hanya sekali per full load
// =====================================================================
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        app.mixin({
            mounted() {
                if (
                    !window.__frontend_scripts_loaded__ &&
                    !window.location.pathname.startsWith("/admin")
                ) {
                    window.__frontend_scripts_loaded__ = true;
                    // Sedikit delay agar DOM dari Inertia benar-benar siap
                    setTimeout(() => loadFrontendScripts(), 0);
                }
            },
        });

        app.mount(el);
    },
    progress: { color: "#4B5563" },
});

// =====================================================================
//  Loader & Initializer untuk vendor frontend (non-admin only)
// =====================================================================
function loadFrontendScripts() {
    const scripts = [
        "/theme-assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js",
        "/theme-assets/assets/vendor/aos/aos.js",
        "/theme-assets/assets/vendor/glightbox/js/glightbox.min.js",
        "/theme-assets/assets/vendor/purecounter/purecounter_vanilla.js",
        "/theme-assets/assets/vendor/swiper/swiper-bundle.min.js",
        "/theme-assets/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js",
        "/theme-assets/assets/vendor/isotope-layout/isotope.pkgd.min.js",
        "/theme-assets/assets/js/main.js",
    ];

    let loadedScripts = 0;
    const total = scripts.length;

    const done = () => {
        loadedScripts++;
        if (loadedScripts === total) {
            // Semua vendor ter-load (atau error diabaikan), lanjut init
            initializeFrontendComponents();
        }
    };

    scripts.forEach((src) => {
        const script = document.createElement("script");
        script.src = src;
        script.async = true;
        script.onload = done;
        script.onerror = () => {
            console.warn(`[Vendor] Failed to load: ${src}`);
            done();
        };
        document.head.appendChild(script);
    });
}

// =====================================================================
//  Inisialisasi aman (semua target dicek dulu, try/catch bila perlu)
// =====================================================================
function initializeFrontendComponents() {
    // --- AOS (Animate On Scroll) ---
    if (typeof AOS !== "undefined") {
        try {
            AOS.init({
                duration: 1000,
                easing: "ease-in-out",
                once: true,
                mirror: false,
            });
        } catch (e) {
            console.warn("[AOS] init failed:", e);
        }
    }

    // --- PureCounter ---
    if (typeof PureCounter !== "undefined") {
        try {
            new PureCounter();
        } catch (e) {
            console.warn("[PureCounter] init failed:", e);
        }
    }

    // --- GLightbox ---
    if (typeof GLightbox !== "undefined") {
        try {
            GLightbox({ selector: ".glightbox" });
        } catch (e) {
            console.warn("[GLightbox] init failed:", e);
        }
    }

    // --- Swiper (cek elemen terkait lebih dulu) ---
    try {
        if (
            typeof Swiper !== "undefined" &&
            document.querySelector(".testimonials .swiper")
        ) {
            new Swiper(".testimonials .swiper", {
                loop: true,
                speed: 600,
                autoplay: { delay: 5000 },
                slidesPerView: "auto",
                pagination: {
                    el: ".swiper-pagination",
                    type: "bullets",
                    clickable: true,
                },
            });
        }
    } catch (e) {
        console.warn("[Swiper] init failed:", e);
    }

    // --- Isotope + imagesLoaded untuk portfolio ---
    try {
        if (
            typeof Isotope !== "undefined" &&
            typeof imagesLoaded !== "undefined"
        ) {
            const container = document.querySelector(".isotope-container");
            if (container) {
                imagesLoaded(container, function () {
                    try {
                        const portfolioIsotope = new Isotope(container, {
                            itemSelector: ".portfolio-item",
                            layoutMode: "masonry",
                        });

                        const filters = document.querySelectorAll(
                            ".portfolio-filters li"
                        );
                        filters.forEach((filter) => {
                            filter.addEventListener("click", function () {
                                filters.forEach((f) =>
                                    f.classList.remove("filter-active")
                                );
                                this.classList.add("filter-active");
                                const filterValue =
                                    this.getAttribute("data-filter");
                                portfolioIsotope.arrange({
                                    filter: filterValue,
                                });
                            });
                        });
                    } catch (e2) {
                        console.warn("[Isotope] inner init failed:", e2);
                    }
                });
            }
        }
    } catch (e) {
        console.warn("[Isotope] init failed:", e);
    }

    // --- Mobile navigation toggle ---
    try {
        const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
        if (mobileNavToggle) {
            mobileNavToggle.addEventListener("click", function () {
                const navmenu = document.querySelector("#navmenu");
                if (navmenu) navmenu.classList.toggle("mobile-nav-active");
                this.classList.toggle("bi-list");
                this.classList.toggle("bi-x");
            });
        }
    } catch (e) {
        console.warn("[MobileNav] init failed:", e);
    }

    // --- Scroll top button ---
    try {
        const scrollTop = document.querySelector(".scroll-top");
        if (scrollTop) {
            const toggleScrollTop = () => {
                if (window.scrollY > 100) scrollTop.classList.add("active");
                else scrollTop.classList.remove("active");
            };
            window.addEventListener("scroll", toggleScrollTop);
            scrollTop.addEventListener("click", (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        }
    } catch (e) {
        console.warn("[ScrollTop] init failed:", e);
    }

    // --- Header scroll effect ---
    try {
        const header = document.querySelector("#header");
        if (header) {
            const toggleHeaderClass = () => {
                if (window.scrollY > 100)
                    header.classList.add("header-scrolled");
                else header.classList.remove("header-scrolled");
            };
            window.addEventListener("scroll", toggleHeaderClass);
        }
    } catch (e) {
        console.warn("[HeaderScroll] init failed:", e);
    }

    // --- Smooth scrolling for anchor links ---
    try {
        document.querySelectorAll('a[href^="#"]').forEach((link) => {
            link.addEventListener("click", function (e) {
                const href = this.getAttribute("href");
                if (!href) return;
                const target = document.querySelector(href);
                if (!target) return;
                e.preventDefault();
                const header = document.querySelector("#header");
                const headerHeight = header ? header.offsetHeight : 0;
                window.scrollTo({
                    top: target.offsetTop - headerHeight,
                    behavior: "smooth",
                });
            });
        });
    } catch (e) {
        console.warn("[SmoothAnchor] init failed:", e);
    }

    // --- Bootstrap tabs ---
    try {
        if (typeof bootstrap !== "undefined") {
            document
                .querySelectorAll('[data-bs-toggle="tab"]')
                .forEach((tabTrigger) => {
                    try {
                        new bootstrap.Tab(tabTrigger);
                    } catch (e2) {
                        console.warn(
                            "[Bootstrap.Tab] init failed on element:",
                            tabTrigger,
                            e2
                        );
                    }
                });
        }
    } catch (e) {
        console.warn("[Bootstrap.Tab] init failed:", e);
    }

    // --- Preloader remove ---
    try {
        const preloader = document.querySelector("#preloader");
        if (preloader) preloader.remove();
    } catch (e) {
        console.warn("[Preloader] remove failed:", e);
    }
}
