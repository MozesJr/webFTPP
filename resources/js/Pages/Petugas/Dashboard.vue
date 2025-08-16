<!-- resources/js/Pages/Petugas/Dashboard.vue -->
<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Petugas Dashboard
                    </h1>
                    <p class="mt-2 text-gray-600">{{ message }}</p>
                </div>

                <!-- Role Info -->
                <div
                    class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center"
                            >
                                <span class="text-green-600 font-semibold">{{
                                    user.name.charAt(0).toUpperCase()
                                }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-green-900">
                                {{ user.name }}
                            </h3>
                            <p class="text-green-600">
                                {{ role }} - Petugas Umum
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Capabilities -->
                <div class="bg-white shadow rounded-lg mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Tugas & Wewenang
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                v-for="capability in capabilities"
                                :key="capability"
                                class="flex items-start"
                            >
                                <CheckCircleIcon
                                    class="h-5 w-5 text-green-500 mt-0.5 mr-3 flex-shrink-0"
                                />
                                <span class="text-sm text-gray-700">{{
                                    capability
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Link
                        :href="route('petugas.news.index')"
                        class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow"
                    >
                        <div class="flex items-center">
                            <NewspaperIcon class="h-8 w-8 text-blue-500" />
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">
                                    Kelola News
                                </h4>
                                <p class="text-sm text-gray-500">
                                    Buat dan edit berita
                                </p>
                            </div>
                        </div>
                    </Link>

                    <Link
                        :href="route('petugas.contact-messages.index')"
                        class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow"
                    >
                        <div class="flex items-center">
                            <EnvelopeIcon class="h-8 w-8 text-green-500" />
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">
                                    Pesan Kontak
                                </h4>
                                <p class="text-sm text-gray-500">
                                    Balas pesan masyarakat
                                </p>
                            </div>
                        </div>
                    </Link>

                    <Link
                        :href="route('petugas.jadwal-kuliah.index')"
                        class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow"
                    >
                        <div class="flex items-center">
                            <CalendarIcon class="h-8 w-8 text-purple-500" />
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">
                                    Update Jadwal
                                </h4>
                                <p class="text-sm text-gray-500">
                                    Edit jadwal kuliah
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    CheckCircleIcon,
    NewspaperIcon,
    EnvelopeIcon,
    CalendarIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    role: String,
    user: Object,
    message: String,
    capabilities: Array,
});
</script>

<!-- ============================================ -->

<!-- ============================================ -->
