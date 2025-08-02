<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah About
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat informasi about fakultas baru
                        </p>
                    </div>
                    <Link
                        href="/admin/about"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">
                                Video tentang fakultas (opsional)
                            </p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Video URL -->
                            <div>
                                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-1">
                                    URL Video
                                </label>
                                <input
                                    id="video_url"
                                    v-model="form.video_url"
                                    type="url"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{ 'border-red-300': form.errors.video_url }"
                                    placeholder="https://www.youtube.com/watch?v=..."
                                />
                                <div v-if="form.errors.video_url" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.video_url }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Masukkan URL video YouTube, Vimeo, atau platform lainnya
                                </p>
                            </div>

                            <!-- Video Title -->
                            <div>
                                <label for="video_title" class="block text-sm font-medium text-gray-700 mb-1">
                                    Judul Video
                                </label>
                                <input
                                    id="video_title"
                                    v-model="form.video_title"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{ 'border-red-300': form.errors.video_title }"
                                    placeholder="Masukkan judul video"
                                />
                                <div v-if="form.errors.video_title" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.video_title }}
                                </div>
                            </div>

                            <!-- Video Description -->
                            <div>
                                <label for="video_description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Deskripsi Video
                                </label>
                                <textarea
                                    id="video_description"
                                    v-model="form.video_description"
                                    rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{ 'border-red-300': form.errors.video_description }"
                                    placeholder="Masukkan deskripsi video"
                                ></textarea>
                                <div v-if="form.errors.video_description" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.video_description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status & Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">
                                Status & Aksi
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Active Status -->
                            <div class="flex items-center">
                                <input
                                    id="is_active"
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Aktifkan halaman about
                                </label>
                            </div>
                            <p class="text-sm text-gray-500">
                                Jika diaktifkan, halaman about akan ditampilkan di website
                            </p>

                            <!-- Action Buttons -->
                            <div class="pt-4 space-y-3">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                                >
                                    <span v-if="form.processing">
                                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                    <span v-else>
                                        <CheckIcon class="w-4 h-4 mr-2" />
                                        Simpan About
                                    </span>
                                </button>

                                <Link
                                    href="/admin/about"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <XMarkIcon class="w-4 h-4 mr-2" />
                                    Batal
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">
                                Gambar
                            </h2>
                            <p class="text-sm text-gray-600">
                                Upload gambar untuk halaman about
                            </p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Main Image -->
                            <div>
                                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Utama
                                </label>

                                <!-- File Input -->
                                <input
                                    id="image_url"
                                    ref="imageInput"
                                    type="file"
                                    accept="image/*"
                                    @change="handleImageChange"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                />
                                <div v-if="form.errors.image_url" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.image_url }}
                                </div>

                                <!-- Image Preview -->
                                <div v-if="imagePreview" class="mt-3">
                                    <img
                                        :src="imagePreview"
                                        alt="Preview"
                                        class="w-full h-32 object-cover rounded-lg"
                                    />
                                    <p class="text-xs text-gray-500 mt-1">Preview gambar</p>
                                </div>

                                <p class="mt-1 text-sm text-gray-500">
                                    Format: JPG, PNG, GIF. Maksimal 2MB
                                </p>
                            </div>

                            <!-- Secondary Image -->
                            <div>
                                <label for="secondary_image_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Kedua
                                </label>

                                <!-- File Input -->
                                <input
                                    id="secondary_image_url"
                                    ref="secondaryImageInput"
                                    type="file"
                                    accept="image/*"
                                    @change="handleSecondaryImageChange"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                />
                                <div v-if="form.errors.secondary_image_url" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.secondary_image_url }}
                                </div>

                                <!-- Secondary Image Preview -->
                                <div v-if="secondaryImagePreview" class="mt-3">
                                    <img
                                        :src="secondaryImagePreview"
                                        alt="Secondary Preview"
                                        class="w-full h-32 object-cover rounded-lg"
                                    />
                                    <p class="text-xs text-gray-500 mt-1">Preview gambar kedua</p>
                                </div>

                                <p class="mt-1 text-sm text-gray-500">
                                    Format: JPG, PNG, GIF. Maksimal 2MB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {
    ArrowLeftIcon,
    CheckIcon,
    XMarkIcon
} from '@heroicons/vue/24/outline';

const form = useForm({
    title: '',
    subtitle: '',
    description: '',
    vision: '',
    mission: '',
    image_url: null,
    video_url: '',
    video_title: '',
    video_description: '',
    secondary_image_url: null,
    is_active: true
});

const imageInput = ref(null);
const secondaryImageInput = ref(null);
const imagePreview = ref(null);
const secondaryImagePreview = ref(null);

function handleImageChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.image_url = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function handleSecondaryImageChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.secondary_image_url = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            secondaryImagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function submit() {
    form.post('/admin/about', {
        forceFormData: true,
        preserveScroll: true
    });
}
</script>
