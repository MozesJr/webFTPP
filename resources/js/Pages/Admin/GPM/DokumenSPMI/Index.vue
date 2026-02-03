<script setup>
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { useSwal } from "@/Composables/useSwal";

const props = defineProps({
    dokumen: Object, // Laravel pagination object
    filters: Object,
});

const { success, error, confirmDelete } = useSwal();
const page = usePage();

// Additional filters
const categoryFilter = ref(props.filters?.category || "");
const statusFilter = ref(props.filters?.status || "");

// Table headers
const headers = [
    { key: "title", label: "Judul Dokumen", align: "left" },
    { key: "document_code", label: "Kode Dokumen", align: "left" },
    { key: "category", label: "Kategori", align: "center" },
    { key: "file_size", label: "Ukuran", align: "center" },
    { key: "downloads", label: "Unduhan", align: "center" },
    { key: "is_published", label: "Status", align: "center" },
    { key: "actions", label: "Aksi", align: "center" },
];

// Apply filters
const applyFilters = () => {
    router.get(
        route("admin.gpm.dokumen-spmi.index"),
        {
            search: props.filters?.search || "",
            category: categoryFilter.value,
            status: statusFilter.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

// Reset filters
const resetFilters = () => {
    categoryFilter.value = "";
    statusFilter.value = "";
    router.get(
        route("admin.gpm.dokumen-spmi.index"),
        {},
        {
            preserveState: true,
        },
    );
};

// Delete dokumen
const deleteDokumen = async (dokumen) => {
    const confirmed = await confirmDelete(
        "Hapus Dokumen",
        `Yakin ingin menghapus "${dokumen.title}"?`,
    );

    if (confirmed) {
        router.delete(route("admin.gpm.dokumen-spmi.destroy", dokumen.id), {
            onSuccess: () => {
                success("Berhasil!", "Dokumen berhasil dihapus.");
            },
            onError: () => {
                showError(
                    "Gagal!",
                    "Terjadi kesalahan saat menghapus dokumen.",
                );
            },
        });
    }
};

// Toggle publish status
const togglePublish = (dokumen) => {
    router.post(
        route("admin.gpm.dokumen-spmi.toggle-publish", dokumen.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                const status = dokumen.is_published
                    ? "dipublish"
                    : "diarsipkan";
                success("Berhasil!", `Dokumen berhasil ${status}.`);
            },
        },
    );
};

// Get category color
const getCategoryColor = (category) => {
    const colors = {
        standar: "bg-blue-100 text-blue-800",
        manual: "bg-green-100 text-green-800",
        formulir: "bg-yellow-100 text-yellow-800",
        sop: "bg-purple-100 text-purple-800",
    };
    return colors[category] || "bg-gray-100 text-gray-800";
};

// Get category label
const getCategoryLabel = (category) => {
    const labels = {
        standar: "Standar",
        manual: "Manual",
        formulir: "Formulir",
        sop: "SOP",
    };
    return labels[category] || category;
};

// Show flash messages
if (page.props.flash?.success) {
    success("Berhasil!", page.props.flash.success);
}
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="md:flex md:items-center md:justify-between mb-6">
                    <div class="flex-1 min-w-0">
                        <h2
                            class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"
                        >
                            Dokumen SPMI
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Kelola dokumen Sistem Penjaminan Mutu Internal
                        </p>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <a
                            :href="route('admin.gpm.dokumen-spmi.create')"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700"
                        >
                            <svg
                                class="-ml-1 mr-2 h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Upload Dokumen
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Kategori</label
                            >
                            <select
                                v-model="categoryFilter"
                                @change="applyFilters"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                                <option value="">Semua Kategori</option>
                                <option value="standar">Standar</option>
                                <option value="manual">Manual</option>
                                <option value="formulir">Formulir</option>
                                <option value="sop">SOP</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Status</label
                            >
                            <select
                                v-model="statusFilter"
                                @change="applyFilters"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                                <option value="">Semua Status</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button
                                @click="applyFilters"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700"
                            >
                                Terapkan Filter
                            </button>
                            <button
                                @click="resetFilters"
                                class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200"
                            >
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- DataTable -->
                <DataTable
                    title="Daftar Dokumen SPMI"
                    :headers="headers"
                    :items="dokumen.data"
                    :filters="filters"
                    :pagination="dokumen"
                    routeName="admin.gpm.dokumen-spmi.index"
                >
                    <template #body="{ items }">
                        <tr
                            v-for="doc in items"
                            :key="doc.id"
                            class="hover:bg-gray-50"
                        >
                            <!-- Title -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ doc.title }}
                                </div>
                                <div
                                    v-if="doc.description"
                                    class="text-sm text-gray-500 truncate max-w-md"
                                >
                                    {{ doc.description }}
                                </div>
                            </td>

                            <!-- Document Code -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-mono">
                                    {{ doc.document_code || "-" }}
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        getCategoryColor(doc.category),
                                    ]"
                                >
                                    {{ getCategoryLabel(doc.category) }}
                                </span>
                            </td>

                            <!-- File Size -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    {{ doc.file_size_human || "-" }}
                                </div>
                            </td>

                            <!-- Downloads -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    {{ doc.download_count || 0 }}
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button
                                    @click="togglePublish(doc)"
                                    class="inline-flex items-center"
                                >
                                    <span
                                        :class="[
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            doc.is_published
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-gray-100 text-gray-800',
                                        ]"
                                    >
                                        {{
                                            doc.is_published
                                                ? "Published"
                                                : "Draft"
                                        }}
                                    </span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div
                                    class="flex items-center justify-center gap-2"
                                >
                                    <a
                                        :href="
                                            route(
                                                'admin.gpm.dokumen-spmi.show',
                                                doc.id,
                                            )
                                        "
                                        class="text-green-600 hover:text-green-900"
                                        title="Lihat"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                            />
                                        </svg>
                                    </a>
                                    <a
                                        :href="
                                            route(
                                                'admin.gpm.dokumen-spmi.download',
                                                doc.id,
                                            )
                                        "
                                        class="text-indigo-600 hover:text-indigo-900"
                                        title="Download"
                                    >
                                        <svg
                                            class="h-5 w-5"
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
                                    </a>
                                    <a
                                        :href="
                                            route(
                                                'admin.gpm.dokumen-spmi.edit',
                                                doc.id,
                                            )
                                        "
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Edit"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                            />
                                        </svg>
                                    </a>
                                    <button
                                        @click="deleteDokumen(doc)"
                                        class="text-red-600 hover:text-red-900"
                                        title="Hapus"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </DataTable>
            </div>
        </div>
    </AdminLayout>
</template>
