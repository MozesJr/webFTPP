<template>
    <article
        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
    >
        <!-- Image - Smaller aspect ratio -->
        <div class="aspect-[23/10] bg-gray-200 overflow-hidden">
            <img
                :src="
                    news?.featured_image ||
                    '/storage/assets/img/news-default.jpg'
                "
                :alt="news?.title || 'News Image'"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                @error="handleImageError"
            />
        </div>

        <!-- Content - Reduced padding -->
        <div class="p-4">
            <!-- Category & Date -->
            <div class="flex items-center justify-between mb-3">
                <span
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                >
                    {{ news?.category?.name || "Umum" }}
                </span>
                <time class="text-xs text-gray-500">
                    {{ formatDate(news?.published_at) }}
                </time>
            </div>

            <!-- Title - Smaller -->
            <h2 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                <Link
                    :href="`/news/${news?.slug || '#'}`"
                    class="hover:text-blue-600 transition-colors"
                >
                    {{ news?.title || "Judul Berita" }}
                </Link>
            </h2>

            <!-- Excerpt -->
            <p class="text-gray-600 mb-4 line-clamp-3">
                {{ news?.excerpt || "Deskripsi berita tidak tersedia..." }}
            </p>

            <!-- Meta -->
            <div class="flex items-center justify-between">
                <div class="flex items-center text-sm text-gray-500">
                    <UserCircleIcon class="w-4 h-4 mr-2" />
                    {{ news?.author?.name || "Admin" }}
                </div>
                <Link
                    :href="`/news/${news?.slug || '#'}`"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-sm"
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
    if (!date) return "Tanggal tidak tersedia";

    try {
        return new Date(date).toLocaleDateString("id-ID", {
            day: "numeric",
            month: "short",
            year: "numeric",
        });
    } catch (error) {
        return "Tanggal tidak valid";
    }
}

function handleImageError(event) {
    event.target.src = "/storage/assets/img/news-default.jpg";
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
