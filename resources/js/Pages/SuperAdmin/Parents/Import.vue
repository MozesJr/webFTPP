<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Import Data Orang Tua & Siswa
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Upload file Excel untuk membuat akun orang tua dan
                            data siswa sekaligus
                        </p>
                    </div>
                    <Link
                        :href="route('super-admin.parents.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Import Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Upload File
                    </h2>
                </div>
                <form @submit.prevent="handleSubmit" class="p-6">
                    <div class="mb-6">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            File Excel <span class="text-red-500">*</span>
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
                                        for="file-upload"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                    >
                                        <span>Upload file</span>
                                        <input
                                            id="file-upload"
                                            name="file"
                                            type="file"
                                            class="sr-only"
                                            accept=".xlsx,.xls,.csv"
                                            @change="handleFileChange"
                                            ref="fileInput"
                                        />
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Excel atau CSV hingga 2MB
                                </p>
                            </div>
                        </div>

                        <div
                            v-if="selectedFile"
                            class="mt-3 flex items-center justify-between bg-gray-50 px-3 py-2 rounded-md"
                        >
                            <div class="flex items-center">
                                <DocumentTextIcon
                                    class="h-5 w-5 text-gray-400 mr-2"
                                />
                                <span class="text-sm text-gray-900">{{
                                    selectedFile.name
                                }}</span>
                                <span class="text-xs text-gray-500 ml-2"
                                    >({{
                                        formatFileSize(selectedFile.size)
                                    }})</span
                                >
                            </div>
                            <button
                                type="button"
                                @click="removeFile"
                                class="text-red-500 hover:text-red-700"
                            >
                                <XMarkIcon class="h-4 w-4" />
                            </button>
                        </div>

                        <p v-if="errors.file" class="mt-1 text-sm text-red-600">
                            {{ errors.file }}
                        </p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <Link
                            :href="route('super-admin.parents.index')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="!selectedFile || processing"
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
                                Mengimpor...
                            </span>
                            <span v-else>
                                <DocumentArrowUpIcon class="w-4 h-4 mr-2" />
                                Import Data
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Instructions -->
            <div class="space-y-6">
                <!-- Download Template -->
                <div
                    class="bg-blue-50 rounded-lg shadow-sm border border-blue-200"
                >
                    <div class="px-6 py-4 border-b border-blue-200">
                        <h2 class="text-lg font-medium text-blue-900">
                            Template Excel
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-blue-800 mb-4">
                            Download template Excel untuk memastikan format data
                            yang benar.
                        </p>
                        <a
                            href="/super-admin/parents/download-template"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowDownTrayIcon class="w-4 h-4 mr-2" />
                            Download Template
                        </a>
                    </div>
                </div>

                <!-- Format Guidelines -->
                <div
                    class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200"
                >
                    <div class="px-6 py-4 border-b border-yellow-200">
                        <h2 class="text-lg font-medium text-yellow-900">
                            Panduan Format Data
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-yellow-800 space-y-3">
                            <div>
                                <h3 class="font-medium mb-2">
                                    Kolom yang Diperlukan:
                                </h3>
                                <ul
                                    class="list-disc list-inside space-y-1 text-xs"
                                >
                                    <li>
                                        <strong>nim_siswa</strong>: NIM siswa
                                        (unik)
                                    </li>
                                    <li>
                                        <strong>nama_siswa</strong>: Nama
                                        lengkap siswa
                                    </li>
                                    <li>
                                        <strong>jenis_kelamin</strong>: L atau P
                                    </li>
                                    <li>
                                        <strong>nama_orang_tua</strong>: Nama
                                        lengkap orang tua
                                    </li>
                                    <li>
                                        <strong>hubungan</strong>: ayah/ibu/wali
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h3 class="font-medium mb-2">
                                    Kolom Opsional:
                                </h3>
                                <ul
                                    class="list-disc list-inside space-y-1 text-xs"
                                >
                                    <li>email_siswa, telepon_siswa</li>
                                    <li>email_orang_tua, telepon_orang_tua</li>
                                    <li>tanggal_lahir, tempat_lahir</li>
                                    <li>program_studi, semester</li>
                                    <li>pekerjaan, alamat</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Generated Account Info -->
                <div
                    class="bg-green-50 rounded-lg shadow-sm border border-green-200"
                >
                    <div class="px-6 py-4 border-b border-green-200">
                        <h2 class="text-lg font-medium text-green-900">
                            Info Akun yang Dibuat
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-green-800 space-y-2">
                            <p><strong>Username:</strong> NIM siswa</p>
                            <p>
                                <strong>Password:</strong> NIM + tanggal lahir
                                (ddmmyyyy)
                            </p>
                            <p><strong>Contoh:</strong></p>
                            <div
                                class="bg-green-100 p-3 rounded-md text-xs font-mono"
                            >
                                Username: 2023001<br />
                                Password: 202300115012000 (jika lahir 15 Jan
                                2000)
                            </div>
                            <p class="text-xs italic">
                                Jika tanggal lahir kosong, password = NIM + 123
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    DocumentArrowUpIcon,
    DocumentTextIcon,
    XMarkIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/outline";

// Form
const form = useForm({
    file: null,
});

const selectedFile = ref(null);
const processing = ref(false);
const errors = ref({});
const fileInput = ref(null);

// Methods
const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        selectedFile.value = file;
        form.file = file;
        errors.value = {};
    }
};

const removeFile = () => {
    selectedFile.value = null;
    form.file = null;
    fileInput.value.value = "";
};

const formatFileSize = (bytes) => {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

const handleSubmit = () => {
    if (!selectedFile.value) {
        errors.value.file = "File harus dipilih";
        return;
    }

    processing.value = true;
    errors.value = {};

    form.post("/super-admin/parents/import", {
        onSuccess: () => {
            processing.value = false;
            selectedFile.value = null;
        },
        onError: (responseErrors) => {
            processing.value = false;
            errors.value = responseErrors;
        },
    });
};
</script>
