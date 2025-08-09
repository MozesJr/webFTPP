<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Kurikulum
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola kurikulum program studi
                        </p>
                    </div>
                    <Link
                        href="/admin/kurikulum/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Kurikulum
                    </Link>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Kurikulum'"
            :headers="tableHeaders"
            :items="kurikulums.data"
            :filters="filters"
            :pagination="kurikulums"
            :route-name="'admin.kurikulum.index'"
            :additional-filters="additionalFilters"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <BookOpenIcon class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada kurikulum
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan kurikulum pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/kurikulum/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Kurikulum
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="kurikulum in items"
                    :key="kurikulum.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-0">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ kurikulum.name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ kurikulum.program_studi?.name || "-" }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                        >
                            {{ kurikulum.academic_year }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                        {{ kurikulum.total_credits }} SKS
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                kurikulum.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{ kurikulum.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <a
                                v-if="kurikulum.document_url"
                                :href="kurikulum.document_url"
                                target="_blank"
                                class="text-blue-600 hover:text-blue-800"
                            >
                                <DocumentIcon class="h-5 w-5" />
                            </a>
                            <span v-else class="text-gray-400">
                                <DocumentIcon class="h-5 w-5" />
                            </span>
                        </div>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/kurikulum/${kurikulum.id}/edit`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(kurikulum)"
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
    BookOpenIcon,
    DocumentIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";

// Props
const props = defineProps({
    kurikulums: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    programStudis: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({ search: "", prodi: "", academic_year: "" }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "name", label: "Nama Kurikulum", align: "left" },
    { key: "academic_year", label: "Tahun Akademik", align: "left" },
    { key: "total_credits", label: "Total SKS", align: "left" },
    { key: "is_active", label: "Status", align: "left" },
    { key: "document", label: "Dokumen", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Additional filters for DataTable
const additionalFilters = computed(() => [
    {
        key: "prodi",
        label: "Program Studi",
        type: "select",
        options: [
            { value: "", label: "Semua Program Studi" },
            ...props.programStudis.map((prodi) => ({
                value: prodi.id.toString(),
                label: prodi.name,
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
]);

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const handleDelete = async (kurikulum) => {
    const result = await confirmDelete(
        "Hapus Kurikulum?",
        `Kurikulum "${kurikulum.name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.visit(`/admin/kurikulum/${kurikulum.id}`, {
            method: "delete",
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Kurikulum berhasil dihapus.");
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
