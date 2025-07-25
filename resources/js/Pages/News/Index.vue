<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-800">
            <div class="container mx-auto px-4 text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Berita & Informasi
                </h1>
                <p class="text-xl md:text-2xl opacity-90 max-w-3xl mx-auto">
                    Ikuti perkembangan terbaru dari fakultas kami
                </p>
            </div>
        </section>

        <!-- Featured News -->
        <section v-if="featuredNews.length" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                    Berita Utama
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <FeaturedNewsCard :news="featuredNews[0]" />
                    </div>
                    <div class="space-y-6">
                        <NewsCard
                            v-for="news in featuredNews.slice(1)"
                            :key="news.id"
                            :news="news"
                            compact
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters & Search -->
        <section class="py-8 bg-white border-b">
            <div class="container mx-auto px-4">
                <div
                    class="flex flex-col md:flex-row gap-4 items-center justify-between"
                >
                    <!-- Search -->
                    <div class="relative flex-1 max-w-md">
                        <MagnifyingGlassIcon
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                        />
                        <input
                            v-model="searchQuery"
                            @keyup.enter="applyFilters"
                            type="text"
                            placeholder="Cari berita..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <!-- Category Filter -->
                    <div class="flex flex-wrap gap-2">
                        <button
                            @click="filterByCategory('')"
                            :class="
                                !filters.category
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-gray-200 text-gray-700'
                            "
                            class="px-4 py-2 rounded-lg font-medium transition-colors"
                        >
                            Semua
                        </button>
                        <button
                            v-for="category in categories"
                            :key="category.id"
                            @click="filterByCategory(category.slug)"
                            :class="
                                filters.category === category.slug
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-gray-200 text-gray-700'
                            "
                            class="px-4 py-2 rounded-lg font-medium transition-colors"
                        >
                            {{ category.name }}
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- News Grid -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <NewsCard
                        v-for="article in news.data"
                        :key="article.id"
                        :news="article"
                    />
                </div>

                <!-- Pagination -->
                <div v-if="news.links" class="mt-12">
                    <Pagination :links="news.links" />
                </div>

                <!-- Empty State -->
                <div v-if="news.data.length === 0" class="text-center py-12">
                    <NewspaperIcon
                        class="w-16 h-16 text-gray-300 mx-auto mb-4"
                    />
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Tidak ada berita ditemukan
                    </h3>
                    <p class="text-gray-600">
                        Coba ubah kata kunci pencarian atau filter kategori
                    </p>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import NewsCard from "@/Components/Public/NewsCard.vue";
import FeaturedNewsCard from "@/Components/Public/FeaturedNewsCard.vue";
import Pagination from "@/Components/UI/Pagination.vue";
import { MagnifyingGlassIcon, NewspaperIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    news: Object,
    categories: Array,
    featuredNews: Array,
    filters: Object,
});

const searchQuery = ref(props.filters.search || "");

function applyFilters() {
    router.get(
        "/news",
        {
            search: searchQuery.value,
            category: props.filters.category,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
}

function filterByCategory(categorySlug) {
    router.get(
        "/news",
        {
            search: searchQuery.value,
            category: categorySlug,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
}
</script>
