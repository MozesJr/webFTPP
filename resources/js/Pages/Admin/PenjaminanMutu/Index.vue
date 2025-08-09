<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Penjaminan Mutu
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola dokumen penjaminan mutu program studi
                        </p>
                    </div>
                    <Link
                        href="/admin/penjaminan-mutu/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Dokumen
                    </Link>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Program Studi
                        </label>
                        <select
                            v-model="filterForm.prodi_id"
                            @change="applyFilters"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Semua Program Studi</option>
                            <option
                                v-for="prodi in programStudis"
                                :key="prodi.id"
                                :value="prodi.id"
                            >
                                {{ prodi.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Jenis Dokumen
                        </label>
                        <select
                            v-model="filterForm.document_type"
                            @change="applyFilters"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Semua Jenis</option>
                            <option
                                v-for="(label, value) in documentTypes"
                                :key="value"
                                :value="value"
                            >
                                {{ label }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Status
                        </label>
                        <select
                            v-model="filterForm.status"
                            @change="applyFilters"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Semua Status</option>
                            <option
                                v-for="(label, value) in statusOptions"
                                :key="value"
                                :value="value"
                            >
                                {{ label }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Cari
                        </label>
                        <input
                            v-model="filterForm.search"
                            @keyup.enter="applyFilters"
                            type="text"
                            placeholder="Cari dokumen..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>
                <div class="flex justify-end mt-4 space-x-2">
                    <button
                        @click="applyFilters"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                    >
                        <MagnifyingGlassIcon class="w-4 h-4 mr-2" />
                        Cari
                    </button>
                    <button
                        @click="resetFilters"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                    >
                        <XMarkIcon class="w-4 h-4 mr-2" />
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Dokumen Penjaminan Mutu'"
            :headers="tableHeaders"
            :items="penjaminanMutus.data"
            :filters="filters"
            :pagination="penjaminanMutus"
            :route-name="'admin.penjaminan-mutu.index'"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <DocumentTextIcon
                            class="mx-auto h-12 w-12 text-gray-400"
                        />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada dokumen
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan dokumen penjaminan mutu
                            pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/penjaminan-mutu/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Dokumen
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="dokumen in items"
                    :key="dokumen.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div
                                    class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center"
                                >
                                    <DocumentTextIcon
                                        class="h-5 w-5 text-blue-600"
                                    />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ dokumen.title }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ dokumen.program_studi?.name || "-" }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800"
                        >
                            {{
                                documentTypes[dokumen.document_type] ||
                                dokumen.document_type
                            }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                        {{ dokumen.version }}
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                        {{ formatDate(dokumen.effective_date) }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span :class="getStatusClass(dokumen.status)">
                            {{
                                statusOptions[dokumen.status] || dokumen.status
                            }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        {{ dokumen.created_by || "-" }}
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/penjaminan-mutu/${dokumen.id}`"
                                class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <EyeIcon class="h-4 w-4 mr-1" />
                                Lihat
                            </Link>

                            <button
                                v-if="dokumen.document_url"
                                @click="downloadDocument(dokumen.id)"
                                class="inline-flex items-center px-2 py-1 border border-green-300 text-xs leading-4 font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            >
                                <ArrowDownTrayIcon class="h-4 w-4 mr-1" />
                                Download
                            </button>

                            <Link
                                :href="`/admin/penjaminan-mutu/${dokumen.id}/edit`"
                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(dokumen)"
                                type="button"
                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                <TrashIcon class="h-4 w-4 mr-1" />
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import { onMounted, ref, reactive } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    DocumentTextIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
    ArrowDownTrayIcon,
    MagnifyingGlassIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";

// Props
const props = defineProps({
    penjaminanMutus: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({
            search: "",
            prodi_id: "",
            document_type: "",
            status: "",
        }),
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

// Table Headers for DataTable component
const tableHeaders = ref([
    { key: "title", label: "Judul Dokumen", align: "left" },
    { key: "document_type", label: "Jenis", align: "left" },
    { key: "version", label: "Versi", align: "left" },
    { key: "effective_date", label: "Tanggal Efektif", align: "left" },
    { key: "status", label: "Status", align: "left" },
    { key: "created_by", label: "Dibuat Oleh", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Filter form
const filterForm = reactive({
    search: props.filters.search || "",
    prodi_id: props.filters.prodi_id || "",
    document_type: props.filters.document_type || "",
    status: props.filters.status || "",
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const applyFilters = () => {
    router.get(route("admin.penjaminan-mutu.index"), filterForm, {
        preserveState: true,
        replace: true,
    });
};

const resetFilters = () => {
    Object.keys(filterForm).forEach((key) => {
        filterForm[key] = "";
    });
    applyFilters();
};

const getStatusClass = (status) => {
    const classes = {
        draft: "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800",
        active: "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800",
        obsolete:
            "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800",
    };
    return classes[status] || classes.draft;
};

const formatDate = (dateString) => {
    if (!dateString) return "-";
    return new Date(dateString).toLocaleDateString("id-ID");
};

const downloadDocument = (id) => {
    window.open(route("admin.penjaminan-mutu.download", id), "_blank");
};

const handleDelete = async (dokumen) => {
    const result = await confirmDelete(
        "Hapus Dokumen?",
        `Dokumen "${dokumen.title}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/penjaminan-mutu/${dokumen.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Dokumen berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus dokumen.");
            },
        });
    }
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
