<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Anggota Tim
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi detail anggota tim {{ team.name }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <Link
                            :href="`/admin/team/${team.id}/edit`"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit
                        </Link>
                        <Link
                            href="/admin/team"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Photo and Status -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 p-6 rounded-lg text-center">
                            <div
                                class="w-48 h-48 mx-auto rounded-full bg-gray-200 flex items-center justify-center mb-4 overflow-hidden"
                            >
                                <img
                                    v-if="team.photo_url"
                                    :src="team.photo_url"
                                    :alt="team.name"
                                    class="w-full h-full object-cover"
                                />
                                <UserIcon
                                    v-else
                                    class="w-24 h-24 text-gray-400"
                                />
                            </div>

                            <h2 class="text-xl font-bold text-gray-900 mb-2">
                                {{ team.name }}
                            </h2>

                            <div class="space-y-2">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"
                                >
                                    {{
                                        team.position?.name ||
                                        "Tidak ada posisi"
                                    }}
                                </span>

                                <div>
                                    <span
                                        :class="[
                                            'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                            team.is_active
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800',
                                        ]"
                                    >
                                        {{
                                            team.is_active
                                                ? "Aktif"
                                                : "Tidak Aktif"
                                        }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="text-sm text-gray-600">
                                    <div
                                        class="flex items-center justify-center mb-2"
                                    >
                                        <CalendarIcon class="w-4 h-4 mr-2" />
                                        Urutan: {{ team.order_index || "-" }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Ditambahkan:
                                        {{ formatDate(team.created_at) }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        Diperbarui:
                                        {{ formatDate(team.updated_at) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Details -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-4"
                            >
                                Informasi Dasar
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Nama Lengkap
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        {{ team.name }}
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Posisi
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        {{ team.position?.name || "-" }}
                                        <span
                                            v-if="team.position?.level"
                                            class="text-gray-500"
                                        >
                                            (Level {{ team.position.level }})
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Program Studi
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        {{ team.program_studi?.name || "-" }}
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Status
                                    </label>
                                    <span
                                        :class="[
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            team.is_active
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800',
                                        ]"
                                    >
                                        {{
                                            team.is_active
                                                ? "Aktif"
                                                : "Tidak Aktif"
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-4"
                            >
                                Informasi Kontak
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Email
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        <a
                                            v-if="team.email"
                                            :href="`mailto:${team.email}`"
                                            class="text-indigo-600 hover:text-indigo-800 underline"
                                        >
                                            {{ team.email }}
                                        </a>
                                        <span v-else>-</span>
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Nomor Telepon
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        <a
                                            v-if="team.phone"
                                            :href="`tel:${team.phone}`"
                                            class="text-indigo-600 hover:text-indigo-800 underline"
                                        >
                                            {{ team.phone }}
                                        </a>
                                        <span v-else>-</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Education and Expertise -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-4"
                            >
                                Pendidikan & Keahlian
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Pendidikan
                                    </label>
                                    <div class="bg-white p-3 rounded border">
                                        <p
                                            class="text-sm text-gray-900 whitespace-pre-line"
                                        >
                                            {{
                                                team.education ||
                                                "Tidak ada informasi pendidikan"
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Keahlian
                                    </label>
                                    <div class="bg-white p-3 rounded border">
                                        <p
                                            class="text-sm text-gray-900 whitespace-pre-line"
                                        >
                                            {{
                                                team.expertise ||
                                                "Tidak ada informasi keahlian"
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Biography -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-4"
                            >
                                Biografi
                            </h3>

                            <div class="bg-white p-4 rounded border">
                                <p
                                    class="text-sm text-gray-900 whitespace-pre-line leading-relaxed"
                                >
                                    {{ team.bio || "Tidak ada biografi" }}
                                </p>
                            </div>
                        </div>

                        <!-- Meta Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-4"
                            >
                                Informasi Sistem
                            </h3>

                            <div
                                class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm"
                            >
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        ID
                                    </label>
                                    <p class="text-gray-900">{{ team.id }}</p>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Urutan Tampil
                                    </label>
                                    <p class="text-gray-900">
                                        {{ team.order_index || "-" }}
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Terakhir Diperbarui
                                    </label>
                                    <p class="text-gray-900">
                                        {{ formatDate(team.updated_at) }}
                                    </p>
                                </div>
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
import {
    ArrowLeftIcon,
    PencilIcon,
    UserIcon,
    CalendarIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    team: {
        type: Object,
        required: true,
    },
});

// Methods
const formatDate = (dateString) => {
    if (!dateString) return "-";

    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>
