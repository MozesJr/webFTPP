<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            RPS (Rencana Pembelajaran Semester)
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola rencana pembelajaran semester untuk mata
                            kuliah
                        </p>
                    </div>
                    <Link
                        href="/admin/rps/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah RPS
                    </Link>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar RPS'"
            :headers="tableHeaders"
            :items="rps.data"
            :filters="filters"
            :pagination="rps"
            :route-name="'admin.rps.index'"
            :additional-filters="additionalFilters"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <ClipboardDocumentListIcon
                            class="mx-auto h-12 w-12 text-gray-400"
                        />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada RPS
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan RPS pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/rps/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah RPS
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="rpsItem in items"
                    :key="rpsItem.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-0">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ rpsItem.mata_kuliah?.name || "-" }}
                                </div>
                                <div
                                    class="text-sm text-gray-500 flex items-center space-x-2"
                                >
                                    <span
                                        class="px-2 py-1 text-xs bg-gray-100 rounded"
                                    >
                                        {{ rpsItem.mata_kuliah?.code || "-" }}
                                    </span>
                                    <span>{{
                                        rpsItem.mata_kuliah?.kurikulum
                                            ?.program_studi?.name || "-"
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ rpsItem.dosen?.name || "-" }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                        >
                            {{ rpsItem.academic_year }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm text-gray-900">
                            {{ rpsItem.semester }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getStatusColor(rpsItem.status)"
                        >
                            {{ getStatusLabel(rpsItem.status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a
                                v-if="rpsItem.document_url"
                                :href="rpsItem.document_url"
                                target="_blank"
                                class="text-blue-600 hover:text-blue-800"
                                title="Lihat dokumen"
                            >
                                <DocumentIcon class="h-5 w-5" />
                            </a>
                            <span
                                v-else
                                class="text-gray-400"
                                title="Tidak ada dokumen"
                            >
                                <DocumentIcon class="h-5 w-5" />
                            </span>
                        </div>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        <div
                            v-if="
                                rpsItem.approved_by &&
                                rpsItem.status === 'approved'
                            "
                        >
                            <div class="text-xs text-green-600">
                                ✓ {{ rpsItem.approved_by }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ formatDate(rpsItem.approved_at) }}
                            </div>
                        </div>
                        <span v-else>-</span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/rps/${rpsItem.id}/edit`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(rpsItem)"
                                type="button"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
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
import { onMounted, ref, computed } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    ClipboardDocumentListIcon,
    DocumentIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";

// Props
const props = defineProps({
    rps: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    mataKuliahs: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({
            search: "",
            mata_kuliah: "",
            academic_year: "",
            semester: "",
            status: "",
        }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "mata_kuliah", label: "Mata Kuliah", align: "left" },
    { key: "dosen", label: "Dosen", align: "left" },
    { key: "academic_year", label: "Tahun Akademik", align: "left" },
    { key: "semester", label: "Semester", align: "center" },
    { key: "status", label: "Status", align: "left" },
    { key: "document", label: "Dokumen", align: "center" },
    { key: "approval", label: "Persetujuan", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Additional filters for DataTable
const additionalFilters = computed(() => [
    {
        key: "mata_kuliah",
        label: "Mata Kuliah",
        type: "select",
        options: [
            { value: "", label: "Semua Mata Kuliah" },
            ...props.mataKuliahs.map((matkul) => ({
                value: matkul.id.toString(),
                label: `${matkul.code} - ${matkul.name}`,
            })),
        ],
    },
    {
        key: "academic_year",
        label: "Tahun Akademik",
        type: "select",
        options: [
            { value: "", label: "Semua Tahun" },
            { value: "2023/2024", label: "2023/2024" },
            { value: "2024/2025", label: "2024/2025" },
            { value: "2025/2026", label: "2025/2026" },
        ],
    },
    {
        key: "semester",
        label: "Semester",
        type: "select",
        options: [
            { value: "", label: "Semua Semester" },
            { value: "Ganjil", label: "Ganjil" },
            { value: "Genap", label: "Genap" },
        ],
    },
    {
        key: "status",
        label: "Status",
        type: "select",
        options: [
            { value: "", label: "Semua Status" },
            { value: "draft", label: "Draft" },
            { value: "submitted", label: "Submitted" },
            { value: "approved", label: "Approved" },
            { value: "rejected", label: "Rejected" },
        ],
    },
]);

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const getStatusColor = (status) => {
    const colors = {
        draft: "bg-gray-100 text-gray-800",
        submitted: "bg-yellow-100 text-yellow-800",
        approved: "bg-green-100 text-green-800",
        rejected: "bg-red-100 text-red-800",
    };
    return colors[status] || "bg-gray-100 text-gray-800";
};

const getStatusLabel = (status) => {
    const labels = {
        draft: "Draft",
        submitted: "Submitted",
        approved: "Approved",
        rejected: "Rejected",
    };
    return labels[status] || status;
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const handleDelete = async (rpsItem) => {
    const result = await confirmDelete(
        "Hapus RPS?",
        `RPS untuk mata kuliah "${rpsItem.mata_kuliah?.name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.visit(`/admin/rps/${rpsItem.id}`, {
            method: "delete",
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "RPS berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus data.");
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
