<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Page Header -->
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                <p class="text-gray-600">
                    Selamat datang di panel admin fakultas
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <StatsCard
                    title="Program Studi"
                    :value="stats.total_program_studis"
                    icon="academic-cap"
                    color="blue"
                />
                <StatsCard
                    title="Dosen & Staff"
                    :value="stats.total_teams"
                    icon="users"
                    color="green"
                />
                <StatsCard
                    title="Berita Published"
                    :value="stats.total_news"
                    icon="newspaper"
                    color="purple"
                />
                <StatsCard
                    title="Pesan Belum Dibaca"
                    :value="stats.unread_messages"
                    icon="envelope"
                    color="red"
                />
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">
                    Quick Actions
                </h2>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"
                >
                    <Link href="/admin/news/create" class="btn btn-primary">
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Berita
                    </Link>
                    <Link
                        href="/admin/program-studi/create"
                        class="btn btn-secondary"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Program Studi
                    </Link>
                    <Link
                        href="/admin/contact-messages"
                        class="btn btn-secondary"
                    >
                        <EnvelopeIcon class="w-4 h-4 mr-2" />
                        Lihat Pesan
                    </Link>
                    <Link href="/admin/settings" class="btn btn-secondary">
                        <CogIcon class="w-4 h-4 mr-2" />
                        Pengaturan
                    </Link>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent News -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        Berita Terbaru
                    </h2>
                    <div class="space-y-4">
                        <div
                            v-for="news in recentNews"
                            :key="news.id"
                            class="flex justify-between items-start"
                        >
                            <div class="flex-1">
                                <Link
                                    :href="`/admin/news/${news.id}`"
                                    class="text-sm font-medium text-gray-900 hover:text-blue-600"
                                >
                                    {{ news.title }}
                                </Link>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ formatDate(news.created_at) }} •
                                    {{ news.category.name }}
                                </p>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="statusClasses(news.status)"
                            >
                                {{ news.status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Recent Messages -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        Pesan Terbaru
                    </h2>
                    <div class="space-y-4">
                        <div
                            v-for="message in recentMessages"
                            :key="message.id"
                            class="border-b border-gray-200 pb-3 last:border-b-0"
                        >
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <Link
                                        :href="`/admin/contact-messages/${message.id}`"
                                        class="text-sm font-medium text-gray-900 hover:text-blue-600"
                                    >
                                        {{ message.subject }}
                                    </Link>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Dari: {{ message.name }} •
                                        {{ formatDate(message.created_at) }}
                                    </p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="
                                        messageStatusClasses(message.status)
                                    "
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
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import StatsCard from "@/Components/Admin/StatsCard.vue";
import { PlusIcon, EnvelopeIcon, CogIcon } from "@heroicons/vue/24/outline";

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
        read: "bg-yellow-100 text-yellow-800",
        replied: "bg-green-100 text-green-800",
    };
    return classes[status] || classes.unread;
}
</script>
