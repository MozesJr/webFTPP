<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Mata Kuliah
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola mata kuliah dalam kurikulum
                        </p>
                    </div>
                    <Link
                        href="/admin/mata-kuliah/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Mata Kuliah
                    </Link>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Mata Kuliah'"
            :headers="tableHeaders"
            :items="mataKuliahs.data"
            :filters="filters"
            :pagination="mataKuliahs"
            :route-name="'admin.mata-kuliah.index'"
            :additional-filters="additionalFilters"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <BookmarkIcon class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada mata kuliah
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan mata kuliah pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/mata-kuliah/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Mata Kuliah
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="matkul in items"
                    :key="matkul.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-0">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ matkul.name }}
                                </div>
                                <div
                                    class="text-sm text-gray-500 flex items-center space-x-2"
                                >
                                    <span
                                        class="px-2 py-1 text-xs bg-gray-100 rounded"
                                    >
                                        {{ matkul.code }}
                                    </span>
                                    <span>{{
                                        matkul.kurikulum?.program_studi?.name ||
                                        "-"
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                        >
                            {{ matkul.kurikulum?.name || "-" }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm font-medium text-gray-900">
                            {{ matkul.credits }} SKS
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="text-sm text-gray-900">
                            Semester {{ matkul.semester }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getCategoryColor(matkul.category)"
                        >
                            {{ matkul.category }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div
                            v-if="
                                matkul.prerequisite &&
                                matkul.prerequisite.length > 0
                            "
                            class="flex flex-wrap gap-1"
                        >
                            <span
                                v-for="prereq in matkul.prerequisite.slice(
                                    0,
                                    2
                                )"
                                :key="prereq"
                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800"
                            >
                                {{ prereq }}
                            </span>
                            <span
                                v-if="matkul.prerequisite.length > 2"
                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600"
                            >
                                +{{ matkul.prerequisite.length - 2 }}
                            </span>
                        </div>
                        <span v-else class="text-sm text-gray-400">-</span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                matkul.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{ matkul.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/mata-kuliah/${matkul.id}/edit`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(matkul)"
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
    BookmarkIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";

// Props
const props = defineProps({
    mataKuliahs: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    kurikulums: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({
            search: "",
            kurikulum: "",
            semester: "",
            category: "",
        }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "name", label: "Nama Mata Kuliah", align: "left" },
    { key: "kurikulum", label: "Kurikulum", align: "left" },
    { key: "credits", label: "SKS", align: "center" },
    { key: "semester", label: "Semester", align: "center" },
    { key: "category", label: "Kategori", align: "left" },
    { key: "prerequisite", label: "Prasyarat", align: "left" },
    { key: "is_active", label: "Status", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Additional filters for DataTable
const additionalFilters = computed(() => [
    {
        key: "kurikulum",
        label: "Kurikulum",
        type: "select",
        options: [
            { value: "", label: "Semua Kurikulum" },
            ...props.kurikulums.map((kurikulum) => ({
                value: kurikulum.id.toString(),
                label: `${kurikulum.name} (${
                    kurikulum.program_studi?.name || "N/A"
                })`,
            })),
        ],
    },
    {
        key: "semester",
        label: "Semester",
        type: "select",
        options: [
            { value: "", label: "Semua Semester" },
            ...Array.from({ length: 8 }, (_, i) => ({
                value: (i + 1).toString(),
                label: `Semester ${i + 1}`,
            })),
        ],
    },
    {
        key: "category",
        label: "Kategori",
        type: "select",
        options: [
            { value: "", label: "Semua Kategori" },
            { value: "Wajib", label: "Wajib" },
            { value: "Pilihan", label: "Pilihan" },
            { value: "MKWU", label: "MKWU" },
            { value: "MKK", label: "MKK" },
            { value: "MPB", label: "MPB" },
            { value: "MKB", label: "MKB" },
            { value: "MPK", label: "MPK" },
        ],
    },
]);

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const getCategoryColor = (category) => {
    const colors = {
        Wajib: "bg-red-100 text-red-800",
        Pilihan: "bg-blue-100 text-blue-800",
        MKWU: "bg-green-100 text-green-800",
        MKK: "bg-purple-100 text-purple-800",
        MPB: "bg-yellow-100 text-yellow-800",
        MKB: "bg-pink-100 text-pink-800",
        MPK: "bg-indigo-100 text-indigo-800",
    };
    return colors[category] || "bg-gray-100 text-gray-800";
};

const handleDelete = async (matkul) => {
    const result = await confirmDelete(
        "Hapus Mata Kuliah?",
        `Mata kuliah "${matkul.name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.visit(`/admin/mata-kuliah/${matkul.id}`, {
            method: "delete",
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Mata kuliah berhasil dihapus.");
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
