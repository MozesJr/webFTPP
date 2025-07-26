<template>
    <AppLayout>
        <!-- Hero Section -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>{{ news?.title || "Detail Berita" }}</h1>
                <p>{{ news?.excerpt || "Baca berita selengkapnya" }}</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><Link href="/">Home</Link></li>
                        <li><Link href="/news">Berita</Link></li>
                        <li class="current">{{ news?.title || "Detail" }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Article Content -->
                    <div class="lg:col-span-2">
                        <article
                            class="bg-white rounded-lg shadow-lg overflow-hidden"
                        >
                            <!-- Featured Image -->
                            <div
                                class="aspect-video bg-gray-200 overflow-hidden"
                            >
                                <img
                                    :src="
                                        news?.featured_image ||
                                        '/storage/assets/img/news-default.jpg'
                                    "
                                    :alt="news?.title || 'News Image'"
                                    class="w-full h-full object-cover"
                                />
                            </div>

                            <!-- Article Header -->
                            <div class="p-8">
                                <!-- Meta Information -->
                                <div
                                    class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-600"
                                >
                                    <div class="flex items-center">
                                        <CalendarIcon class="w-5 h-5 mr-2" />
                                        <time>{{
                                            formatDate(news?.published_at)
                                        }}</time>
                                    </div>
                                    <div class="flex items-center">
                                        <UserCircleIcon class="w-5 h-5 mr-2" />
                                        <span>{{
                                            news?.author?.name || "Admin"
                                        }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <TagIcon class="w-5 h-5 mr-2" />
                                        <span
                                            class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium"
                                        >
                                            {{ news?.category?.name || "Umum" }}
                                        </span>
                                    </div>
                                    <div class="flex items-center">
                                        <EyeIcon class="w-5 h-5 mr-2" />
                                        <span
                                            >{{ news?.views_count || 0 }} kali
                                            dibaca</span
                                        >
                                    </div>
                                </div>

                                <!-- Title -->
                                <h1
                                    class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6"
                                >
                                    {{ news?.title || "Judul Berita" }}
                                </h1>

                                <!-- Lead/Excerpt -->
                                <div
                                    class="text-lg text-gray-700 mb-8 p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500"
                                >
                                    {{
                                        news?.excerpt ||
                                        "Excerpt tidak tersedia"
                                    }}
                                </div>

                                <!-- Content -->
                                <div
                                    class="prose prose-lg max-w-none"
                                    v-html="
                                        news?.content ||
                                        '<p>Konten berita tidak tersedia.</p>'
                                    "
                                ></div>

                                <!-- Tags -->
                                <div
                                    v-if="news?.tags && news.tags.length > 0"
                                    class="mt-8 pt-6 border-t border-gray-200"
                                >
                                    <h3
                                        class="text-sm font-medium text-gray-900 mb-3"
                                    >
                                        Tags:
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        <span
                                            v-for="tag in news.tags"
                                            :key="tag"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors"
                                        >
                                            #{{ tag }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Share Buttons -->
                                <div class="mt-8 pt-6 border-t border-gray-200">
                                    <h3
                                        class="text-sm font-medium text-gray-900 mb-3"
                                    >
                                        Bagikan:
                                    </h3>
                                    <div class="flex gap-3">
                                        <button
                                            @click="shareToFacebook"
                                            class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors"
                                            title="Share to Facebook"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                                                />
                                            </svg>
                                        </button>
                                        <button
                                            @click="shareToTwitter"
                                            class="flex items-center justify-center w-10 h-10 bg-sky-500 text-white rounded-full hover:bg-sky-600 transition-colors"
                                            title="Share to Twitter"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
                                                />
                                            </svg>
                                        </button>
                                        <button
                                            @click="shareToWhatsApp"
                                            class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full hover:bg-green-600 transition-colors"
                                            title="Share to WhatsApp"
                                        >
                                            <svg
                                                class="w-5 h-5"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"
                                                />
                                            </svg>
                                        </button>
                                        <button
                                            @click="copyLink"
                                            class="flex items-center justify-center w-10 h-10 bg-gray-600 text-white rounded-full hover:bg-gray-700 transition-colors"
                                            title="Copy Link"
                                        >
                                            <LinkIcon class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <!-- Related News -->
                        <div
                            v-if="relatedNews && relatedNews.length > 0"
                            class="mt-12"
                        >
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                Berita Terkait
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <RelatedNewsCard
                                    v-for="relatedArticle in relatedNews"
                                    :key="relatedArticle.id"
                                    :news="relatedArticle"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Latest News -->
                        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">
                                Berita Terbaru
                            </h3>
                            <div class="space-y-4">
                                <SidebarNewsCard
                                    v-for="article in latestNews"
                                    :key="article.id"
                                    :news="article"
                                />
                            </div>
                            <div class="mt-6">
                                <Link
                                    href="/news"
                                    class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    Lihat Semua Berita
                                </Link>
                            </div>
                        </div>

                        <!-- Author Info -->
                        <div
                            v-if="news?.author"
                            class="bg-white rounded-lg shadow-lg p-6"
                        >
                            <h3 class="text-xl font-bold text-gray-900 mb-4">
                                Tentang Penulis
                            </h3>
                            <div class="flex items-start space-x-4">
                                <img
                                    :src="
                                        news.author.photo_url ||
                                        '/storage/assets/img/team/default-avatar.jpg'
                                    "
                                    :alt="news.author.name"
                                    class="w-16 h-16 rounded-full object-cover"
                                />
                                <div>
                                    <h4 class="font-semibold text-gray-900">
                                        {{ news.author.name }}
                                    </h4>
                                    <p class="text-sm text-gray-600 mb-2">
                                        {{
                                            news.author.position?.name ||
                                            "Penulis"
                                        }}
                                    </p>
                                    <p
                                        v-if="news.author.bio"
                                        class="text-sm text-gray-700"
                                    >
                                        {{ news.author.bio }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import RelatedNewsCard from "@/Components/Public/RelatedNewsCard.vue";
import SidebarNewsCard from "@/Components/Public/SidebarNewsCard.vue";
import {
    CalendarIcon,
    UserCircleIcon,
    TagIcon,
    EyeIcon,
    LinkIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    news: {
        type: Object,
        required: true,
    },
    relatedNews: {
        type: Array,
        default: () => [],
    },
    latestNews: {
        type: Array,
        default: () => [],
    },
});

function formatDate(date) {
    if (!date) return "Tanggal tidak tersedia";

    try {
        return new Date(date).toLocaleDateString("id-ID", {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    } catch (error) {
        return "Tanggal tidak valid";
    }
}

function shareToFacebook() {
    const url = window.location.href;
    const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
        url
    )}`;
    window.open(shareUrl, "_blank", "width=600,height=400");
}

function shareToTwitter() {
    const url = window.location.href;
    const text = props.news?.title || "Berita dari FTPP";
    const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(
        url
    )}&text=${encodeURIComponent(text)}`;
    window.open(shareUrl, "_blank", "width=600,height=400");
}

function shareToWhatsApp() {
    const url = window.location.href;
    const text = `${props.news?.title || "Berita dari FTPP"} - ${url}`;
    const shareUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
    window.open(shareUrl, "_blank");
}

function copyLink() {
    navigator.clipboard
        .writeText(window.location.href)
        .then(() => {
            alert("Link berhasil disalin!");
        })
        .catch(() => {
            alert("Gagal menyalin link");
        });
}
</script>

<style scoped>
.prose {
    max-width: none;
}

.prose h1,
.prose h2,
.prose h3,
.prose h4,
.prose h5,
.prose h6 {
    color: #1f2937;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.prose h1 {
    font-size: 1.875rem;
}
.prose h2 {
    font-size: 1.5rem;
}
.prose h3 {
    font-size: 1.25rem;
}

.prose p {
    margin-bottom: 1rem;
    line-height: 1.7;
    color: #374151;
}

.prose img {
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 1.5rem 0;
}

.prose blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background: #f8fafc;
    padding: 1rem;
    border-radius: 0 8px 8px 0;
}

.prose ul,
.prose ol {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose a {
    color: #3b82f6;
    text-decoration: underline;
}

.prose a:hover {
    color: #1d4ed8;
}

.prose strong {
    font-weight: 600;
    color: #1f2937;
}

.prose code {
    background: #f1f5f9;
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-size: 0.9em;
}

.prose pre {
    background: #1f2937;
    color: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    overflow-x: auto;
}
</style>
