<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Berita
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat berita atau artikel baru untuk website
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

            <form @submit.prevent="submit" class="p-6">
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
                                    'border-red-300':
                                        form.errors.title || errors.title,
                                }"
                                placeholder="Masukkan judul berita"
                                @blur="validateField('title')"
                            />
                            <div
                                v-if="form.errors.title || errors.title"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.title || errors.title }}
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
                                    'border-red-300':
                                        form.errors.excerpt || errors.excerpt,
                                }"
                                placeholder="Ringkasan singkat berita (maks 500 karakter)"
                                @blur="validateField('excerpt')"
                            ></textarea>
                            <div
                                v-if="form.errors.excerpt || errors.excerpt"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.excerpt || errors.excerpt }}
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
                                    'border-red-300':
                                        form.errors.content || errors.content,
                                }"
                                placeholder="Tulis konten berita lengkap di sini..."
                                @blur="validateField('content')"
                            ></textarea>
                            <div
                                v-if="form.errors.content || errors.content"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.content || errors.content }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Anda dapat menggunakan HTML untuk formatting
                            </p>
                        </div>

                        <!-- Featured Image -->
                        <div>
                            <label
                                for="featured_image"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Gambar Utama
                            </label>
                            <input
                                id="featured_image"
                                ref="imageInput"
                                type="file"
                                accept="image/jpeg,image/png,image/jpg,image/gif"
                                @change="handleImageChange"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <div
                                v-if="
                                    form.errors.featured_image ||
                                    errors.featured_image
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.featured_image ||
                                    errors.featured_image
                                }}
                            </div>

                            <!-- Image Preview -->
                            <div v-if="imagePreview" class="mt-3">
                                <img
                                    :src="imagePreview"
                                    alt="Preview"
                                    class="w-48 h-32 object-cover rounded-lg"
                                />
                                <p class="text-xs text-gray-500 mt-1">
                                    Preview gambar
                                </p>
                                <button
                                    type="button"
                                    @click="removeImage"
                                    class="mt-1 text-xs text-red-600 hover:text-red-800"
                                >
                                    Hapus gambar
                                </button>
                            </div>

                            <p class="mt-1 text-sm text-gray-500">
                                Format: JPG, PNG, GIF. Maksimal 2MB
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
                                    'border-red-300':
                                        form.errors.category_id ||
                                        errors.category_id,
                                }"
                                @change="validateField('category_id')"
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
                                v-if="
                                    form.errors.category_id ||
                                    errors.category_id
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.category_id ||
                                    errors.category_id
                                }}
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
                                    'border-red-300':
                                        form.errors.author_id ||
                                        errors.author_id,
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
                                v-if="form.errors.author_id || errors.author_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.author_id || errors.author_id }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Kosongkan untuk menggunakan akun saat ini
                            </p>
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
                                    'border-red-300':
                                        form.errors.status || errors.status,
                                }"
                                @change="validateField('status')"
                            >
                                <option value="">Pilih Status</option>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                            <div
                                v-if="form.errors.status || errors.status"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.status || errors.status }}
                            </div>
                        </div>

                        <!-- Published At -->
                        <div v-if="form.status === 'published'">
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
                                    'border-red-300':
                                        form.errors.published_at ||
                                        errors.published_at,
                                }"
                            />
                            <div
                                v-if="
                                    form.errors.published_at ||
                                    errors.published_at
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.published_at ||
                                    errors.published_at
                                }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Kosongkan untuk publikasi sekarang
                            </p>
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
                                    'border-red-300':
                                        form.errors.tags || errors.tags,
                                }"
                                placeholder="teknologi, pendidikan, mahasiswa"
                            />
                            <div
                                v-if="form.errors.tags || errors.tags"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.tags || errors.tags }}
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
                                            form.errors.meta_title ||
                                            errors.meta_title,
                                    }"
                                    placeholder="Judul untuk SEO"
                                />
                                <div
                                    v-if="
                                        form.errors.meta_title ||
                                        errors.meta_title
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.meta_title ||
                                        errors.meta_title
                                    }}
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
                                            form.errors.meta_description ||
                                            errors.meta_description,
                                    }"
                                    placeholder="Deskripsi untuk SEO"
                                ></textarea>
                                <div
                                    v-if="
                                        form.errors.meta_description ||
                                        errors.meta_description
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.meta_description ||
                                        errors.meta_description
                                    }}
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
                        :disabled="form.processing || !isFormValid"
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
                        <span v-else> Simpan Berita </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted, reactive } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
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

