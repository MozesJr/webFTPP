<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Sambutan Dekan
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Perbarui sambutan dari Dekan FTPP UNIPA
                        </p>
                    </div>
                    <Link
                        :href="route('admin.dean-greeting.index')"
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
                    <!-- Section Info Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Informasi Section
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Judul dan subtitle yang muncul di section
                            </p>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Section Title -->
                            <div>
                                <label
                                    for="section_title"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Judul Section
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="section_title"
                                    v-model="form.section_title"
                                    type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    :class="{
                                        'border-red-300':
                                            form.errors.section_title,
                                    }"
                                    placeholder="Sambutan"
                                />
                                <p
                                    v-if="form.errors.section_title"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.section_title }}
                                </p>
                            </div>

                            <!-- Section Subtitle -->
                            <div>
                                <label
                                    for="section_subtitle"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Subtitle Section
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="section_subtitle"
                                    v-model="form.section_subtitle"
                                    type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    :class="{
                                        'border-red-300':
                                            form.errors.section_subtitle,
                                    }"
                                    placeholder="Dekan FTPP UNIPA"
                                />
                                <p
                                    v-if="form.errors.section_subtitle"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.section_subtitle }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Greeting Text Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Teks Sambutan
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Isi sambutan dari dekan
                            </p>
                        </div>
                        <div class="p-6">
                            <div>
                                <label
                                    for="greeting_text"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Teks Sambutan
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="greeting_text"
                                    v-model="form.greeting_text"
                                    rows="12"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    :class="{
                                        'border-red-300':
                                            form.errors.greeting_text,
                                    }"
                                    placeholder="Masukkan teks sambutan dari dekan..."
                                ></textarea>
                                <p
                                    v-if="form.errors.greeting_text"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.greeting_text }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    Tulis sambutan lengkap dari dekan
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Dean Info Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Informasi Dekan
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Data lengkap dekan
                            </p>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Dean Title -->
                            <div>
                                <label
                                    for="dean_title"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Gelar Depan
                                </label>
                                <input
                                    id="dean_title"
                                    v-model="form.dean_title"
                                    type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    :class="{
                                        'border-red-300':
                                            form.errors.dean_title,
                                    }"
                                    placeholder="Prof. Dr. Ir."
                                />
                                <p
                                    v-if="form.errors.dean_title"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.dean_title }}
                                </p>
                            </div>

                            <!-- Dean Name -->
                            <div>
                                <label
                                    for="dean_name"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Nama Dekan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="dean_name"
                                    v-model="form.dean_name"
                                    type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    :class="{
                                        'border-red-300': form.errors.dean_name,
                                    }"
                                    placeholder="Eko A. Martanto"
                                />
                                <p
                                    v-if="form.errors.dean_name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.dean_name }}
                                </p>
                            </div>

                            <!-- Dean Degree -->
                            <div>
                                <label
                                    for="dean_degree"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Gelar Belakang
                                </label>
                                <input
                                    id="dean_degree"
                                    v-model="form.dean_degree"
                                    type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    :class="{
                                        'border-red-300':
                                            form.errors.dean_degree,
                                    }"
                                    placeholder="MP"
                                />
                                <p
                                    v-if="form.errors.dean_degree"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.dean_degree }}
                                </p>
                            </div>

                            <!-- Full Name Preview -->
                            <div
                                v-if="fullDeanName"
                                class="bg-blue-50 border border-blue-200 rounded-lg p-4"
                            >
                                <p
                                    class="text-xs font-medium text-blue-900 mb-1"
                                >
                                    Preview Nama Lengkap:
                                </p>
                                <p class="text-sm font-semibold text-blue-800">
                                    {{ fullDeanName }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Photo Upload Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Foto Dekan
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Upload foto dekan
                            </p>
                        </div>
                        <div class="p-6">
                            <!-- Current Photo -->
                            <div
                                v-if="currentPhotoUrl && !photoPreview"
                                class="mb-4 relative group"
                            >
                                <img
                                    :src="currentPhotoUrl"
                                    alt="Current photo"
                                    class="w-full h-64 object-cover rounded-lg shadow-sm"
                                />
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center"
                                >
                                    <button
                                        type="button"
                                        @click="confirmRemovePhoto"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                    >
                                        <TrashIcon
                                            class="w-4 h-4 inline mr-2"
                                        />
                                        Hapus Foto
                                    </button>
                                </div>
                            </div>

                            <!-- New Photo Preview -->
                            <div
                                v-if="photoPreview"
                                class="mb-4 relative group"
                            >
                                <img
                                    :src="photoPreview"
                                    alt="Preview"
                                    class="w-full h-64 object-cover rounded-lg shadow-sm"
                                />
                                <button
                                    type="button"
                                    @click="removeNewPhoto"
                                    class="absolute top-2 right-2 p-2 bg-red-600 text-white rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                >
                                    <XMarkIcon class="w-4 h-4" />
                                </button>
                                <div
                                    class="absolute bottom-2 left-2 right-2 bg-green-600 text-white text-xs px-3 py-1 rounded-md"
                                >
                                    Foto baru akan diupload
                                </div>
                            </div>

                            <!-- Upload Button -->
                            <div>
                                <label
                                    for="dean_photo"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    {{
                                        currentPhotoUrl && !form.remove_photo
                                            ? "Ganti Foto"
                                            : "Upload Foto"
                                    }}
                                </label>
                                <div
                                    class="flex items-center justify-center w-full"
                                >
                                    <label
                                        for="dean_photo"
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
                                            id="dean_photo"
                                            type="file"
                                            class="hidden"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            @change="handlePhotoUpload"
                                        />
                                    </label>
                                </div>
                                <p
                                    v-if="form.errors.dean_photo"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.dean_photo }}
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
                                    :class="{
                                        'border-red-300':
                                            form.errors.display_order,
                                    }"
                                />
                                <p
                                    v-if="form.errors.display_order"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.display_order }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    Semakin kecil angka, semakin awal
                                    ditampilkan
                                </p>
                            </div>

                            <!-- Active Status -->
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
                                        Aktifkan sambutan
                                    </label>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 ml-6">
                                    Sambutan akan ditampilkan di website jika
                                    diaktifkan
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Info Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Informasi
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
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
                                    Perbarui Sambutan
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
                                :href="route('admin.dean-greeting.index')"
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
import { ref, computed } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    ArrowLeftIcon,
    PhotoIcon,
    XMarkIcon,
    CheckIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    greeting: Object,
});

