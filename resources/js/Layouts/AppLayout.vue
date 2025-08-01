<template>
    <div class="min-h-screen">
        <!-- Header -->
        <header id="header" class="header d-flex align-items-center fixed-top">
            <div
                class="container-fluid container-xl position-relative d-flex align-items-center"
            >
                <Link href="/" class="logo d-flex align-items-center me-auto">
                    <img
                        src="/storage/assets/img/Logo_Universitas_Papua.png"
                        alt=""
                    />
                    <h1 class="sitename">FTPP</h1>
                </Link>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li>
                            <Link
                                href="/#hero"
                                :class="{ active: isActive('/') }"
                                >Home</Link
                            >
                        </li>
                        <li><Link href="/about">About</Link></li>
                        <li class="dropdown">
                            <Link href="/program-studi"
                                ><span>Prodi</span>
                                <i
                                    class="bi bi-chevron-down toggle-dropdown"
                                ></i
                            ></Link>
                            <ul>
                                <li>
                                    <Link href="/program-studi/TPR"
                                        >S1 Teknik Perminyakan</Link
                                    >
                                </li>
                                <li>
                                    <Link href="/program-studi/TPT"
                                        >S1 Teknik Pertambangan</Link
                                    >
                                </li>
                                <li>
                                    <Link href="/program-studi/TG"
                                        >S1 Teknik Geologi</Link
                                    >
                                </li>
                                <li>
                                    <Link href="/program-studi/DTPT"
                                        >D3 Teknik Pertambangan</Link
                                    >
                                </li>
                            </ul>
                        </li>
                        <li><Link href="/news">News</Link></li>
                        <li><Link href="#team">GPM</Link></li>
                        <li><Link href="#contact">Penelitian</Link></li>
                        <li><Link href="#contact">Kemahasiswaan</Link></li>
                    </ul>
                    <i
                        class="mobile-nav-toggle d-xl-none bi bi-list"
                        @click="toggleMobileNav"
                    ></i>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main">
            <slot />
        </main>

        <!-- Footer -->
        <footer id="footer" class="footer dark-background">
            <div class="container footer-top">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6 footer-about">
                        <Link href="/" class="logo d-flex align-items-center">
                            <span class="sitename">FTPP</span>
                        </Link>
                        <div class="footer-contact pt-3">
                            <p>
                                {{
                                    siteSettings?.address ||
                                    "Jl, Gunung Salju Amban"
                                }}
                            </p>
                            <p>
                                {{
                                    siteSettings?.city ||
                                    "Manokwari, Papua Barat"
                                }}
                            </p>
                            <p class="mt-3">
                                <strong>Phone:</strong>
                                <span>{{
                                    siteSettings?.contact_phone ||
                                    "+62 81234567890"
                                }}</span>
                            </p>
                            <p>
                                <strong>Email:</strong>
                                <span>{{
                                    siteSettings?.contact_email ||
                                    "adminftpp@mail.com"
                                }}</span>
                            </p>
                        </div>
                        <div class="social-links d-flex mt-4">
                            <a
                                v-if="siteSettings?.twitter_url"
                                :href="siteSettings.twitter_url"
                            >
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a
                                v-if="siteSettings?.facebook_url"
                                :href="siteSettings.facebook_url"
                            >
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a
                                v-if="siteSettings?.instagram_url"
                                :href="siteSettings.instagram_url"
                            >
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a
                                v-if="siteSettings?.linkedin_url"
                                :href="siteSettings.linkedin_url"
                            >
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link href="/">Home</Link>
                            </li>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link href="/about">About us</Link>
                            </li>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link href="/program-studi">Program Studi</Link>
                            </li>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link href="/news">News</Link>
                            </li>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link href="/team">Team</Link>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>Program Studi</h4>
                        <ul>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link href="/program-studi/teknik-perminyakan"
                                    >S1 Teknik Perminyakan</Link
                                >
                            </li>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link href="/program-studi/teknik-pertambangan"
                                    >S1 Teknik Pertambangan</Link
                                >
                            </li>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link href="/program-studi/teknik-geologi"
                                    >S1 Teknik Geologi</Link
                                >
                            </li>
                            <li>
                                <i class="bi bi-chevron-right"></i>
                                <Link
                                    href="/program-studi/d3-teknik-pertambangan"
                                    >D3 Teknik Pertambangan</Link
                                >
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-12 footer-newsletter">
                        <h4>Our Newsletter</h4>
                        <p>
                            Subscribe to our newsletter and receive the latest
                            news about our products and services!
                        </p>
                        <form
                            @submit.prevent="subscribeNewsletter"
                            class="php-email-form"
                        >
                            <div class="newsletter-form">
                                <input
                                    type="email"
                                    v-model="newsletterEmail"
                                    name="email"
                                    placeholder="Enter your email"
                                    required
                                />
                                <input type="submit" value="Subscribe" />
                            </div>
                            <div v-if="newsletterLoading" class="loading">
                                Loading
                            </div>
                            <div v-if="newsletterError" class="error-message">
                                {{ newsletterError }}
                            </div>
                            <div v-if="newsletterSuccess" class="sent-message">
                                Your subscription request has been sent. Thank
                                you!
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container copyright text-center mt-4">
                <p>
                    © <span>Copyright</span>
                    <strong class="px-1 sitename">FTPP</strong>
                    <span>All Rights Reserved</span>
                </p>
                <div class="credits">
                    Designed by <a href="#">YOLO TECH</a> Distributed by
                    <a href="#">NanoTech</a>
                </div>
            </div>
        </footer>

        <!-- Scroll Top -->
        <a
            href="#"
            id="scroll-top"
            class="scroll-top d-flex align-items-center justify-content-center"
            @click.prevent="scrollToTop"
            :class="{ active: showScrollTop }"
        >
            <i class="bi bi-arrow-up-short"></i>
        </a>

        <!-- Preloader -->
        <div v-if="isLoading" id="preloader"></div>
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, computed } from "vue";