// Custom validation errors
const errors = reactive({
    title: "",
    excerpt: "",
    content: "",
    category_id: "",
    status: "",
    featured_image: "",
    tags: "",
    meta_title: "",
    meta_description: "",
});

// Form
const form = useForm({
    title: "",
    excerpt: "",
    content: "",
    featured_image: null,
    category_id: "",
    author_id: "",
    status: "draft",
    published_at: "",
    is_featured: false,
    tags: "",
    meta_title: "",
    meta_description: "",
});

// Computed
const isFormValid = computed(() => {
    return (
        form.title.trim() !== "" &&
        form.excerpt.trim() !== "" &&
        form.content.trim() !== "" &&
        form.category_id !== "" &&
        form.status !== "" &&
        !Object.values(errors).some((error) => error !== "")
    );
});

// Methods
const validateField = (field) => {
    // Clear previous error
    errors[field] = "";

    switch (field) {
        case "title":
            if (!form.title.trim()) {
                errors.title = "Judul berita wajib diisi";
            } else if (form.title.length < 5) {
                errors.title = "Judul berita minimal 5 karakter";
            } else if (form.title.length > 255) {
                errors.title = "Judul berita maksimal 255 karakter";
            }
            break;

        case "excerpt":
            if (!form.excerpt.trim()) {
                errors.excerpt = "Ringkasan berita wajib diisi";
            } else if (form.excerpt.length < 20) {
                errors.excerpt = "Ringkasan berita minimal 20 karakter";
            } else if (form.excerpt.length > 500) {
                errors.excerpt = "Ringkasan berita maksimal 500 karakter";
            }
            break;

        case "content":
            if (!form.content.trim()) {
                errors.content = "Konten berita wajib diisi";
            } else if (form.content.length < 50) {
                errors.content = "Konten berita minimal 50 karakter";
            }
            break;

        case "category_id":
            if (!form.category_id) {
                errors.category_id = "Kategori berita wajib dipilih";
            }
            break;

        case "status":
            if (!form.status) {
                errors.status = "Status berita wajib dipilih";
            }
            break;
    }
};

const validateImage = (file) => {
    errors.featured_image = "";

    if (!file) return true;

    // Check file type
    const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
    if (!allowedTypes.includes(file.type)) {
        errors.featured_image = "Format gambar harus JPG, PNG, atau GIF";
        return false;
    }

    // Check file size (2MB)
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    if (file.size > maxSize) {
        errors.featured_image = "Ukuran gambar maksimal 2MB";
        return false;
    }

    return true;
};

const handleImageChange = (event) => {
    const file = event.target.files[0];

    if (file) {
        if (!validateImage(file)) {
            // Reset input if validation fails
            event.target.value = "";
            imagePreview.value = null;
            form.featured_image = null;
            return;
        }

        form.featured_image = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    imagePreview.value = null;
    form.featured_image = null;
    if (imageInput.value) {
        imageInput.value.value = "";
    }
};

const submit = () => {
    // Validate all required fields before submit
    validateField("title");
    validateField("excerpt");
    validateField("content");
    validateField("category_id");
    validateField("status");

    // Check if there are any validation errors
    if (Object.values(errors).some((error) => error !== "")) {
        error("Validasi Error!", "Mohon perbaiki data yang belum valid.");
        return;
    }

    form.post("/admin/news", {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Berita berhasil ditambahkan.");
        },
        onError: (formErrors) => {
            console.log("Form errors:", formErrors);
            error("Error!", "Terjadi kesalahan saat menyimpan data.");
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
