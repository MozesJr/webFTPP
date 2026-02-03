<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    dokumen: Object,
});

const form = useForm({
    title: props.dokumen.title,
    document_code: props.dokumen.document_code,
    category: props.dokumen.category,
    description: props.dokumen.description,
    file: null,
    tags: props.dokumen.tags,
    version: props.dokumen.version,
    is_published: props.dokumen.is_published,
    _method: "PUT",
});

const filePreview = ref(null);
const hasNewFile = ref(false);

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.file = file;
        hasNewFile.value = true;

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
    hasNewFile.value = false;
    filePreview.value = null;
    const input = document.getElementById("file-input");
    if (input) input.value = "";
};

const submit = () => {
    form.post(route("admin.gpm.dokumen-spmi.update", props.dokumen.id), {
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
                        Edit Dokumen SPMI
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Edit informasi dokumen
                    </p>
                </div>

                <!-- Form -->
                <form
                    @submit.prevent="submit"
                    class="bg-white shadow rounded-lg p-6"
                >
                    <div class="space-y-6">
                        <!-- Current File Info -->
                        <div
                            class="bg-blue-50 border border-blue-200 rounded-lg p-4"
                        >
                            <div class="flex items-start">
                                <svg
                                    class="h-5 w-5 text-blue-600 mt-0.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                                <div class="ml-3 flex-1">
                                    <h3
                                        class="text-sm font-medium text-blue-900"
                                    >
                                        File Saat Ini
                                    </h3>
                                    <div class="mt-1 text-sm text-blue-700">
                                        <div class="font-medium">
                                            {{
                                                dokumen.original_filename ||
                                                "Dokumen SPMI"
                                            }}
                                        </div>
                                        <div class="text-xs">
                                            {{ dokumen.file_size_human }}
                                        </div>
                                    </div>
                                    <a
                                        :href="
                                            route(
                                                'admin.gpm.dokumen-spmi.download',
                                                dokumen.id,
                                            )
                                        "
                                        class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-800"
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
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                            />
                                        </svg>
                                        Download file saat ini
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Replace File (Optional) -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Ganti File (Opsional)
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
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500"
                                        >
                                            <span>{{
                                                filePreview
                                                    ? "Ganti file lain"
                                                    : "Upload file baru"
                                            }}</span>
                                            <input
                                                id="file-input"
                                                type="file"
                                                accept=".pdf,.doc,.docx,.xls,.xlsx"
                                                @change="handleFileChange"
                                                class="sr-only"
                                            />
                                        </label>
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
                                Batalkan upload file baru
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
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                />
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
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            ></textarea>
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
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
