<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Bulk Upload KHS
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Upload multiple file KHS sekaligus
                        </p>
                    </div>
                    <Link
                        :href="route('super-admin.khs.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upload Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Bulk Upload Form
                    </h2>
                </div>
                <form @submit.prevent="handleSubmit" class="p-6">
                    <!-- Academic Period -->
                    <div class="mb-6">
                        <label
                            for="academic_period_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Period Akademik <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="academic_period_id"
                            v-model="form.academic_period_id"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.academic_period_id
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            required
                        >
                            <option value="">Pilih Period Akademik...</option>
                            <option
                                v-for="period in periods"
                                :key="period.id"
                                :value="period.id"
                            >
                                {{
                                    period.display_name ??
                                    period.name ??
                                    period.semester + " " + period.academic_year
                                }}
                            </option>
                        </select>
                        <p
                            v-if="errors.academic_period_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.academic_period_id }}
                        </p>
                    </div>

                    <!-- Multiple File Upload -->
                    <div class="mb-6">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            File KHS (Multiple PDF)
                            <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors"
                        >
                            <div class="space-y-1 text-center">
                                <DocumentArrowUpIcon
                                    class="mx-auto h-12 w-12 text-gray-400"
                                />
                                <div class="flex text-sm text-gray-600">
                                    <label
                                        for="files-upload"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                    >
                                        <span>Upload multiple files</span>
                                        <input
                                            id="files-upload"
                                            name="files"
                                            type="file"
                                            class="sr-only"
                                            accept=".pdf"
                                            multiple
                                            @change="handleFilesChange"
                                            ref="filesInput"
                                        />
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PDF files, maksimal 10MB per file
                                </p>
                            </div>
                        </div>

                        <!-- Selected Files Display -->
                        <div
                            v-if="selectedFiles.length > 0"
                            class="mt-4 space-y-2"
                        >
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-700">
                                    File yang dipilih ({{
                                        selectedFiles.length
                                    }}
                                    files)
                                </h3>
                                <button
                                    type="button"
                                    @click="clearAllFiles"
                                    class="text-sm text-red-600 hover:text-red-800"
                                >
                                    Hapus semua
                                </button>
                            </div>

                            <div
                                class="max-h-60 overflow-y-auto border border-gray-200 rounded-md"
                            >
                                <div
                                    v-for="(file, index) in selectedFiles"
                                    :key="index"
                                    class="flex items-center justify-between px-3 py-2 border-b border-gray-100 last:border-b-0"
                                    :class="
                                        file.error ? 'bg-red-50' : 'bg-gray-50'
                                    "
                                >
                                    <div class="flex items-center">
                                        <DocumentTextIcon
                                            class="h-5 w-5 mr-2"
                                            :class="
                                                file.error
                                                    ? 'text-red-400'
                                                    : 'text-gray-400'
                                            "
                                        />
                                        <div>
                                            <span
                                                class="text-sm font-medium text-gray-900"
                                                >{{ file.name }}</span
                                            >
                                            <div class="text-xs text-gray-500">
                                                {{ formatFileSize(file.size) }}
                                                <span
                                                    v-if="file.nim"
                                                    class="ml-2 text-blue-600"
                                                >
                                                    NIM: {{ file.nim }}
                                                </span>
                                            </div>
                                            <div
                                                v-if="file.error"
                                                class="text-xs text-red-600"
                                            >
                                                {{ file.error }}
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        @click="removeFile(index)"
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        <XMarkIcon class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <p
                            v-if="errors.files"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.files }}
                        </p>
                    </div>

                    <!-- File Analysis Summary -->
                    <div
                        v-if="fileSummary.valid > 0 || fileSummary.invalid > 0"
                        class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-md"
                    >
                        <h3 class="text-sm font-medium text-gray-700 mb-2">
                            Ringkasan File
                        </h3>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div class="text-center">
                                <div class="text-lg font-bold text-green-600">
                                    {{ fileSummary.valid }}
                                </div>
                                <div class="text-gray-600">Valid</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-red-600">
                                    {{ fileSummary.invalid }}
                                </div>
                                <div class="text-gray-600">Error</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-blue-600">
                                    {{ fileSummary.uniqueNims }}
                                </div>
                                <div class="text-gray-600">Unique NIMs</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3">
                        <Link
                            :href="route('super-admin.khs.index')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="!canSubmit || processing"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="processing" class="flex items-center">
                                <svg
                                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                                Mengupload {{ fileSummary.valid }} files...
                            </span>
                            <span v-else>
                                <DocumentArrowUpIcon class="w-4 h-4 mr-2" />
                                Upload {{ fileSummary.valid }} Files
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Guidelines & Instructions -->
            <div class="space-y-6">
                <!-- Naming Convention -->
                <div
                    class="bg-blue-50 rounded-lg shadow-sm border border-blue-200"
                >
                    <div class="px-6 py-4 border-b border-blue-200">
                        <h2 class="text-lg font-medium text-blue-900">
                            Naming Convention
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-blue-800 space-y-3">
                            <p class="font-medium">
                                Format nama file yang disarankan:
                            </p>
                            <div
                                class="bg-blue-100 p-3 rounded-md font-mono text-xs"
                            >
                                [NIM]_KHS_[Semester]_[Tahun].pdf
                            </div>
                            <div class="space-y-1">
                                <p class="font-medium">Contoh:</p>
                                <ul
                                    class="list-disc list-inside space-y-1 text-xs"
                                >
                                    <li>2025001_KHS_Ganjil_2025-2026.pdf</li>
                                    <li>2025002_KHS_Genap_2024-2025.pdf</li>
                                    <li>2025001.pdf (minimal - hanya NIM)</li>
                                </ul>
                            </div>
                            <p class="text-xs text-blue-600">
                                <strong>Penting:</strong> Nama file harus
                                dimulai dengan NIM mahasiswa yang valid
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Download Template -->
                <div
                    class="bg-green-50 rounded-lg shadow-sm border border-green-200"
                >
                    <div class="px-6 py-4 border-b border-green-200">
                        <h2 class="text-lg font-medium text-green-900">
                            Template & Panduan
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-green-800 mb-4">
                            Download template panduan untuk naming convention
                            dan format file.
                        </p>
                        <a
                            :href="route('super-admin.khs.download-template')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowDownTrayIcon class="w-4 h-4 mr-2" />
                            Download Template
                        </a>
                    </div>
                </div>

                <!-- File Requirements -->
                <div
                    class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200"
                >
                    <div class="px-6 py-4 border-b border-yellow-200">
                        <h2 class="text-lg font-medium text-yellow-900">
                            Persyaratan File
                        </h2>
                    </div>
                    <div class="p-6">
                        <ul class="text-sm text-yellow-800 space-y-2">
                            <li class="flex items-start">
                                <CheckCircleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span>Format: PDF only</span>
                            </li>
                            <li class="flex items-start">
                                <CheckCircleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span>Ukuran maksimal: 10MB per file</span>
                            </li>
                            <li class="flex items-start">
                                <CheckCircleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span
                                    >Nama file harus dimulai dengan NIM yang
                                    valid</span
                                >
                            </li>
                            <li class="flex items-start">
                                <CheckCircleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span>Maksimal 100 files per upload</span>
                            </li>
                            <li class="flex items-start">
                                <ExclamationTriangleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span
                                    >File yang sudah ada akan ditimpa
                                    (overwrite)</span
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Upload Process -->
                <div
                    class="bg-purple-50 rounded-lg shadow-sm border border-purple-200"
                >
                    <div class="px-6 py-4 border-b border-purple-200">
                        <h2 class="text-lg font-medium text-purple-900">
                            Proses Upload
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-purple-800 space-y-3">
                            <div class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white text-xs rounded-full flex items-center justify-center mr-3 mt-0.5"
                                    >1</span
                                >
                                <span>Validasi format dan nama file</span>
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white text-xs rounded-full flex items-center justify-center mr-3 mt-0.5"
                                    >2</span
                                >
                                <span>Extract NIM dari nama file</span>
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white text-xs rounded-full flex items-center justify-center mr-3 mt-0.5"
                                    >3</span
                                >
                                <span
                                    >Upload ke Google Drive secara
                                    parallel</span
                                >
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white text-xs rounded-full flex items-center justify-center mr-3 mt-0.5"
                                    >4</span
                                >
                                <span
                                    >Generate access links untuk orang tua</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, reactive } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    DocumentArrowUpIcon,
    DocumentTextIcon,
    XMarkIcon,
    CheckCircleIcon,
    ExclamationTriangleIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    periods: {
        type: Array,
        default: () => [],
    },
});

