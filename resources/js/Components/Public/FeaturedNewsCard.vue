<template>
    <article
        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
    >
        <!-- Image -->
        <div class="aspect-video bg-gray-200 overflow-hidden">
            <img
                :src="news.featured_image"
                :alt="news.title"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
            />
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Category & Date -->
            <div class="flex items-center justify-between mb-4">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                >
                    {{ news.category.name }}
                </span>
                <time class="text-sm text-gray-500">
                    {{ formatDate(news.published_at) }}
                </time>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900 mb-3 line-clamp-2">
                <Link
                    :href="`/news/${news.slug}`"
                    class="hover:text-blue-600 transition-colors"
                >
                    {{ news.title }}
                </Link>
            </h2>

            <!-- Excerpt -->
            <p class="text-gray-600 mb-4 line-clamp-3">
                {{ news.excerpt }}
            </p>

            <!-- Meta -->
            <div class="flex items-center justify-between">
                <div class="flex items-center text-sm text-gray-500">
                    <UserCircleIcon class="w-5 h-5 mr-2" />
                    {{ news.author.name }}
                </div>
                <Link
                    :href="`/news/${news.slug}`"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium"
                >
                    Baca Selengkapnya
                    <ArrowRightIcon class="w-4 h-4 ml-1" />
                </Link>
            </div>
        </div>
    </article>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { UserCircleIcon, ArrowRightIcon } from "@heroicons/vue/24/outline";

defineProps({
    news: {
        type: Object,
        required: true,
    },
});

function formatDate(date) {
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}
</script>
