<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Kurikulum
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Perbarui kurikulum: {{ kurikulum.name }}
                        </p>
                    </div>
                    <Link
                        href="/admin/kurikulum"
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
                    Informasi Kurikulum
                </h2>
            </div>

            <form
                @submit.prevent="submit"
                class="p-6"
                enctype="multipart/form-data"
            >
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Program Studi -->
                        <div>
                            <label
                                for="prodi_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Program Studi
                                <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="prodi_id"
                                v-model="form.prodi_id"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.prodi_id,
                                }"
                            >
                                <option value="">Pilih Program Studi</option>
                                <option
                                    v-for="prodi in programStudis"
                                    :key="prodi.id"
                                    :value="prodi.id"
                                >
                                    {{ prodi.name }} ({{ prodi.degree_level }})
                                </option>
                            </select>
                            <div
                                v-if="form.errors.prodi_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.prodi_id }}
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Nama Kurikulum
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                maxlength="255"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.name,
                                }"
                                placeholder="contoh: Kurikulum 2024"
                            />
                            <div
                                v-if="form.errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <!-- Academic Year and Total Credits -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Academic Year -->
                            <div>
                                <label
                                    for="academic_year"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Tahun Akademik
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="academic_year"
                                    v-model="form.academic_year"
                                    type="text"
                                    required
                                    pattern="\d{4}/\d{4}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.academic_year,
                                    }"
                                    placeholder="2024/2025"
                                />
                                <div
                                    v-if="form.errors.academic_year"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.academic_year }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Format: YYYY/YYYY
                                </p>
                            </div>

                            <!-- Total Credits -->
                            <div>
                                <label
                                    for="total_credits"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Total SKS
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="total_credits"
                                    v-model="form.total_credits"
                                    type="number"
                                    required
                                    min="120"
                                    max="200"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.total_credits,
                                    }"
                                    placeholder="144"
                                />
                                <div
                                    v-if="form.errors.total_credits"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.total_credits }}
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label
                                for="description"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Deskripsi
                            </label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="4"
                                maxlength="1000"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.description,
                                }"
                                placeholder="Deskripsi kurikulum"
                            ></textarea>
                            <div
                                v-if="form.errors.description"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.description }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.description.length }}/1000 karakter
                            </p>
                        </div>

                        <!-- Current Document & Upload -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Dokumen Kurikulum
                            </label>

                            <!-- Current Document -->
                            <div v-if="currentDocumentUrl" class="mb-3">
                                <div class="flex items-center space-x-3">
                                    <DocumentIcon
                                        class="h-8 w-8 text-blue-500"
                                    />
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            Dokumen saat ini
                                        </p>
                                        <a
                                            :href="currentDocumentUrl"
                                            target="_blank"
                                            class="text-sm text-blue-600 hover:text-blue-800"
                                        >
                                            Lihat dokumen
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- File Input -->
                            <input
                                id="document_url"
                                ref="documentInput"
                                type="file"
                                accept=".pdf,.doc,.docx"
                                @change="handleDocumentChange"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <div
                                v-if="form.errors.document_url"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.document_url }}
                            </div>

                            <!-- New Document Preview -->
                            <div v-if="documentPreview" class="mt-3">
                                <div class="flex items-center space-x-2">
                                    <DocumentIcon
                                        class="h-8 w-8 text-green-500"
                                    />
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ documentPreview.name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{
                                                formatFileSize(
                                                    documentPreview.size
                                                )
                                            }}
                                            - Dokumen baru
                                        </p>
                                    </div>
                                    <button
                                        type="button"
                                        @click="removeDocument"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        <XMarkIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>

                            <p class="mt-1 text-sm text-gray-500">
                                Format: PDF, DOC, DOCX. Maksimal 5MB. Kosongkan
                                jika tidak ingin mengganti dokumen.
                            </p>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Status -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">
                                Status
                            </h3>
                            <div class="flex items-center">
                                <input
                                    id="is_active"
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label
                                    for="is_active"
                                    class="ml-2 block text-sm text-gray-900"
                                >
                                    Aktifkan kurikulum
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Kurikulum aktif dapat digunakan untuk mata
                                kuliah
                            </p>
                        </div>

                        <!-- Info -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-900 mb-2">
                                Informasi
                            </h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Tahun akademik format YYYY/YYYY</li>
                                <li>• Total SKS umumnya 144-150 untuk S1</li>
                                <li>• Dokumen sebaiknya dalam format PDF</li>
                                <li>
                                    • Satu program studi dapat memiliki multiple
                                    kurikulum
                                </li>
                            </ul>
                        </div>

                        <!-- Statistics -->
                        <div
                            class="bg-green-50 p-4 rounded-lg"
                            v-if="kurikulum.mata_kuliahs_count"
                        >
                            <h3 class="text-sm font-medium text-green-900 mb-2">
                                Statistik
                            </h3>
                            <div class="text-sm text-green-700">
                                <p>
                                    Mata Kuliah:
                                    {{ kurikulum.mata_kuliahs_count || 0 }}
                                </p>
                                <p>
                                    Program Studi:
                                    {{ kurikulum.program_studi?.name || "-" }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-3 border-t pt-6">
                    <Link
                        href="/admin/kurikulum"
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
                        <span v-else> Update Kurikulum </span>
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
import {
    ArrowLeftIcon,
    DocumentIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    kurikulum: {
        type: Object,
        required: true,
    },
    programStudis: {
        type: Array,
        default: () => [],
    },
});

// Composables
const page = usePage();
const { success, error } = useSwal();

// State
const documentInput = ref(null);
const documentPreview = ref(null);

// Computed
const currentDocumentUrl = computed(() => {
    return props.kurikulum?.document_url || null;
});

// Form dengan _method untuk method spoofing
const form = useForm({
    _method: "PUT",
    prodi_id: props.kurikulum?.prodi_id || "",
    name: props.kurikulum?.name || "",
    academic_year: props.kurikulum?.academic_year || "",
    total_credits: props.kurikulum?.total_credits || "",
    document_url: null,
    description: props.kurikulum?.description || "",
    is_active: props.kurikulum?.is_active ?? true,
});

// Methods
const handleDocumentChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.document_url = file;
        documentPreview.value = {
            name: file.name,
            size: file.size,
        };
    }
};

const removeDocument = () => {
    documentPreview.value = null;
    form.document_url = null;
    if (documentInput.value) {
        documentInput.value.value = "";
    }
};

const formatFileSize = (bytes) => {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

const submit = () => {
    // Gunakan POST dengan method spoofing
    form.post(`/admin/kurikulum/${props.kurikulum.id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Kurikulum berhasil diperbarui.");
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