// Form
const form = useForm({
    academic_period_id: "",
    files: [],
});

// Reactive data
const processing = ref(false);
const errors = ref({});
const selectedFiles = ref([]);
const filesInput = ref(null);

// Computed
const canSubmit = computed(() => {
    return form.academic_period_id && fileSummary.value.valid > 0;
});

const fileSummary = computed(() => {
    const valid = selectedFiles.value.filter((f) => !f.error).length;
    const invalid = selectedFiles.value.filter((f) => f.error).length;
    const nims = new Set(
        selectedFiles.value.filter((f) => f.nim && !f.error).map((f) => f.nim)
    );

    return {
        valid,
        invalid,
        uniqueNims: nims.size,
        total: selectedFiles.value.length,
    };
});

// Methods
const handleFilesChange = (event) => {
    const files = Array.from(event.target.files);

    if (files.length > 100) {
        errors.value.files = "Maksimal 100 files per upload";
        return;
    }

    selectedFiles.value = files.map((file) => {
        const fileData = {
            file,
            name: file.name,
            size: file.size,
            nim: null,
            error: null,
        };

        // Validate file
        if (file.type !== "application/pdf") {
            fileData.error = "Bukan file PDF";
        } else if (file.size > 10 * 1024 * 1024) {
            fileData.error = "Ukuran lebih dari 10MB";
        } else {
            // Extract NIM from filename
            const nimMatch = file.name.match(/^(\d+)/);
            if (nimMatch) {
                fileData.nim = nimMatch[1];
            } else {
                fileData.error = "Tidak dapat extract NIM dari nama file";
            }
        }

        return fileData;
    });

    // Update form files with valid files only
    form.files = selectedFiles.value.filter((f) => !f.error).map((f) => f.file);

    errors.value.files = null;
};

const removeFile = (index) => {
    selectedFiles.value.splice(index, 1);

    // Update form files
    form.files = selectedFiles.value.filter((f) => !f.error).map((f) => f.file);
};

const clearAllFiles = () => {
    selectedFiles.value = [];
    form.files = [];
    filesInput.value.value = "";
};

const formatFileSize = (bytes) => {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

const handleSubmit = () => {
    if (fileSummary.value.valid === 0) {
        errors.value.files = "Tidak ada file valid untuk diupload";
        return;
    }

    processing.value = true;
    errors.value = {};

    form.post(route("super-admin.khs.store-bulk-upload"), {
        onSuccess: () => {
            processing.value = false;
            clearAllFiles();
        },
        onError: (responseErrors) => {
            processing.value = false;
            errors.value = responseErrors;
        },
    });
};
</script>
