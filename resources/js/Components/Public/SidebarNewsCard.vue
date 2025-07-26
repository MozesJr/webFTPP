<template>
    <article
        class="flex space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors"
    >
        <!-- Thumbnail -->
        <div class="flex-shrink-0">
            <Link :href="`/news/${news.slug}`">
                <img
                    :src="
                        news.featured_image ||
                        '/storage/assets/img/news-default.jpg'
                    "
                    :alt="news.title"
                    class="w-16 h-16 object-cover rounded-lg"
                />
            </Link>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
            <!-- Title -->
            <h4 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1">
                <Link
                    :href="`/news/${news.slug}`"
                    class="hover:text-blue-600 transition-colors"
                >
                    {{ news.title }}
                </Link>
            </h4>

            <!-- Meta -->
            <div class="flex items-center space-x-2 text-xs text-gray-500">
                <time>{{ formatDate(news.published_at) }}</time>
                <span>•</span>
                <span>{{ news.views_count || 0 }} views</span>
            </div>
        </div>
    </article>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

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
    });
}
</script>
