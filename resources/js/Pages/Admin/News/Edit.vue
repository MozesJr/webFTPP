<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Berita
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Perbarui berita: {{ news.title }}
                        </p>
                    </div>
                    <Link
                        href="/admin/news"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">
                    Informasi Berita
                </h2>
            </div>

            <form
                @submit.prevent="submit"
                class="p-6"
                enctype="multipart/form-data"
            >
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content Area -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Title -->
                        <div>
                            <label
                                for="title"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Judul Berita
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="title"
                                v-model="form.title"
                                type="text"
                                required
                                maxlength="255"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.title,
                                }"
                                placeholder="Masukkan judul berita"
                            />
                            <div
                                v-if="form.errors.title"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.title }}
                            </div>
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label
                                for="excerpt"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Ringkasan <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="excerpt"
                                v-model="form.excerpt"
                                rows="3"
                                required
                                maxlength="500"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.excerpt,
                                }"
                                placeholder="Ringkasan singkat berita (maks 500 karakter)"
                            ></textarea>
                            <div
                                v-if="form.errors.excerpt"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.excerpt }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.excerpt.length }}/500 karakter
                            </p>
                        </div>

                        <!-- Content -->
                        <div>
                            <label
                                for="content"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Konten Berita
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="content"
                                v-model="form.content"
                                rows="12"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.content,
                                }"
                                placeholder="Tulis konten berita lengkap di sini..."
                            ></textarea>
                            <div
                                v-if="form.errors.content"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.content }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Anda dapat menggunakan HTML untuk formatting
                            </p>
                        </div>

                        <!-- Current Image & Upload -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Gambar Utama
                            </label>

                            <!-- Current Image -->
                            <div v-if="currentImageUrl" class="mb-3">
                                <img
                                    :src="currentImageUrl"
                                    alt="Current Image"
                                    class="w-48 h-32 object-cover rounded-lg"
                                />
                                <p class="text-xs text-gray-500 mt-1">
                                    Gambar saat ini
                                </p>
                            </div>

                            <!-- File Input -->
                            <input
                                id="featured_image"
                                ref="imageInput"
                                type="file"
                                accept="image/jpeg,image/png,image/jpg,image/gif"
                                @change="handleImageChange"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <div
                                v-if="form.errors.featured_image"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.featured_image }}
                            </div>

                            <!-- New Image Preview -->
                            <div v-if="imagePreview" class="mt-3">
                                <img
                                    :src="imagePreview"
                                    alt="Preview"
                                    class="w-48 h-32 object-cover rounded-lg"
                                />
                                <p class="text-xs text-gray-500 mt-1">
                                    Preview gambar baru
                                </p>
                            </div>

                            <p class="mt-1 text-sm text-gray-500">
                                Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan
                                jika tidak ingin mengganti gambar.
                            </p>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Category -->
                        <div>
                            <label
                                for="category_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="category_id"
                                v-model="form.category_id"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.category_id,
                                }"
                            >
                                <option value="">Pilih Kategori</option>
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.category_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.category_id }}
                            </div>
                        </div>

                        <!-- Author -->
                        <div>
                            <label
                                for="author_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Penulis
                            </label>
                            <select
                                id="author_id"
                                v-model="form.author_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.author_id,
                                }"
                            >
                                <option value="">Pilih Penulis</option>
                                <option
                                    v-for="author in authors"
                                    :key="author.id"
                                    :value="author.id"
                                >
                                    {{ author.name }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.author_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.author_id }}
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label
                                for="status"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="status"
                                v-model="form.status"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.status,
                                }"
                            >
                                <option value="">Pilih Status</option>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                            <div
                                v-if="form.errors.status"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.status }}
                            </div>
                        </div>

                        <!-- Published At -->
                        <div>
                            <label
                                for="published_at"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Tanggal Publikasi
                            </label>
                            <input
                                id="published_at"
                                v-model="form.published_at"
                                type="datetime-local"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.published_at,
                                }"
                            />
                            <div
                                v-if="form.errors.published_at"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.published_at }}
                            </div>
                        </div>

                        <!-- Featured -->
                        <div>
                            <div class="flex items-center">
                                <input
                                    id="is_featured"
                                    v-model="form.is_featured"
                                    type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label
                                    for="is_featured"
                                    class="ml-2 block text-sm text-gray-900"
                                >
                                    Berita Unggulan
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Berita unggulan akan ditampilkan di halaman
                                utama
                            </p>
                        </div>

                        <!-- Tags -->
                        <div>
                            <label
                                for="tags"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Tags
                            </label>
                            <input
                                id="tags"
                                v-model="form.tags"
                                type="text"
                                maxlength="500"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.tags,
                                }"
                                placeholder="teknologi, pendidikan, mahasiswa"
                            />
                            <div
                                v-if="form.errors.tags"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.tags }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Pisahkan dengan koma
                            </p>
                        </div>

                        <!-- SEO Meta -->
                        <div class="border-t pt-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">
                                SEO Meta
                            </h3>

                            <!-- Meta Title -->
                            <div class="mb-4">
                                <label
                                    for="meta_title"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Meta Title
                                </label>
                                <input
                                    id="meta_title"
                                    v-model="form.meta_title"
                                    type="text"
                                    maxlength="60"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.meta_title,
                                    }"
                                    placeholder="Judul untuk SEO"
                                />
                                <div
                                    v-if="form.errors.meta_title"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.meta_title }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ form.meta_title.length }}/60 karakter
                                </p>
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label
                                    for="meta_description"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Meta Description
                                </label>
                                <textarea
                                    id="meta_description"
                                    v-model="form.meta_description"
                                    rows="3"
                                    maxlength="160"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.meta_description,
                                    }"
                                    placeholder="Deskripsi untuk SEO"
                                ></textarea>
                                <div
                                    v-if="form.errors.meta_description"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.meta_description }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ form.meta_description.length }}/160
                                    karakter
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-3 border-t pt-6">
                    <Link
                        href="/admin/news"
                        class="inline-flex justify-center items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                    >
                        <span v-if="form.processing">
                            <svg
                                class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
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
                        <span v-else> Update Berita </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    news: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
    authors: {
        type: Array,
        default: () => [],
    },
});

