<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Kurikulum
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat kurikulum baru untuk program studi
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

            <form @submit.prevent="submit" class="p-6">
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
                                    'border-red-300':
                                        form.errors.prodi_id || errors.prodi_id,
                                }"
                                @change="validateField('prodi_id')"
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
                                v-if="form.errors.prodi_id || errors.prodi_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.prodi_id || errors.prodi_id }}
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
                                    'border-red-300':
                                        form.errors.name || errors.name,
                                }"
                                placeholder="contoh: Kurikulum 2024"
                                @blur="validateField('name')"
                            />
                            <div
                                v-if="form.errors.name || errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.name || errors.name }}
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
                                            form.errors.academic_year ||
                                            errors.academic_year,
                                    }"
                                    placeholder="2024/2025"
                                    @blur="validateField('academic_year')"
                                />
                                <div
                                    v-if="
                                        form.errors.academic_year ||
                                        errors.academic_year
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.academic_year ||
                                        errors.academic_year
                                    }}
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
                                            form.errors.total_credits ||
                                            errors.total_credits,
                                    }"
                                    placeholder="144"
                                    @blur="validateField('total_credits')"
                                />
                                <div
                                    v-if="
                                        form.errors.total_credits ||
                                        errors.total_credits
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.total_credits ||
                                        errors.total_credits
                                    }}
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
                                    'border-red-300':
                                        form.errors.description ||
                                        errors.description,
                                }"
                                placeholder="Deskripsi kurikulum"
                            ></textarea>
                            <div
                                v-if="
                                    form.errors.description ||
                                    errors.description
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.description ||
                                    errors.description
                                }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.description.length }}/1000 karakter
                            </p>
                        </div>

                        <!-- Document Upload -->
                        <div>
                            <label
                                for="document_url"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Dokumen Kurikulum
                            </label>
                            <input
                                id="document_url"
                                ref="documentInput"
                                type="file"
                                accept=".pdf,.doc,.docx"
                                @change="handleDocumentChange"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <div
                                v-if="
                                    form.errors.document_url ||
                                    errors.document_url
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.document_url ||
                                    errors.document_url
                                }}
                            </div>

                            <!-- Document Preview -->
                            <div v-if="documentPreview" class="mt-3">
                                <div class="flex items-center space-x-2">
                                    <DocumentIcon
                                        class="h-8 w-8 text-blue-500"
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
                                Format: PDF, DOC, DOCX. Maksimal 5MB
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
                        <span v-else> Simpan Kurikulum </span>
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
import {
    ArrowLeftIcon,
    DocumentIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
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

// Custom validation errors
const errors = reactive({
    prodi_id: "",
    name: "",
    academic_year: "",
    total_credits: "",
    document_url: "",
});

// Form
const form = useForm({
    prodi_id: "",
    name: "",
    academic_year: "",
    total_credits: "",
    document_url: null,
    description: "",
    is_active: true,
});

// Computed
const isFormValid = computed(() => {
    return (
        form.prodi_id !== "" &&
        form.name.trim() !== "" &&
        form.academic_year.trim() !== "" &&
        form.total_credits !== "" &&
        !Object.values(errors).some((error) => error !== "")
    );
});

// Methods
const validateField = (field) => {
    errors[field] = "";

    switch (field) {
        case "prodi_id":
            if (!form.prodi_id) {
                errors.prodi_id = "Program studi wajib dipilih";
            }
            break;

        case "name":
            if (!form.name.trim()) {
                errors.name = "Nama kurikulum wajib diisi";
            } else if (form.name.length < 5) {
                errors.name = "Nama kurikulum minimal 5 karakter";
            }
            break;

        case "academic_year":
            if (!form.academic_year.trim()) {
                errors.academic_year = "Tahun akademik wajib diisi";
            } else if (!/^\d{4}\/\d{4}$/.test(form.academic_year)) {
                errors.academic_year = "Format tahun akademik harus YYYY/YYYY";
            }
            break;

        case "total_credits":
            if (!form.total_credits) {
                errors.total_credits = "Total SKS wajib diisi";
            } else if (form.total_credits < 120 || form.total_credits > 200) {
                errors.total_credits = "Total SKS harus antara 120-200";
            }
            break;
    }
};

const validateDocument = (file) => {
    errors.document_url = "";

    if (!file) return true;

    // Check file type
    const allowedTypes = [
        "application/pdf",
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    ];
    if (!allowedTypes.includes(file.type)) {
        errors.document_url = "Format dokumen harus PDF, DOC, atau DOCX";
        return false;
    }

    // Check file size (5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if (file.size > maxSize) {
        errors.document_url = "Ukuran dokumen maksimal 5MB";
        return false;
    }

    return true;
};

const handleDocumentChange = (event) => {
    const file = event.target.files[0];

    if (file) {
        if (!validateDocument(file)) {
            event.target.value = "";
            documentPreview.value = null;
            form.document_url = null;
            return;
        }

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
    // Validate all required fields
    validateField("prodi_id");
    validateField("name");
    validateField("academic_year");
    validateField("total_credits");

    if (Object.values(errors).some((error) => error !== "")) {
        error("Validasi Error!", "Mohon perbaiki data yang belum valid.");
        return;
    }

    form.post("/admin/kurikulum", {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Kurikulum berhasil ditambahkan.");
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
