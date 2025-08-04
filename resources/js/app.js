import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});

// Hanya load script frontend jika bukan halaman admin
document.addEventListener("DOMContentLoaded", function () {
    // Cek apakah ini halaman admin
    const isAdminPage = window.location.pathname.startsWith("/admin");

    // Jika bukan admin, baru load script frontend
    if (!isAdminPage) {
        loadFrontendScripts();
    }
});

function loadFrontendScripts() {
    // Load vendor scripts untuk frontend saja
    const scripts = [
        "/storage/assets/vendor/bootstrap/js/bootstrap.bundle.min.js",
        "/storage/assets/vendor/aos/aos.js",
        "/storage/assets/vendor/glightbox/js/glightbox.min.js",
        "/storage/assets/vendor/purecounter/purecounter_vanilla.js",
        "/storage/assets/vendor/swiper/swiper-bundle.min.js",
        "/storage/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js",
        "/storage/assets/vendor/isotope-layout/isotope.pkgd.min.js",
        "/storage/assets/js/main.js",
    ];

    let loadedScripts = 0;
    scripts.forEach((src, index) => {
        const script = document.createElement("script");
        script.src = src;
        script.async = true;
        script.onerror = () => {
            console.warn(`Failed to load script: ${src}`);
            loadedScripts++;
            if (loadedScripts === scripts.length) {
                initializeFrontendComponents();
            }
        };
        script.onload = () => {
            loadedScripts++;
            if (loadedScripts === scripts.length) {
                initializeFrontendComponents();
            }
        };
        document.head.appendChild(script);
    });
}

function initializeFrontendComponents() {
    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== "undefined") {
        AOS.init({
            duration: 1000,
            easing: "ease-in-out",
            once: true,
            mirror: false,
        });
    }

    // Initialize PureCounter
    if (typeof PureCounter !== "undefined") {
        new PureCounter();
    }

    // Initialize GLightbox
    if (typeof GLightbox !== "undefined") {
        const glightbox = GLightbox({
            selector: ".glightbox",
        });
    }

    // Initialize Swiper
    if (typeof Swiper !== "undefined") {
        // Initialize testimonials swiper
        const testimonialsSwiper = new Swiper(".testimonials .swiper", {
            loop: true,
            speed: 600,
            autoplay: {
                delay: 5000,
            },
            slidesPerView: "auto",
            pagination: {
                el: ".swiper-pagination",
                type: "bullets",
                clickable: true,
            },
        });
    }

    // Initialize Isotope for portfolio
    if (typeof Isotope !== "undefined" && typeof imagesLoaded !== "undefined") {
        const portfolioContainer = document.querySelector(".isotope-container");
        if (portfolioContainer) {
            imagesLoaded(portfolioContainer, function () {
                const portfolioIsotope = new Isotope(portfolioContainer, {
                    itemSelector: ".portfolio-item",
                    layoutMode: "masonry",
                });

                // Portfolio filter functionality
                const portfolioFilters = document.querySelectorAll(
                    ".portfolio-filters li"
                );
                portfolioFilters.forEach((filter) => {
                    filter.addEventListener("click", function () {
                        portfolioFilters.forEach((f) =>
                            f.classList.remove("filter-active")
                        );
                        this.classList.add("filter-active");

                        const filterValue = this.getAttribute("data-filter");
                        portfolioIsotope.arrange({
                            filter: filterValue,
                        });
                    });
                });
            });
        }
    }

    // Mobile navigation toggle
    const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
    if (mobileNavToggle) {
        mobileNavToggle.addEventListener("click", function () {
            const navmenu = document.querySelector("#navmenu");
            if (navmenu) {
                navmenu.classList.toggle("mobile-nav-active");
            }
            this.classList.toggle("bi-list");
            this.classList.toggle("bi-x");
        });
    }

    // Scroll top button
    const scrollTop = document.querySelector(".scroll-top");
    if (scrollTop) {
        const toggleScrollTop = function () {
            if (window.scrollY > 100) {
                scrollTop.classList.add("active");
            } else {
                scrollTop.classList.remove("active");
            }
        };

        window.addEventListener("scroll", toggleScrollTop);

        scrollTop.addEventListener("click", function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    // Header scroll effect
    const header = document.querySelector("#header");
    if (header) {
        const toggleHeaderClass = function () {
            if (window.scrollY > 100) {
                header.classList.add("header-scrolled");
            } else {
                header.classList.remove("header-scrolled");
            }
        };

        window.addEventListener("scroll", toggleHeaderClass);
    }

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                const header = document.querySelector("#header");
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = target.offsetTop - headerHeight;
                window.scrollTo({
                    top: targetPosition,
                    behavior: "smooth",
                });
            }
        });
    });

    // Initialize Bootstrap tabs
    if (typeof bootstrap !== "undefined") {
        const tabTriggerList = document.querySelectorAll(
            '[data-bs-toggle="tab"]'
        );
        tabTriggerList.forEach((tabTrigger) => {
            new bootstrap.Tab(tabTrigger);
        });
    }

    // Remove preloader
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        preloader.remove();
    }
}
