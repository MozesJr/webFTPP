<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Dokumen Penjaminan Mutu
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Edit dokumen: {{ penjaminanMutu.title }}
                        </p>
                    </div>
                    <Link
                        href="/admin/penjaminan-mutu"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="px-6 py-4 space-y-6">
                    <!-- Program Studi -->
                    <div>
                        <label
                            for="prodi_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Program Studi <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="prodi_id"
                            v-model="form.prodi_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{ 'border-red-500': form.errors.prodi_id }"
                        >
                            <option value="">Pilih Program Studi</option>
                            <option
                                v-for="prodi in programStudis"
                                :key="prodi.id"
                                :value="prodi.id"
                            >
                                {{ prodi.name }}
                            </option>
                        </select>
                        <div
                            v-if="form.errors.prodi_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.prodi_id }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Document Type -->
                        <div>
                            <label
                                for="document_type"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Jenis Dokumen
                                <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="document_type"
                                v-model="form.document_type"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500': form.errors.document_type,
                                }"
                            >
                                <option value="">Pilih Jenis Dokumen</option>
                                <option
                                    v-for="(label, value) in documentTypes"
                                    :key="value"
                                    :value="value"
                                >
                                    {{ label }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.document_type"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.document_type }}
                            </div>
                        </div>

                        <!-- Version -->
                        <div>
                            <label
                                for="version"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Versi <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="version"
                                v-model="form.version"
                                type="text"
                                placeholder="Contoh: 1.0, v2.1"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500': form.errors.version,
                                }"
                            />
                            <div
                                v-if="form.errors.version"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.version }}
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Judul Dokumen <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            placeholder="Masukkan judul dokumen"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{ 'border-red-500': form.errors.title }"
                        />
                        <div
                            v-if="form.errors.title"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.title }}
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Deskripsi
                        </label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            placeholder="Masukkan deskripsi dokumen (opsional)"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{
                                'border-red-500': form.errors.description,
                            }"
                        ></textarea>
                        <div
                            v-if="form.errors.description"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <!-- Current Document -->
                    <div v-if="penjaminanMutu.document_url">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Dokumen Saat Ini
                        </label>
                        <div
                            class="flex items-center p-4 bg-gray-50 rounded-lg border"
                        >
                            <DocumentTextIcon
                                class="h-8 w-8 text-blue-600 mr-3"
                            />
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ penjaminanMutu.title }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Dokumen yang sudah diupload
                                </p>
                            </div>
                            <a
                                :href="`/admin/penjaminan-mutu/${penjaminanMutu.id}/download`"
                                target="_blank"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                                Download
                            </a>
                        </div>
                    </div>

                    <!-- Document File -->
                    <div>
                        <label
                            for="document_file"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Upload Dokumen Baru (Opsional)
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
                                        for="document_file"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                    >
                                        <span>Upload file baru</span>
                                        <input
                                            id="document_file"
                                            @change="handleFileChange"
                                            type="file"
                                            accept=".pdf,.doc,.docx"
                                            class="sr-only"
                                        />
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PDF, DOC, DOCX hingga 10MB
                                </p>
                                <div
                                    v-if="selectedFile"
                                    class="mt-2 text-sm text-green-600"
                                >
                                    File baru terpilih: {{ selectedFile.name }}
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="form.errors.document_file"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.document_file }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Effective Date -->
                        <div>
                            <label
                                for="effective_date"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Tanggal Efektif
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="effective_date"
                                v-model="form.effective_date"
                                type="date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500':
                                        form.errors.effective_date,
                                }"
                            />
                            <div
                                v-if="form.errors.effective_date"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.effective_date }}
                            </div>
                        </div>

                        <!-- Review Date -->
                        <div>
                            <label
                                for="review_date"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Tanggal Review
                            </label>
                            <input
                                id="review_date"
                                v-model="form.review_date"
                                type="date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500': form.errors.review_date,
                                }"
                            />
                            <div
                                v-if="form.errors.review_date"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.review_date }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status -->
                        <div>
                            <label
                                for="status"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="status"
                                v-model="form.status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500': form.errors.status,
                                }"
                            >
                                <option value="">Pilih Status</option>
                                <option
                                    v-for="(label, value) in statusOptions"
                                    :key="value"
                                    :value="value"
                                >
                                    {{ label }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.status"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.status }}
                            </div>
                        </div>

                        <!-- Approved By -->
                        <div v-if="form.status === 'active'">
                            <label
                                for="approved_by"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Disetujui Oleh
                            </label>
                            <input
                                id="approved_by"
                                v-model="form.approved_by"
                                type="text"
                                placeholder="Nama penyetuju"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500': form.errors.approved_by,
                                }"
                            />
                            <div
                                v-if="form.errors.approved_by"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.approved_by }}
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3"
                >
                    <Link
                        href="/admin/penjaminan-mutu"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                    >
                        <span v-if="form.processing">
                            <svg
                                class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                        <span v-else>
                            <CheckIcon class="w-4 h-4 mr-2" />
                            Update Dokumen
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    CheckIcon,
    DocumentArrowUpIcon,
    DocumentTextIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    penjaminanMutu: {
        type: Object,
        required: true,
    },
    programStudis: {
        type: Array,
        default: () => [],
    },
    documentTypes: {
        type: Object,
        default: () => ({}),
    },
    statusOptions: {
        type: Object,
        default: () => ({}),
    },
});

// Form
const form = useForm({
    prodi_id: props.penjaminanMutu.prodi_id || "",
    document_type: props.penjaminanMutu.document_type || "",
    title: props.penjaminanMutu.title || "",
    description: props.penjaminanMutu.description || "",
    document_file: null,
    version: props.penjaminanMutu.version || "",
    effective_date: props.penjaminanMutu.effective_date || "",
    review_date: props.penjaminanMutu.review_date || "",
    status: props.penjaminanMutu.status || "draft",
    approved_by: props.penjaminanMutu.approved_by || "",
});

// File handling
const selectedFile = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        selectedFile.value = file;
        form.document_file = file;
    }
};

// Submit form
const submit = () => {
    form.put(route("admin.penjaminan-mutu.update", props.penjaminanMutu.id), {
        onSuccess: () => {
            // Handle success (redirect will be handled by controller)
        },
        onError: (errors) => {
            console.log("Form errors:", errors);
        },
    });
};
</script>
