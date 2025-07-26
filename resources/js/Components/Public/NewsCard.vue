<template>
    <article
        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
    >
        <!-- Image - Much Smaller -->
        <div class="h-32 bg-gray-200 overflow-hidden">
            <Link :href="`/news/${news?.slug || '#'}`">
                <img
                    :src="
                        news?.featured_image ||
                        '/storage/assets/img/news-default.jpg'
                    "
                    :alt="news?.title || 'News Image'"
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                    @error="handleImageError"
                />
            </Link>
        </div>

        <!-- Content - Compact -->
        <div class="p-3">
            <!-- Category & Date -->
            <div class="flex items-center justify-between mb-2">
                <span
                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                >
                    {{ news?.category?.name || "Umum" }}
                </span>
                <time class="text-xs text-gray-500">
                    {{ formatDate(news?.published_at) }}
                </time>
            </div>

            <!-- Title Only - No Excerpt -->
            <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-2">
                <Link
                    :href="`/news/${news?.slug || '#'}`"
                    class="hover:text-blue-600 transition-colors"
                >
                    {{ news?.title || "Judul Berita" }}
                </Link>
            </h3>
            <p
                :class="compact ? 'text-sm mb-3 flex-grow' : 'mb-4'"
                class="text-gray-600 line-clamp-3"
            >
                {{ news?.excerpt || "Deskripsi berita tidak tersedia..." }}
            </p>

            <!-- Meta - Minimal -->
            <div class="flex items-center justify-between">
                <div class="flex items-center text-xs text-gray-500">
                    <UserCircleIcon class="w-3 h-3 mr-1" />
                    <span class="truncate">{{
                        news?.author?.name || "Admin"
                    }}</span>
                </div>
                <Link
                    :href="`/news/${news?.slug || '#'}`"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-xs"
                >
                    Baca
                    <ArrowRightIcon class="w-3 h-3 ml-1" />
                </Link>
            </div>
        </div>
    </article>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { UserCircleIcon, ArrowRightIcon } from "@heroicons/vue/24/outline";

defineProps({
    news: { type: Object, required: true },
    compact: { type: Boolean, default: false },
});

function formatDate(date) {
    if (!date) return "";
    try {
        return new Date(date).toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "short",
        });
    } catch (error) {
        return "";
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
