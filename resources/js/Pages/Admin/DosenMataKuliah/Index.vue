<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Penugasan Dosen Mata Kuliah
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola penugasan dosen untuk mata kuliah
                        </p>
                    </div>
                    <Link
                        href="/admin/dosen-mata-kuliah/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Penugasan
                    </Link>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Penugasan Dosen'"
            :headers="tableHeaders"
            :items="dosenMataKuliahs.data"
            :filters="filters"
            :pagination="dosenMataKuliahs"
            :route-name="'admin.dosen-mata-kuliah.index'"
            :additional-filters="additionalFilters"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <UserGroupIcon
                            class="mx-auto h-12 w-12 text-gray-400"
                        />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada penugasan dosen
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan penugasan dosen pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/dosen-mata-kuliah/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Penugasan
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="assignment in items"
                    :key="assignment.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img
                                    v-if="assignment.dosen?.photo_url"
                                    :src="
                                        getPhotoUrl(assignment.dosen.photo_url)
                                    "
                                    :alt="assignment.dosen.name"
                                    class="h-10 w-10 rounded-full object-cover"
                                />
                                <div
                                    v-else
                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center"
                                >
                                    <UserIcon class="h-6 w-6 text-gray-400" />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ assignment.dosen?.name || "-" }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ assignment.dosen?.email || "-" }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <div class="font-medium">
                                {{ assignment.mata_kuliah?.name || "-" }}
                            </div>
                            <div
                                class="text-gray-500 flex items-center space-x-2"
                            >
                                <span
                                    class="px-2 py-1 text-xs bg-gray-100 rounded"
                                >
                                    {{ assignment.mata_kuliah?.code || "-" }}
                                </span>
                                <span
                                    >{{
                                        assignment.mata_kuliah?.credits || 0
                                    }}
                                    SKS</span
                                >
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{
                                assignment.mata_kuliah?.kurikulum?.program_studi
                                    ?.name || "-"
                            }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getRoleColor(assignment.role)"
                        >
                            {{ assignment.role }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                        >
                            {{ assignment.academic_year }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                assignment.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{ assignment.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        {{ formatDate(assignment.created_at) }}
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/dosen-mata-kuliah/${assignment.id}/edit`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(assignment)"
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
    UserGroupIcon,
    UserIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";

// Props
const props = defineProps({
    dosenMataKuliahs: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    mataKuliahs: {
        type: Array,
        default: () => [],
    },
    dosens: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({
            search: "",
            mata_kuliah: "",
            dosen: "",
            academic_year: "",
            role: "",
        }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "dosen", label: "Dosen", align: "left" },
    { key: "mata_kuliah", label: "Mata Kuliah", align: "left" },
    { key: "prodi", label: "Program Studi", align: "left" },
    { key: "role", label: "Role", align: "left" },
    { key: "academic_year", label: "Tahun Akademik", align: "left" },
    { key: "is_active", label: "Status", align: "left" },
    { key: "created_at", label: "Dibuat", align: "left" },
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
        key: "dosen",
        label: "Dosen",
        type: "select",
        options: [
            { value: "", label: "Semua Dosen" },
            ...props.dosens.map((dosen) => ({
                value: dosen.id.toString(),
                label: dosen.name,
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
        key: "role",
        label: "Role",
        type: "select",
        options: [
            { value: "", label: "Semua Role" },
            { value: "Koordinator", label: "Koordinator" },
            { value: "Pengampu", label: "Pengampu" },
            { value: "Asisten", label: "Asisten" },
        ],
    },
]);

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const getRoleColor = (role) => {
    const colors = {
        Koordinator: "bg-purple-100 text-purple-800",
        Pengampu: "bg-blue-100 text-blue-800",
        Asisten: "bg-green-100 text-green-800",
    };
    return colors[role] || "bg-gray-100 text-gray-800";
};

const getPhotoUrl = (photoPath) => {
    if (!photoPath) return null;
    if (photoPath.startsWith("http")) return photoPath;
    return photoPath.startsWith("storage/")
        ? `/${photoPath}`
        : `/storage/${photoPath}`;
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const handleDelete = async (assignment) => {
    const result = await confirmDelete(
        "Hapus Penugasan Dosen?",
        `Penugasan "${assignment.dosen?.name}" untuk mata kuliah "${assignment.mata_kuliah?.name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.visit(`/admin/dosen-mata-kuliah/${assignment.id}`, {
            method: "delete",
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Penugasan dosen berhasil dihapus.");
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
