<script setup>
import { computed } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    dokumen: Object,
});

const getCategoryColor = (category) => {
    const colors = {
        standar: "bg-blue-100 text-blue-800",
        manual: "bg-green-100 text-green-800",
        formulir: "bg-yellow-100 text-yellow-800",
        sop: "bg-purple-100 text-purple-800",
    };
    return colors[category] || "bg-gray-100 text-gray-800";
};

const getCategoryLabel = (category) => {
    const labels = {
        standar: "Standar",
        manual: "Manual",
        formulir: "Formulir",
        sop: "SOP",
    };
    return labels[category] || category;
};

const tagsArray = computed(() => {
    if (!props.dokumen.tags) return [];
    return props.dokumen.tags
        .split(",")
        .map((tag) => tag.trim())
        .filter(Boolean);
});

const isPDF = computed(() => {
    return props.dokumen.file_path?.toLowerCase().endsWith(".pdf");
});
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
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

                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ dokumen.title }}
                            </h2>
                            <div class="mt-2 flex items-center gap-3">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        getCategoryColor(dokumen.category),
                                    ]"
                                >
                                    {{ getCategoryLabel(dokumen.category) }}
                                </span>
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        dokumen.is_published
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-800',
                                    ]"
                                >
                                    {{
                                        dokumen.is_published
                                            ? "Published"
                                            : "Draft"
                                    }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a
                                :href="
                                    route(
                                        'admin.gpm.dokumen-spmi.download',
                                        dokumen.id,
                                    )
                                "
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700"
                            >
                                <svg
                                    class="-ml-1 mr-2 h-5 w-5"
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
                                Download
                            </a>
                            <a
                                :href="
                                    route(
                                        'admin.gpm.dokumen-spmi.edit',
                                        dokumen.id,
                                    )
                                "
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                            >
                                <svg
                                    class="-ml-1 mr-2 h-5 w-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                    />
                                </svg>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Description -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Deskripsi
                            </h3>
                            <div class="prose max-w-none text-gray-700">
                                {{
                                    dokumen.description ||
                                    "Tidak ada deskripsi."
                                }}
                            </div>
                        </div>

                        <!-- PDF Preview (if PDF) -->
                        <div
                            v-if="isPDF && dokumen.file_url"
                            class="bg-white shadow rounded-lg p-6"
                        >
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Preview Dokumen
                            </h3>
                            <div class="border rounded-lg overflow-hidden">
                                <iframe
                                    :src="dokumen.file_url"
                                    class="w-full h-[600px]"
                                    frameborder="0"
                                ></iframe>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 text-center">
                                Preview mungkin tidak berfungsi di beberapa
                                browser.
                                <a
                                    :href="
                                        route(
                                            'admin.gpm.dokumen-spmi.download',
                                            dokumen.id,
                                        )
                                    "
                                    class="text-blue-600 hover:text-blue-800"
                                    >Download dokumen</a
                                >
                                untuk melihat lengkap.
                            </p>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Document Info -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi Dokumen
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Kode Dokumen
                                    </dt>
                                    <dd
                                        class="mt-1 text-sm text-gray-900 font-mono"
                                    >
                                        {{ dokumen.document_code || "-" }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Versi
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ dokumen.version || "-" }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Ukuran File
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ dokumen.file_size_human }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Nama File
                                    </dt>
                                    <dd
                                        class="mt-1 text-sm text-gray-900 break-all"
                                    >
                                        {{ dokumen.original_filename }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Jumlah Unduhan
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ dokumen.download_count || 0 }} kali
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Dilihat
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ dokumen.view_count || 0 }} kali
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Tags -->
                        <div
                            v-if="tagsArray.length > 0"
                            class="bg-white shadow rounded-lg p-6"
                        >
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Tags
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="tag in tagsArray"
                                    :key="tag"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    {{ tag }}
                                </span>
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Metadata
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Diupload oleh
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ dokumen.uploader?.name || "System" }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Tanggal Upload
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ dokumen.created_at }}
                                    </dd>
                                </div>
                                <div v-if="dokumen.published_at">
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Tanggal Publish
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ dokumen.published_at }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Terakhir Diupdate
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ dokumen.updated_at }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Actions -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Aksi Cepat
                            </h3>
                            <div class="space-y-2">
                                <a
                                    :href="
                                        route(
                                            'admin.gpm.dokumen-spmi.download',
                                            dokumen.id,
                                        )
                                    "
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <svg
                                        class="-ml-1 mr-2 h-5 w-5"
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
                                    Download Dokumen
                                </a>
                                <a
                                    :href="
                                        route(
                                            'admin.gpm.dokumen-spmi.edit',
                                            dokumen.id,
                                        )
                                    "
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <svg
                                        class="-ml-1 mr-2 h-5 w-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                        />
                                    </svg>
                                    Edit Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