const props = defineProps({
    siteSettings: {
        type: Object,
        default: () => ({}),
    },
});

const page = usePage();
const isLoading = ref(true);
const showScrollTop = ref(false);
const newsletterEmail = ref("");
const newsletterLoading = ref(false);
const newsletterError = ref("");
const newsletterSuccess = ref(false);

const isActive = (path) => {
    return page.url === path;
};

const toggleMobileNav = () => {
    const navmenu = document.querySelector("#navmenu");
    if (navmenu) {
        navmenu.classList.toggle("mobile-nav-active");
    }
};

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};

const handleScroll = () => {
    showScrollTop.value = window.scrollY > 100;

    // Header scroll effect
    const header = document.querySelector("#header");
    if (header) {
        if (window.scrollY > 100) {
            header.classList.add("header-scrolled");
        } else {
            header.classList.remove("header-scrolled");
        }
    }
};

const subscribeNewsletter = async () => {
    newsletterLoading.value = true;
    newsletterError.value = "";
    newsletterSuccess.value = false;

    try {
        // Here you would make an API call to subscribe the email
        await fetch("/newsletter/subscribe", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
            body: JSON.stringify({ email: newsletterEmail.value }),
        });

        newsletterSuccess.value = true;
        newsletterEmail.value = "";
    } catch (error) {
        newsletterError.value = "Failed to subscribe. Please try again.";
    } finally {
        newsletterLoading.value = false;
    }
};

onMounted(() => {
    // Hide preloader
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);

    // Add scroll event listener
    window.addEventListener("scroll", handleScroll);

    // Initialize mobile nav toggle
    const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
    if (mobileNavToggle) {
        mobileNavToggle.addEventListener("click", toggleMobileNav);
    }

    // Initialize smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const target = document.querySelector(link.getAttribute("href"));
            if (target) {
                const headerHeight =
                    document.querySelector("#header")?.offsetHeight || 0;
                const targetPosition = target.offsetTop - headerHeight;
                window.scrollTo({
                    top: targetPosition,
                    behavior: "smooth",
                });
            }
        });
    });
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>