// Composables
const page = usePage();
const { success, error } = useSwal();

// State
const imageInput = ref(null);
const imagePreview = ref(null);

// Computed
const currentImageUrl = computed(() => {
    if (!props.news?.featured_image) return null;

    const imagePath = props.news.featured_image;
    if (imagePath.startsWith("http")) return imagePath;

    return imagePath.startsWith("storage/")
        ? `/${imagePath}`
        : `/storage/${imagePath}`;
});

// Form dengan _method untuk method spoofing
const form = useForm({
    _method: "PUT", // Method spoofing untuk Laravel
    title: props.news?.title || "",
    excerpt: props.news?.excerpt || "",
    content: props.news?.content || "",
    featured_image: null,
    category_id: props.news?.category_id || "",
    author_id: props.news?.author_id || "",
    status: props.news?.status || "draft",
    published_at: props.news?.published_at
        ? props.news.published_at.slice(0, 16)
        : "",
    is_featured: props.news?.is_featured ?? false,
    tags:
        props.news?.tags_string ||
        (Array.isArray(props.news?.tags) ? props.news.tags.join(", ") : ""),
    meta_title: props.news?.meta_title || "",
    meta_description: props.news?.meta_description || "",
});

// Methods
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.featured_image = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    // Gunakan POST dengan method spoofing
    form.post(`/admin/news/${props.news.id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Berita berhasil diperbarui.");
        },
        onError: (errors) => {
            console.log("Update errors:", errors);
            error("Error!", "Terjadi kesalahan saat memperbarui data.");
        },
    });
};

const handleFlashMessages = () => {
    try {
        const flash = page.props.value?.flash;
        if (flash?.message) {
            success("Berhasil!", flash.message);
        }
        if (flash?.error) {
            error("Error!", flash.error);
        }
    } catch (e) {
        console.log("Flash message error:", e);
    }
};

// Lifecycle
onMounted(() => {
    handleFlashMessages();
});
</script>
