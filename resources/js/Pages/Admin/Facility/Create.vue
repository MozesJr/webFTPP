<!-- resources/js/Pages/Admin/Facility/Create.vue -->
<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Fasilitas
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Tambahkan fasilitas baru FTPP UNIPA
                        </p>
                    </div>
                    <Link
                        :href="route('admin.facilities.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Info Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Informasi Dasar
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Name -->
                            <div>
                                <label
                                    for="name"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Nama Fasilitas
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    :class="{
                                        'border-red-300': form.errors.name,
                                    }"
                                    placeholder="Laboratorium Teknologi Pangan"
                                />
                                <p
                                    v-if="form.errors.name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <!-- Short Description -->
                            <div>
                                <label
                                    for="short_description"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Deskripsi Singkat
                                </label>
                                <input
                                    id="short_description"
                                    v-model="form.short_description"
                                    type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Ringkasan singkat fasilitas (maks. 500 karakter)"
                                />
                                <p class="mt-1 text-xs text-gray-500">
                                    Akan ditampilkan di card preview
                                </p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label
                                    for="description"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Deskripsi Lengkap
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    rows="6"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    :class="{
                                        'border-red-300':
                                            form.errors.description,
                                    }"
                                    placeholder="Deskripsi lengkap tentang fasilitas..."
                                ></textarea>
                                <p
                                    v-if="form.errors.description"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Specs Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Lokasi & Spesifikasi
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Location -->
                                <div>
                                    <label
                                        for="location"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Lokasi
                                    </label>
                                    <input
                                        id="location"
                                        v-model="form.location"
                                        type="text"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        placeholder="Gedung A, Lantai 2"
                                    />
                                </div>

                                <!-- Capacity -->
                                <div>
                                    <label
                                        for="capacity"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Kapasitas
                                    </label>
                                    <input
                                        id="capacity"
                                        v-model="form.capacity"
                                        type="text"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        placeholder="40 mahasiswa"
                                    />
                                </div>

                                <!-- Area -->
                                <div class="md:col-span-2">
                                    <label
                                        for="area"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Luas Area
                                    </label>
                                    <input
                                        id="area"
                                        v-model="form.area"
                                        type="text"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        placeholder="150 m²"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Fitur & Kelengkapan
                            </h3>
                        </div>
                        <div class="p-6">
                            <div
                                v-for="(feature, index) in form.features"
                                :key="index"
                                class="flex items-center gap-2 mb-3"
                            >
                                <input
                                    v-model="form.features[index]"
                                    type="text"
                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Contoh: AC dan ventilasi baik"
                                />
                                <button
                                    type="button"
                                    @click="removeFeature(index)"
                                    class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-md"
                                >
                                    <XMarkIcon class="w-5 h-5" />
                                </button>
                            </div>
                            <button
                                type="button"
                                @click="addFeature"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Fitur
                            </button>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Kontak Person
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Contact Person -->
                                <div class="md:col-span-2">
                                    <label
                                        for="contact_person"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Nama
                                    </label>
                                    <input
                                        id="contact_person"
                                        v-model="form.contact_person"
                                        type="text"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        placeholder="Dr. Ahmad Fauzi"
                                    />
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label
                                        for="contact_phone"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Telepon
                                    </label>
                                    <input
                                        id="contact_phone"
                                        v-model="form.contact_phone"
                                        type="text"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        placeholder="0274-1234567"
                                    />
                                </div>

                                <!-- Email -->
                                <div>
                                    <label
                                        for="contact_email"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Email
                                    </label>
                                    <input
                                        id="contact_email"
                                        v-model="form.contact_email"
                                        type="email"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        :class="{
                                            'border-red-300':
                                                form.errors.contact_email,
                                        }"
                                        placeholder="lab@unipa.ac.id"
                                    />
                                    <p
                                        v-if="form.errors.contact_email"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ form.errors.contact_email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Main Image Upload Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Gambar Utama
                            </h3>
                        </div>
                        <div class="p-6">
                            <!-- Image Preview -->
                            <div
                                v-if="imagePreview"
                                class="mb-4 relative group"
                            >
                                <img
                                    :src="imagePreview"
                                    alt="Preview"
                                    class="w-full h-48 object-cover rounded-lg shadow-sm"
                                />
                                <button
                                    type="button"
                                    @click="removeImage"
                                    class="absolute top-2 right-2 p-2 bg-red-600 text-white rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                >
                                    <XMarkIcon class="w-4 h-4" />
                                </button>
                            </div>

                            <!-- Upload Button -->
                            <div>
                                <label
                                    for="image"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Upload Gambar
                                </label>
                                <div
                                    class="flex items-center justify-center w-full"
                                >
                                    <label
                                        for="image"
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6"
                                        >
                                            <PhotoIcon
                                                class="w-10 h-10 mb-3 text-gray-400"
                                            />
                                            <p
                                                class="mb-2 text-sm text-gray-500"
                                            >
                                                <span class="font-semibold"
                                                    >Klik untuk upload</span
                                                >
                                                atau drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, WEBP (MAX. 2MB)
                                            </p>
                                        </div>
                                        <input
                                            id="image"
                                            type="file"
                                            class="hidden"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            @change="handleImageUpload"
                                        />
                                    </label>
                                </div>
                                <p
                                    v-if="form.errors.image"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.image }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Upload Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Galeri Foto
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Upload beberapa foto fasilitas
                            </p>
                        </div>
                        <div class="p-6">
                            <!-- Gallery Previews -->
                            <div
                                v-if="galleryPreviews.length > 0"
                                class="grid grid-cols-2 gap-3 mb-4"
                            >
                                <div
                                    v-for="(preview, index) in galleryPreviews"
                                    :key="index"
                                    class="relative group"
                                >
                                    <img
                                        :src="preview"
                                        alt="Gallery preview"
                                        class="w-full h-24 object-cover rounded-lg shadow-sm"
                                    />
                                    <button
                                        type="button"
                                        @click="removeGalleryImage(index)"
                                        class="absolute top-1 right-1 p-1 bg-red-600 text-white rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 opacity-0 group-hover:opacity-100 transition-opacity"
                                    >
                                        <XMarkIcon class="w-3 h-3" />
                                    </button>
                                </div>
                            </div>

                            <!-- Upload Button -->
                            <div>
                                <label
                                    for="gallery"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Upload Foto
                                </label>
                                <div
                                    class="flex items-center justify-center w-full"
                                >
                                    <label
                                        for="gallery"
                                        class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center"
                                        >
                                            <PhotoIcon
                                                class="w-8 h-8 mb-2 text-gray-400"
                                            />
                                            <p class="text-xs text-gray-500">
                                                <span class="font-semibold"
                                                    >Pilih beberapa foto</span
                                                >
                                            </p>
                                        </div>
                                        <input
                                            id="gallery"
                                            type="file"
                                            class="hidden"
                                            multiple
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            @change="handleGalleryUpload"
                                        />
                                    </label>
                                </div>
                                <p
                                    v-if="form.errors.gallery"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.gallery }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Pengaturan
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Display Order -->
                            <div>
                                <label
                                    for="display_order"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Urutan Tampilan
                                </label>
                                <input
                                    id="display_order"
                                    v-model.number="form.display_order"
                                    type="number"
                                    min="0"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                />
                                <p class="mt-1 text-xs text-gray-500">
                                    Semakin kecil angka, semakin awal
                                    ditampilkan
                                </p>
                            </div>

                            <!-- Is Available -->
                            <div>
                                <div class="flex items-center">
                                    <input
                                        id="is_available"
                                        v-model="form.is_available"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    />
                                    <label
                                        for="is_available"
                                        class="ml-2 block text-sm text-gray-900"
                                    >
                                        Fasilitas tersedia
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 ml-6">
                                    Tandai jika fasilitas sedang tersedia untuk
                                    digunakan
                                </p>
                            </div>

                            <!-- Is Active -->
                            <div>
                                <div class="flex items-center">
                                    <input
                                        id="is_active"
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    />
                                    <label
                                        for="is_active"
                                        class="ml-2 block text-sm text-gray-900"
                                    >
                                        Aktifkan fasilitas
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 ml-6">
                                    Fasilitas akan ditampilkan di website jika
                                    diaktifkan
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="p-6 space-y-3">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span v-if="!form.processing">
                                    <CheckIcon class="w-4 h-4 mr-2 inline" />
                                    Simpan Fasilitas
                                </span>
                                <span v-else>
                                    <svg
                                        class="animate-spin h-4 w-4 mr-2 inline"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    Menyimpan...
                                </span>
                            </button>

                            <Link
                                :href="route('admin.facilities.index')"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <XMarkIcon class="w-4 h-4 mr-2" />
                                Batal
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    PhotoIcon,
    XMarkIcon,
    CheckIcon,
    PlusIcon,
} from "@heroicons/vue/24/outline";

// Form State
const form = useForm({
    name: "",
    slug: "",
    description: "",
    short_description: "",
    image: null,
    gallery: [],
    location: "",
    capacity: "",
    area: "",
    features: [""],
    contact_person: "",
    contact_phone: "",
    contact_email: "",
    is_available: true,
    is_active: true,
    display_order: 0,
});

// Preview States
const imagePreview = ref(null);
const galleryPreviews = ref([]);

// Methods
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    form.image = null;
    imagePreview.value = null;
    document.getElementById("image").value = "";
};

const handleGalleryUpload = (event) => {
    const files = Array.from(event.target.files);

    files.forEach((file) => {
        form.gallery.push(file);

        const reader = new FileReader();
        reader.onload = (e) => {
            galleryPreviews.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });
};

const removeGalleryImage = (index) => {
    form.gallery.splice(index, 1);
    galleryPreviews.value.splice(index, 1);
};

const addFeature = () => {
    form.features.push("");
};

const removeFeature = (index) => {
    if (form.features.length > 1) {
        form.features.splice(index, 1);
    }
};

const submit = () => {
    form.post(route("admin.facilities.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            imagePreview.value = null;
            galleryPreviews.value = [];
        },
    });
};
</script>
