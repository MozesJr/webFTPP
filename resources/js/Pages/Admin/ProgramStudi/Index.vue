<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Program Studi
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola program studi fakultas
                        </p>
                    </div>
                    <Link
                        href="/admin/program-studi/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Program Studi
                    </Link>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Program Studi'"
            :headers="tableHeaders"
            :items="programStudis.data"
            :filters="filters"
            :pagination="programStudis"
            :route-name="'admin.program-studi.index'"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <AcademicCapIcon
                            class="mx-auto h-12 w-12 text-gray-400"
                        />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada program studi
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan program studi pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/program-studi/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Program Studi
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="prodi in items"
                    :key="prodi.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img
                                    v-if="prodi.image_url"
                                    :src="`/${prodi.image_url}`"
                                    :alt="prodi.name"
                                    class="h-10 w-10 rounded-lg object-cover"
                                />
                                <div
                                    v-else
                                    class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center"
                                >
                                    <AcademicCapIcon
                                        class="h-5 w-5 text-gray-400"
                                    />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ prodi.name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ prodi.head_of_program || "-" }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                        >
                            {{ prodi.code }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                        >
                            {{ prodi.degree_level }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                prodi.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{ prodi.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/program-studi/${prodi.id}/edit`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 mr-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                    />
                                </svg>
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(prodi)"
                                type="button"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 mr-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-9H8m.625-2.006a2 2 0 011.995-1.858h3.83c1.24 0 2.278 1.134 2.278 2.535V7H8v-.994z"
                                    />
                                </svg>
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
import { onMounted, ref } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import { PlusIcon, AcademicCapIcon } from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue"; // Import DataTable component

// Props
const props = defineProps({
    programStudis: {
        type: Object, // Inertia pagination object
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({ search: "" }), // Add search to filters
    },
});

// Table Headers for DataTable component
const tableHeaders = ref([
    { key: "name", label: "Nama", align: "left" },
    { key: "code", label: "Kode", align: "left" },
    { key: "degree_level", label: "Jenjang", align: "left" },
    { key: "is_active", label: "Status", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const handleDelete = async (prodi) => {
    const result = await confirmDelete(
        "Hapus Program Studi?",
        `Program Studi "${prodi.name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/program-studi/${prodi.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Program Studi berhasil dihapus.");
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
