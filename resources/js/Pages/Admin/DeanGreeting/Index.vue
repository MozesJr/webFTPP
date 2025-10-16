<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Kelola Sambutan Dekan
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola sambutan dari Dekan FTPP UNIPA
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            v-if="!greeting"
                            :href="route('admin.dean-greeting.create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PlusIcon class="w-4 h-4 mr-2" />
                            Tambah Sambutan
                        </Link>
                        <Link
                            v-if="greeting"
                            :href="
                                route('admin.dean-greeting.edit', greeting.id)
                            "
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit Sambutan
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div
            v-if="greeting"
            class="bg-white rounded-lg shadow-sm border border-gray-200"
        >
            <!-- Status Banner -->
            <div
                :class="[
                    'px-6 py-3 border-b border-gray-200',
                    greeting.is_active
                        ? 'bg-green-50 border-green-200'
                        : 'bg-yellow-50 border-yellow-200',
                ]"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                greeting.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-yellow-100 text-yellow-800',
                            ]"
                        >
                            {{ greeting.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                        <span class="ml-3 text-sm text-gray-600">
                            {{
                                greeting.is_active
                                    ? "Sambutan saat ini ditampilkan di website"
                                    : "Sambutan saat ini tidak ditampilkan di website"
                            }}
                        </span>
                    </div>
                    <button
                        @click="toggleStatus"
                        :class="[
                            'inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150',
                            greeting.is_active
                                ? 'text-yellow-700 bg-yellow-100 hover:bg-yellow-200'
                                : 'text-green-700 bg-green-100 hover:bg-green-200',
                        ]"
                    >
                        {{ greeting.is_active ? "Nonaktifkan" : "Aktifkan" }}
                    </button>
                </div>
            </div>

            <!-- Greeting Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Section Info -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi Section
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Judul Section
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        {{ greeting.section_title }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Subtitle Section
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ greeting.section_subtitle }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Greeting Text -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Teks Sambutan
                            </h3>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div
                                    class="text-sm text-gray-900 whitespace-pre-line leading-relaxed"
                                >
                                    {{ greeting.greeting_text }}
                                </div>
                            </div>
                        </div>

                        <!-- Dean Info -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi Dekan
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Nama Lengkap
                                    </label>
                                    <p
                                        class="text-sm text-gray-900 font-medium"
                                    >
                                        {{ greeting.full_dean_name }}
                                    </p>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div v-if="greeting.dean_title">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                        >
                                            Gelar Depan
                                        </label>
                                        <p class="text-sm text-gray-600">
                                            {{ greeting.dean_title }}
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                        >
                                            Nama
                                        </label>
                                        <p class="text-sm text-gray-600">
                                            {{ greeting.dean_name }}
                                        </p>
                                    </div>
                                    <div v-if="greeting.dean_degree">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                        >
                                            Gelar Belakang
                                        </label>
                                        <p class="text-sm text-gray-600">
                                            {{ greeting.dean_degree }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Dean Photo -->
                        <div v-if="greeting.dean_photo_url">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Foto Dekan
                            </h3>
                            <img
                                :src="greeting.dean_photo_url"
                                :alt="greeting.full_dean_name"
                                class="w-full h-auto object-cover rounded-lg shadow-sm"
                            />
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
                                        Urutan Tampilan
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ greeting.display_order }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Dibuat
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ formatDate(greeting.created_at) }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Terakhir Diperbarui
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ formatDate(greeting.updated_at) }}
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
                                    :href="
                                        route(
                                            'admin.dean-greeting.edit',
                                            greeting.id
                                        )
                                    "
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <PencilIcon class="w-4 h-4 mr-2" />
                                    Edit Sambutan
                                </Link>
                                <button
                                    @click="confirmDeleteGreeting"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <TrashIcon class="w-4 h-4 mr-2" />
                                    Hapus Sambutan
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
                    Belum Ada Sambutan Dekan
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    Mulai dengan membuat sambutan dari Dekan FTPP UNIPA.
                </p>
                <div class="mt-6">
                    <Link
                        :href="route('admin.dean-greeting.create')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Buat Sambutan
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    PencilIcon,
    TrashIcon,
    DocumentTextIcon,
} from "@heroicons/vue/24/outline";

// Props
defineProps({
    greeting: Object,
});

// Composables
const { props } = usePage();
const { success, error, warning, info, confirmDelete } = useSwal();

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
    const greeting = props.greeting;
    router.post(
        route("admin.dean-greeting.toggle-status", greeting.id),
        {},
        {
            preserveScroll: true,
        }
    );
};

const confirmDeleteGreeting = async () => {
    const result = await confirmDelete(
        "Hapus Sambutan Dekan?",
        "Data sambutan yang dihapus tidak dapat dikembalikan!"
    );

    if (result.isConfirmed) {
        deleteGreeting();
    }
};

const deleteGreeting = () => {
    const greeting = props.greeting;
    router.delete(route("admin.dean-greeting.destroy", greeting.id));
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
