<!-- resources/js/Pages/Admin/Facility/Show.vue -->
<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Fasilitas
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi lengkap fasilitas
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="route('admin.facilities.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                        <Link
                            :href="route('admin.facilities.edit', facility.id)"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <!-- Status Banner -->
            <div
                :class="[
                    'px-6 py-3 border-b',
                    facility.is_active
                        ? 'bg-green-50 border-green-200'
                        : 'bg-red-50 border-red-200',
                ]"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                facility.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{ facility.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                facility.is_available
                                    ? 'bg-blue-100 text-blue-800'
                                    : 'bg-yellow-100 text-yellow-800',
                            ]"
                        >
                            {{
                                facility.is_available
                                    ? "Tersedia"
                                    : "Tidak Tersedia"
                            }}
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <button
                            @click="toggleStatus"
                            :class="[
                                'inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition',
                                facility.is_active
                                    ? 'text-red-700 bg-red-100 hover:bg-red-200 focus:ring-red-500'
                                    : 'text-green-700 bg-green-100 hover:bg-green-200 focus:ring-green-500',
                            ]"
                        >
                            {{ facility.is_active ? "Nonaktifkan" : "Aktifkan" }}
                        </button>
                        <button
                            @click="toggleAvailability"
                            :class="[
                                'inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition',
                                facility.is_available
                                    ? 'text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:ring-yellow-500'
                                    : 'text-blue-700 bg-blue-100 hover:bg-blue-200 focus:ring-blue-500',
                            ]"
                        >
                            {{
                                facility.is_available
                                    ? "Tandai Tidak Tersedia"
                                    : "Tandai Tersedia"
                            }}
                        </button>
                    </div>
                </div>
            </div>

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
                                        Nama Fasilitas
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        {{ facility.name }}
                                    </p>
                                </div>
                                <div v-if="facility.short_description">
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Deskripsi Singkat
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ facility.short_description }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Deskripsi Lengkap
                                    </label>
                                    <p
                                        class="text-sm text-gray-900 whitespace-pre-line"
                                    >
                                        {{ facility.description }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Location & Specs -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Lokasi & Spesifikasi
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div
                                    class="grid grid-cols-1 md:grid-cols-3 gap-4"
                                >
                                    <div v-if="facility.location">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                        >
                                            Lokasi
                                        </label>
                                        <p class="text-sm text-gray-900">
                                            {{ facility.location }}
                                        </p>
                                    </div>
                                    <div v-if="facility.capacity">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                        >
                                            Kapasitas
                                        </label>
                                        <p class="text-sm text-gray-900">
                                            {{ facility.capacity }}
                                        </p>
                                    </div>
                                    <div v-if="facility.area">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                        >
                                            Luas Area
                                        </label>
                                        <p class="text-sm text-gray-900">
                                            {{ facility.area }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div
                            v-if="
                                facility.features && facility.features.length > 0
                            "
                        >
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Fitur & Kelengkapan
                            </h3>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <ul class="space-y-2">
                                    <li
                                        v-for="(feature, index) in facility.features"
                                        :key="index"
                                        class="flex items-start"
                                    >
                                        <CheckCircleIcon
                                            class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5"
                                        />
                                        <span class="text-sm text-gray-900">{{
                                            feature
                                        }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact -->
                        <div
                            v-if="
                                facility.contact_person ||
                                facility.contact_phone ||
                                facility.contact_email
                            "
                        >
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Kontak Person
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                <div v-if="facility.contact_person">
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Nama
                                    </label>
                                    <p class="text-sm text-gray-900">
                                        {{ facility.contact_person }}
                                    </p>
                                </div>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-4"
                                >
                                    <div v-if="facility.contact_phone">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                        >
                                            Telepon
                                        </label>

                                            :href="
                                                'tel:' + facility.contact_phone
                                            "
                                            class="text-sm text-blue-600 hover:text-blue-800"
                                        >
                                            {{ facility.contact_phone }}
                                        </a>
                                    </div>
                                    <div v-if="facility.contact_email">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1"
                                        >
                                            Email
                                        </label>

                                            :href="
                                                'mailto:' + facility.contact_email
                                            "
                                            class="text-sm text-blue-600 hover:text-blue-800"
                                        >
                                            {{ facility.contact_email }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery -->
                        <div
                            v-if="
                                facility.gallery_urls &&
                                facility.gallery_urls.length > 0
                            "
                        >
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Galeri Foto
                            </h3>
                            <div
                                class="grid grid-cols-2 md:grid-cols-3 gap-4"
                            >
                                <img
                                    v-for="(url, index) in facility.gallery_urls"
                                    :key="index"
                                    :src="url"
                                    :alt="facility.name"
                                    class="w-full h-32 object-cover rounded-lg shadow-sm cursor-pointer hover:opacity-90 transition"
                                    @click="openLightbox(index)"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Main Image -->
                        <div v-if="facility.image_url">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Gambar Utama
                            </h3>
                            <img
                                :src="facility.image_url"
                                :alt="facility.name"
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
                                        {{ facility.display_order }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Slug
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ facility.slug }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Dibuat
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ formatDate(facility.created_at) }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Terakhir Diperbarui
                                    </label>
                                    <p class="text-sm text-gray-600">
                                        {{ formatDate(facility.updated_at) }}
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
                                            'admin.facilities.edit',
                                            facility.id
                                        )
                                    "
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <PencilIcon class="w-4 h-4 mr-2" />
                                    Edit Fasilitas
                                </Link>
                                <button
                                    @click="confirmDeleteFacility"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <TrashIcon class="w-4 h-4 mr-2" />
                                    Hapus Fasilitas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { onMounted, watch } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    ArrowLeftIcon,
    PencilIcon,
    TrashIcon,
    CheckCircleIcon,
} from "@heroicons/vue/24/outline";

// Props
defineProps({
    facility: Object,
});

// Composables
const { props } = usePage();
const { success, error, warning, confirmDelete } = useSwal();

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
    const facility = props.facility;
    router.post(
        route("admin.facilities.toggle-status", facility.id),
        {},
        {
            preserveScroll: true,
        }
    );
};

const toggleAvailability = () => {
    const facility = props.facility;
    router.post(
        route("admin.facilities.toggle-availability", facility.id),
        {},
        {
            preserveScroll: true,
        }
    );
};

const confirmDeleteFacility = async () => {
    const facility = props.facility;
    const result = await confirmDelete(
        "Hapus Fasilitas?",
        `Fasilitas "${facility.name}" akan dihapus secara permanen!`
    );

    if (result.isConfirmed) {
        deleteFacility();
    }
};

const deleteFacility = () => {
    const facility = props.facility;
    router.delete(route("admin.facilities.destroy", facility.id));
};

const openLightbox = (index) => {
    // Implement lightbox functionality here (optional)
    console.log("Open lightbox at index:", index);
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
