<template>
    <footer id="footer" class="footer dark-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">{{ siteName }}</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jl, Gunung Salju Amban</p>
                        <p>Manokwari, Papua Barat</p>
                        <p class="mt-3">
                            <strong>Phone:</strong>
                            <span>{{ contactInfo.phone }}</span>
                        </p>
                        <p>
                            <strong>Email:</strong>
                            <span>{{ contactInfo.email }}</span>
                        </p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul class="space-y-2">
                        <li>
                            <Link
                                href="/about"
                                class="text-gray-300 hover:text-white transition-colors"
                                >About Us</Link
                            >
                        </li>
                        <li>
                            <Link
                                href="/program-studi"
                                class="text-gray-300 hover:text-white transition-colors"
                                >Program Studi</Link
                            >
                        </li>
                        <li>
                            <Link
                                href="/news"
                                class="text-gray-300 hover:text-white transition-colors"
                                >News</Link
                            >
                        </li>
                        <li>
                            <Link
                                href="/events"
                                class="text-gray-300 hover:text-white transition-colors"
                                >Events</Link
                            >
                        </li>
                        <li>
                            <Link
                                href="/gallery"
                                class="text-gray-300 hover:text-white transition-colors"
                                >Gallery</Link
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>
                <span>&copy; {{ currentYear }}</span>
                <strong class="px-1 sitename">{{ siteName }}</strong>
                <span>All Rights Reserved</span>
            </p>
        </div>
    </footer>
</template>

<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { EnvelopeIcon, PhoneIcon } from "@heroicons/vue/24/outline";

const page = usePage();
const currentYear = new Date().getFullYear();

const siteName = computed(
    () => page.props.siteSettings?.site_title || "Fakultas Website"
);
const siteDescription = computed(
    () =>
        page.props.siteSettings?.site_description || "Official Faculty Website"
);
const logo = computed(
    () =>
        page.props.siteSettings?.site_logo ||
        "/images/Logo_Universitas_Papua.png"
);

const socialLinks = computed(() => ({
    facebook: page.props.siteSettings?.facebook_url,
    instagram: page.props.siteSettings?.instagram_url,
    youtube: page.props.siteSettings?.youtube_url,
}));

const contactInfo = computed(() => ({
    email: page.props.siteSettings?.contact_email,
    phone: page.props.siteSettings?.contact_phone,
}));
</script>
