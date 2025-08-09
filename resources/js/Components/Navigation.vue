<template>
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img :src="logo" alt="Logo" class="h-10 w-10" />
                    <span class="text-xl font-bold text-gray-800">{{
                        siteName
                    }}</span>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <Link
                        href="/"
                        class="nav-link"
                        :class="{ active: $page.url === '/' }"
                    >
                        Home
                    </Link>
                    <Link
                        href="/about"
                        class="nav-link"
                        :class="{ active: $page.url === '/about' }"
                    >
                        About
                    </Link>
                    <div class="relative group">
                        <button class="nav-link flex items-center">
                            Program Studi
                            <ChevronDownIcon class="w-4 h-4 ml-1" />
                        </button>
                        <div
                            class="absolute top-full left-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-2 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200"
                        >
                            <Link
                                v-for="prodi in programStudis"
                                :key="prodi.id"
                                :href="`/program-studi/${prodi.code}`"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            >
                                {{ prodi.name }}
                            </Link>
                        </div>
                    </div>
                    <Link
                        href="/news"
                        class="nav-link"
                        :class="{ active: $page.url.startsWith('/news') }"
                    >
                        News
                    </Link>
                    <Link
                        href="/events"
                        class="nav-link"
                        :class="{ active: $page.url.startsWith('/events') }"
                    >
                        GPM
                    </Link>
                    <Link
                        href="/gallery"
                        class="nav-link"
                        :class="{ active: $page.url === '/gallery' }"
                    >
                        Penelitian
                    </Link>
                    <Link
                        href="/contact"
                        class="nav-link"
                        :class="{ active: $page.url === '/contact' }"
                    >
                        Kemahasiswaan
                    </Link>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-gray-600 hover:text-gray-900"
                    >
                        <Bars3Icon v-if="!mobileMenuOpen" class="h-6 w-6" />
                        <XMarkIcon v-else class="h-6 w-6" />
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div v-show="mobileMenuOpen" class="md:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <Link href="/" class="mobile-nav-link">Home</Link>
                    <Link href="/about" class="mobile-nav-link">About</Link>
                    <Link href="/news" class="mobile-nav-link">News</Link>
                    <Link href="/events" class="mobile-nav-link">Events</Link>
                    <Link href="/gallery" class="mobile-nav-link">Gallery</Link>
                    <Link href="/contact" class="mobile-nav-link">Contact</Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import {
    ChevronDownIcon,
    Bars3Icon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

const mobileMenuOpen = ref(false);
const page = usePage();

const siteName = computed(
    () => page.props.siteSettings?.site_title || "Fakultas Website"
);
const logo = computed(
    () =>
        page.props.siteSettings?.site_logo ||
        "/images/Logo_Universitas_Papua.png"
);
const programStudis = computed(() => page.props.programStudis || []);
</script>

<style scoped>
.nav-link {
    @apply text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200;
}

.nav-link.active {
    @apply text-blue-600 border-b-2 border-blue-600;
}

.mobile-nav-link {
    @apply block px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded;
}
</style>
