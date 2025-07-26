<template>
    <article
        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
    >
        <!-- Image -->
        <div class="aspect-video bg-gray-200 overflow-hidden">
            <Link :href="`/news/${news.slug}`">
                <img
                    :src="
                        news.featured_image ||
                        '/storage/assets/img/news-default.jpg'
                    "
                    :alt="news.title"
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                />
            </Link>
        </div>

        <!-- Content -->
        <div class="p-4">
            <!-- Category & Date -->
            <div class="flex items-center justify-between mb-3">
                <span
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                >
                    {{ news.category?.name || "Umum" }}
                </span>
                <time class="text-xs text-gray-500">
                    {{ formatDate(news.published_at) }}
                </time>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                <Link
                    :href="`/news/${news.slug}`"
                    class="hover:text-blue-600 transition-colors"
                >
                    {{ news.title }}
                </Link>
            </h3>

            <!-- Excerpt -->
            <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                {{ news.excerpt }}
            </p>

            <!-- Read More -->
            <Link
                :href="`/news/${news.slug}`"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm"
            >
                Baca Selengkapnya
                <ArrowRightIcon class="w-4 h-4 ml-1" />
            </Link>
        </div>
    </article>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ArrowRightIcon } from "@heroicons/vue/24/outline";

defineProps({
    news: {
        type: Object,
        required: true,
    },
});

function formatDate(date) {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
}
</script>
