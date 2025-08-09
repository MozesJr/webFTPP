<template>
    <AdminLayout>
        <!-- Welcome Banner -->
        <div
            class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg mb-8 overflow-hidden"
        >
            <div class="flex items-center px-8 py-6">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Selamat Datang Kembali! 👋
                    </h1>
                    <p class="text-blue-100 text-lg">
                        Panel admin Fakultas Teknik Pertambangan dan Perminyakan
                    </p>
                    <p class="text-blue-200 text-sm mt-2">
                        Kelola konten website, berita, dan data fakultas dengan
                        mudah melalui dashboard ini.
                    </p>
                </div>
                <div class="hidden md:block">
                    <img
                        src="/storage/assets/img/Logo_Universitas_Papua.png"
                        alt="Welcome"
                        class="w-32 h-32 object-contain"
                    />
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <ModernStatsCard
                title="Program Studi"
                :value="stats.total_program_studis"
                icon="academic-cap"
                color="blue"
                :trend="{ value: 12, isUp: true }"
                description="Total program studi aktif"
            />
            <ModernStatsCard
                title="Dosen & Staff"
                :value="stats.total_teams"
                icon="users"
                color="green"
                :trend="{ value: 8, isUp: true }"
                description="Total anggota tim"
            />
            <ModernStatsCard
                title="Berita Published"
                :value="stats.total_news"
                icon="newspaper"
                color="purple"
                :trend="{ value: 5, isUp: false }"
                description="Berita yang telah dipublish"
            />
            <ModernStatsCard
                title="Events Mendatang"
                :value="stats.upcoming_events"
                icon="calendar"
                color="orange"
                :trend="{ value: 15, isUp: true }"
                description="Event yang akan datang"
            />
            <ModernStatsCard
                title="Pesan Belum Dibaca"
                :value="stats.unread_messages"
                icon="envelope"
                color="red"
                :trend="{ value: 23, isUp: true }"
                description="Pesan kontak masuk"
            />
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">
                    Quick Actions
                </h2>
                <p class="text-sm text-gray-600">
                    Aksi cepat untuk tugas sehari-hari
                </p>
            </div>
            <div class="p-6">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"
                >
                    <QuickActionCard
                        title="Tambah Berita"
                        description="Buat berita baru"
                        icon="PlusIcon"
                        color="blue"
                        href="/admin/news/create"
                    />
                    <QuickActionCard
                        title="Tambah Program Studi"
                        description="Tambah program studi baru"
                        icon="AcademicCapIcon"
                        color="green"
                        href="/admin/program-studi/create"
                    />
                    <QuickActionCard
                        title="Lihat Pesan"
                        description="Cek pesan kontak masuk"
                        icon="EnvelopeIcon"
                        color="yellow"
                        href="/admin/contact-messages"
                        :badge="stats.unread_messages"
                    />
                    <QuickActionCard
                        title="Tambah Event"
                        description="Buat event baru"
                        icon="CalendarIcon"
                        color="orange"
                        href="/admin/events/create"
                    />
                </div>
            </div>
        </div>

        <!-- Charts and Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Activity Chart -->
            <div
                class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200"
            >
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Activity Overview
                    </h2>
                    <p class="text-sm text-gray-600">
                        Aktivitas website minggu ini
                    </p>
                </div>
                <div class="p-6">
                    <!-- Simple Activity Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ stats.total_news }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Total Berita
                            </div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">
                                {{ stats.upcoming_events }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Events Mendatang
                            </div>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">
                                {{ stats.total_teams }}
                            </div>
                            <div class="text-sm text-gray-600">Tim & Dosen</div>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded-lg">
                            <div class="text-2xl font-bold text-orange-600">
                                {{ stats.total_program_studis }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Program Studi
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Events Mendatang
                    </h2>
                    <p class="text-sm text-gray-600">Event yang akan datang</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div
                            v-for="event in upcomingEvents"
                            :key="event.id"
                            class="flex items-start space-x-3"
                        >
                            <div class="flex-shrink-0">
                                <div
                                    class="w-2 h-2 rounded-full bg-orange-500"
                                ></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ event.title }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ event.program_studi?.name || "Umum" }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ formatDate(event.event_date) }}
                                </p>
                            </div>
                        </div>
                        <div
                            v-if="
                                !upcomingEvents || upcomingEvents.length === 0
                            "
                            class="text-center py-4"
                        >
                            <p class="text-sm text-gray-500">
                                Tidak ada event mendatang
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent News -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div
                    class="px-6 py-4 border-b border-gray-200 flex justify-between items-center"
                >
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            Berita Terbaru
                        </h2>
                        <p class="text-sm text-gray-600">
                            5 berita terakhir yang dibuat
                        </p>
                    </div>
                    <Link
                        href="/admin/news"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium"
                    >
                        Lihat Semua
                    </Link>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div
                            v-for="news in recentNews"
                            :key="news.id"
                            class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            <img
                                :src="
                                    news.featured_image ||
                                    '/storage/assets/img/news-default.jpg'
                                "
                                :alt="news.title"
                                class="w-12 h-12 rounded-lg object-cover"
                            />
                            <div class="flex-1 min-w-0">
                                <Link
                                    :href="`/admin/news/${news.id}`"
                                    class="text-sm font-medium text-gray-900 hover:text-blue-600 block truncate"
                                >
                                    {{ news.title }}
                                </Link>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs text-gray-500">
                                        {{ formatDate(news.created_at) }}
                                    </span>
                                    <span class="text-xs text-gray-300">•</span>
                                    <span class="text-xs text-gray-500">
                                        {{ news.category?.name || "Umum" }}
                                    </span>
                                </div>
                            </div>
                            <span
                                :class="statusClasses(news.status)"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            >
                                {{ news.status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div
                    class="px-6 py-4 border-b border-gray-200 flex justify-between items-center"
                >
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            Pesan Terbaru
                        </h2>
                        <p class="text-sm text-gray-600">
                            Pesan kontak dari website
                        </p>
                    </div>
                    <Link
                        href="/admin/contact-messages"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium"
                    >
                        Lihat Semua
                    </Link>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div
                            v-for="message in recentMessages"
                            :key="message.id"
                            class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0"
                        >
                            <div class="flex justify-between items-start">
                                <div class="flex-1 min-w-0">
                                    <Link
                                        :href="`/admin/contact-messages/${message.id}`"
                                        class="text-sm font-medium text-gray-900 hover:text-blue-600 block truncate"
                                    >
                                        {{ message.subject }}
                                    </Link>
                                    <p
                                        class="text-sm text-gray-600 mt-1 truncate"
                                    >
                                        {{ message.message }}
                                    </p>
                                    <div
                                        class="flex items-center space-x-2 mt-2"
                                    >
                                        <span class="text-xs text-gray-500">
                                            Dari: {{ message.name }}
                                        </span>
                                        <span class="text-xs text-gray-300"
                                            >•</span
                                        >
                                        <span class="text-xs text-gray-500">
                                            {{ formatDate(message.created_at) }}
                                        </span>
                                    </div>
                                </div>
                                <span
                                    :class="
                                        messageStatusClasses(message.status)
                                    "
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-3"
                                >
                                    {{ message.status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import ModernStatsCard from "@/Components/Admin/ModernStatsCard.vue";
import QuickActionCard from "@/Components/Admin/QuickActionCard.vue";
// import ActivityChart from "@/Components/Admin/ActivityChart.vue";

defineProps({
    stats: Object,
    recentNews: Array,
    recentMessages: Array,
    upcomingEvents: Array,
    currentStats: Object,
});

function formatDate(date) {
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
}

function statusClasses(status) {
    const classes = {
        published: "bg-green-100 text-green-800",
        draft: "bg-yellow-100 text-yellow-800",
        archived: "bg-gray-100 text-gray-800",
    };
    return classes[status] || classes.draft;
}

function messageStatusClasses(status) {
    const classes = {
        unread: "bg-red-100 text-red-800",
        read: "bg-blue-100 text-blue-800",
        replied: "bg-green-100 text-green-800",
    };
    return classes[status] || classes.unread;
}
</script>
