<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Kelola About
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola informasi tentang fakultas
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            v-if="!about"
                            href="/admin/about/create"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PlusIcon class="w-4 h-4 mr-2" />
                            Tambah About
                        </Link>
                        <Link
                            v-if="about"
                            href="/admin/about/edit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit About
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div
            v-if="about"
            class="bg-white rounded-lg shadow-sm border border-gray-200"
        >
            <!-- Status Banner -->
            <div
                :class="[
                    'px-6 py-3 border-b border-gray-200',
                    about.is_active
                        ? 'bg-green-50 border-green-200'
                        : 'bg-yellow-50 border-yellow-200',
                ]"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                about.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-yellow-100 text-yellow-800',
                            ]"
                        >
                            {{ about.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                        <span class="ml-3 text-sm text-gray-600">
                            {{
                                about.is_active
                                    ? "About saat ini ditampilkan di website"
                                    : "About saat ini tidak ditampilkan di website"
                            }}
                        </span>
                    </div>
                    <button
                        @click="toggleStatus"
                        :class="[
                            'inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150',
                            about.is_active
                                ? 'text-yellow-700 bg-yellow-100 hover:bg-yellow-200'
                                : 'text-green-700 bg-green-100 hover:bg-green-200',
                        ]"
                    >
                        {{ about.is_active ? "Nonaktifkan" : "Aktifkan" }}
                    </button>
                </div>
            </div>

            <!-- About Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Info -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi Dasar
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Judul
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        {{ about.title }}
                                    </p>
                                </div>
                                <div v-if="about.subtitle">
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Subtitle
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ about.subtitle }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Deskripsi
                                    </label>
                                    <div
                                        class="text-sm text-gray-900 prose prose-sm max-w-none"
                                        v-html="about.description"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <!-- Vision & Mission -->
                        <div v-if="about.vision || about.mission">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Visi & Misi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    v-if="about.vision"
                                    class="bg-blue-50 rounded-lg p-4"
                                >
                                    <h4 class="font-medium text-blue-900 mb-2">
                                        Visi
                                    </h4>
                                    <div
                                        class="text-sm text-blue-800 prose prose-sm max-w-none"
                                        v-html="about.vision"
                                    ></div>
                                </div>
                                <div
                                    v-if="about.mission"
                                    class="bg-green-50 rounded-lg p-4"
                                >
                                    <h4 class="font-medium text-green-900 mb-2">
                                        Misi
                                    </h4>
                                    <div
                                        class="text-sm text-green-800 prose prose-sm max-w-none"
                                        v-html="about.mission"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <!-- Video Info -->
                        <div v-if="about.video_url">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Video
                            </h3>
                            <div class="bg-purple-50 rounded-lg p-4 space-y-3">
                                <div v-if="about.video_title">
                                    <label
                                        class="block text-sm font-medium text-purple-900 mb-1"
                                    >
                                        Judul Video
                                    </label>
                                    <p class="text-sm text-purple-800">
                                        {{ about.video_title }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-purple-900 mb-1"
                                    >
                                        URL Video
                                    </label>
                                    <a
                                        :href="about.video_url"
                                        target="_blank"
                                        class="text-sm text-purple-600 hover:text-purple-800 underline"
                                    >
                                        {{ about.video_url }}
                                    </a>
                                </div>
                                <div v-if="about.video_description">
                                    <label
                                        class="block text-sm font-medium text-purple-900 mb-1"
                                    >
                                        Deskripsi Video
                                    </label>
                                    <div
                                        class="text-sm text-purple-800 prose prose-sm max-w-none"
                                        v-html="about.video_description"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Images -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Gambar
                            </h3>
                            <div class="space-y-4">
                                <div v-if="about.image_url">
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Gambar Utama
                                    </label>
                                    <img
                                        :src="`/${about.image_url}`"
                                        :alt="about.title"
                                        class="w-full h-48 object-cover rounded-lg shadow-sm"
                                    />
                                </div>
                                <div v-if="about.secondary_image_url">
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Gambar Kedua
                                    </label>
                                    <img
                                        :src="`/${about.secondary_image_url}`"
                                        :alt="about.title"
                                        class="w-full h-48 object-cover rounded-lg shadow-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Meta Info -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Dibuat
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ formatDate(about.created_at) }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Terakhir Diperbarui
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ formatDate(about.updated_at) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Aksi
                            </h3>
                            <div class="space-y-3">
                                <Link
                                    href="/admin/about/edit"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <PencilIcon class="w-4 h-4 mr-2" />
                                    Edit About
                                </Link>
                                <button
                                    @click="confirmDeleteAbout"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <TrashIcon class="w-4 h-4 mr-2" />
                                    Hapus About
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div
            v-else
            class="bg-white rounded-lg shadow-sm border border-gray-200"
        >
            <div class="px-6 py-12 text-center">
                <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-4 text-lg font-medium text-gray-900">
                    Belum Ada Data About
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    Mulai dengan membuat halaman about untuk fakultas Anda.
                </p>
                <div class="mt-6">
                    <Link
                        href="/admin/about/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Buat About
                    </Link>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal - SweetAlert2 will handle this -->
        <!-- Remove ConfirmationModal and ToastNotification -->
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    PencilIcon,
    TrashIcon,
    DocumentTextIcon,
} from "@heroicons/vue/24/outline";

// Props
defineProps({
    about: Object,
});

// Composables
const { props } = usePage();
const { success, error, warning, info, confirmDelete } = useSwal();

// State
const showDeleteConfirmation = ref(false);

// Methods
const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const toggleStatus = () => {
    router.post(
        "/admin/about/toggle-status",
        {},
        {
            preserveScroll: true,
        }
    );
};

const confirmDeleteAbout = async () => {
    const result = await confirmDelete(
        "Hapus Data About?",
        "Data about yang dihapus tidak dapat dikembalikan!"
    );

    if (result.isConfirmed) {
        deleteAbout();
    }
};

const deleteAbout = () => {
    router.delete("/admin/about/delete");
};

const handleFlashMessages = () => {
    const flashProps = props.flash || {};

    if (flashProps.message) {
        success("Berhasil!", flashProps.message);
    }

    if (flashProps.error) {
        error("Error!", flashProps.error);
    }

    if (flashProps.warning) {
        warning("Peringatan!", flashProps.warning);
    }

    if (flashProps.info) {
        info("Informasi", flashProps.info);
    }
};

// Watchers
watch(
    () => props.flash,
    () => {
        handleFlashMessages();
    },
    { deep: true }
);

// Lifecycle
onMounted(() => {
    handleFlashMessages();
});
</script>