// Composables
const { confirmDelete } = useSwal();

// Form State
const form = useForm({
    section_title: props.greeting.section_title,
    section_subtitle: props.greeting.section_subtitle,
    greeting_text: props.greeting.greeting_text,
    dean_name: props.greeting.dean_name,
    dean_title: props.greeting.dean_title || "",
    dean_degree: props.greeting.dean_degree || "",
    dean_photo: null,
    is_active: props.greeting.is_active,
    display_order: props.greeting.display_order,
    remove_photo: false,
});

// Photo State
const photoPreview = ref(null);
const currentPhotoUrl = ref(props.greeting.dean_photo_url);

// Computed
const fullDeanName = computed(() => {
    const parts = [form.dean_title, form.dean_name, form.dean_degree].filter(
        Boolean
    );

    return parts.length > 0 ? parts.join(" ") : "";
});

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

const handlePhotoUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.dean_photo = file;
        form.remove_photo = false;

        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeNewPhoto = () => {
    form.dean_photo = null;
    photoPreview.value = null;
    document.getElementById("dean_photo").value = "";
};

const confirmRemovePhoto = async () => {
    const result = await confirmDelete(
        "Hapus Foto?",
        "Foto dekan akan dihapus. Anda bisa mengupload foto baru."
    );

    if (result.isConfirmed) {
        form.remove_photo = true;
        currentPhotoUrl.value = null;
    }
};

const submit = () => {
    form.post(route("admin.dean-greeting.update", props.greeting.id), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
        },
    });
};
</script>
