<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const form = useForm({
    title: "",
    document_code: "",
    category: "",
    description: "",
    file: null,
    tags: "",
    version: "1.0",
    is_published: true,
});

const filePreview = ref(null);
const fileName = ref("");

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.file = file;
        fileName.value = file.name;

        // Show file info
        const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
        filePreview.value = {
            name: file.name,
            size: `${fileSizeMB} MB`,
            type: file.type,
        };
    }
};

const removeFile = () => {
    form.file = null;
    fileName.value = "";
    filePreview.value = null;
    const input = document.getElementById("file-input");
    if (input) input.value = "";
};

const submit = () => {
    form.post(route("admin.gpm.dokumen-spmi.store"), {
        preserveScroll: true,
        forceFormData: true, // CRITICAL for file upload
    });
};
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <a
                        :href="route('admin.gpm.dokumen-spmi.index')"
                        class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4"
                    >
                        <svg
                            class="w-4 h-4 mr-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Kembali
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Upload Dokumen SPMI
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Upload dokumen baru ke sistem SPMI
                    </p>
                </div>

                <!-- Form -->
                <form
                    @submit.prevent="submit"
                    class="bg-white shadow rounded-lg p-6"
                >
                    <div class="space-y-6">
                        <!-- File Upload -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                File Dokumen <span class="text-red-500">*</span>
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition"
                            >
                                <div class="space-y-1 text-center">
                                    <svg
                                        v-if="!filePreview"
                                        class="mx-auto h-12 w-12 text-gray-400"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 48 48"
                                    >
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>

                                    <div
                                        v-if="filePreview"
                                        class="text-sm text-gray-600"
                                    >
                                        <div class="font-medium text-blue-600">
                                            {{ filePreview.name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ filePreview.size }}
                                        </div>
                                    </div>

                                    <div class="flex text-sm text-gray-600">
                                        <label
                                            for="file-input"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none"
                                        >
                                            <span>{{
                                                filePreview
                                                    ? "Ganti file"
                                                    : "Upload file"
                                            }}</span>
                                            <input
                                                id="file-input"
                                                type="file"
                                                accept=".pdf,.doc,.docx,.xls,.xlsx"
                                                @change="handleFileChange"
                                                class="sr-only"
                                            />
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PDF, DOC, DOCX, XLS, XLSX maksimal 10MB
                                    </p>
                                </div>
                            </div>
                            <button
                                v-if="filePreview"
                                @click="removeFile"
                                type="button"
                                class="mt-2 text-sm text-red-600 hover:text-red-800"
                            >
                                Hapus file
                            </button>
                            <p
                                v-if="form.errors.file"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.file }}
                            </p>
                        </div>

                        <!-- Title -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Judul Dokumen
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.title"
                                type="text"
                                placeholder="Standar Penjaminan Mutu Pendidikan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.title }"
                            />
                            <p
                                v-if="form.errors.title"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.title }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Document Code -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Kode Dokumen</label
                                >
                                <input
                                    v-model="form.document_code"
                                    type="text"
                                    placeholder="SPMI-STD-001"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{
                                        'border-red-500':
                                            form.errors.document_code,
                                    }"
                                />
                                <p
                                    v-if="form.errors.document_code"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.document_code }}
                                </p>
                            </div>

                            <!-- Category -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.category"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{
                                        'border-red-500': form.errors.category,
                                    }"
                                >
                                    <option value="">Pilih Kategori</option>
                                    <option value="standar">Standar</option>
                                    <option value="manual">Manual</option>
                                    <option value="formulir">Formulir</option>
                                    <option value="sop">SOP</option>
                                </select>
                                <p
                                    v-if="form.errors.category"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.category }}
                                </p>
                            </div>

                            <!-- Version -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Versi</label
                                >
                                <input
                                    v-model="form.version"
                                    type="text"
                                    placeholder="1.0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                            </div>

                            <!-- Tags -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Tags</label
                                >
                                <input
                                    v-model="form.tags"
                                    type="text"
                                    placeholder="audit, evaluasi, mutu"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                                <p class="mt-1 text-xs text-gray-500">
                                    Pisahkan dengan koma
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Deskripsi</label
                            >
                            <textarea
                                v-model="form.description"
                                rows="4"
                                placeholder="Deskripsi dokumen..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{
                                    'border-red-500': form.errors.description,
                                }"
                            ></textarea>
                            <p
                                v-if="form.errors.description"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.description }}
                            </p>
                        </div>

                        <!-- Is Published -->
                        <div>
                            <label class="flex items-center">
                                <input
                                    v-model="form.is_published"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                                <span class="ml-2 text-sm text-gray-700"
                                    >Publish dokumen</span
                                >
                            </label>
                            <p class="mt-1 text-xs text-gray-500">
                                Dokumen yang dipublish dapat diakses publik
                            </p>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex items-center justify-end gap-3">
                        <a
                            :href="route('admin.gpm.dokumen-spmi.index')"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Batal
                        </a>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                        >
                            <span v-if="form.processing">Mengupload...</span>
                            <span v-else>Upload Dokumen</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
