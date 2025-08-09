<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Jadwal Kuliah
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola jadwal perkuliahan untuk semester aktif
                        </p>
                    </div>
                    <Link
                        href="/admin/jadwal-kuliah/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Jadwal
                    </Link>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Jadwal Kuliah'"
            :headers="tableHeaders"
            :items="jadwalKuliahs.data"
            :filters="filters"
            :pagination="jadwalKuliahs"
            :route-name="'admin.jadwal-kuliah.index'"
            :additional-filters="additionalFilters"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <CalendarDaysIcon
                            class="mx-auto h-12 w-12 text-gray-400"
                        />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada jadwal kuliah
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan jadwal kuliah pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/jadwal-kuliah/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Jadwal
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="jadwal in items"
                    :key="jadwal.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-0">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ jadwal.mata_kuliah?.name || "-" }}
                                </div>
                                <div
                                    class="text-sm text-gray-500 flex items-center space-x-2"
                                >
                                    <span
                                        class="px-2 py-1 text-xs bg-gray-100 rounded"
                                    >
                                        {{ jadwal.mata_kuliah?.code || "-" }}
                                    </span>
                                    <span>Kelas {{ jadwal.class_name }}</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ jadwal.dosen?.name || "-" }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                        >
                            {{ jadwal.academic_year }} {{ jadwal.semester }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getDayColor(jadwal.day)"
                        >
                            {{ jadwal.day }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                        <div class="flex flex-col">
                            <span class="font-medium">{{
                                formatTime(jadwal.start_time)
                            }}</span>
                            <span class="text-gray-500">{{
                                formatTime(jadwal.end_time)
                            }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <BuildingOfficeIcon
                                class="h-4 w-4 text-gray-400 mr-1"
                            />
                            <span class="text-sm text-gray-900">{{
                                jadwal.room
                            }}</span>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">
                                {{ jadwal.enrolled_students || 0 }}/{{
                                    jadwal.capacity
                                }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{
                                    getCapacityPercentage(
                                        jadwal.enrolled_students,
                                        jadwal.capacity
                                    )
                                }}%
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                jadwal.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{ jadwal.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/jadwal-kuliah/${jadwal.id}/edit`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(jadwal)"
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
    CalendarDaysIcon,
    BuildingOfficeIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";

// Props
const props = defineProps({
    jadwalKuliahs: {
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
            day: "",
        }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "mata_kuliah", label: "Mata Kuliah", align: "left" },
    { key: "dosen", label: "Dosen", align: "left" },
    { key: "academic_year", label: "Tahun/Semester", align: "left" },
    { key: "day", label: "Hari", align: "left" },
    { key: "time", label: "Waktu", align: "left" },
    { key: "room", label: "Ruangan", align: "left" },
    { key: "capacity", label: "Kapasitas", align: "center" },
    { key: "is_active", label: "Status", align: "left" },
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
        key: "day",
        label: "Hari",
        type: "select",
        options: [
            { value: "", label: "Semua Hari" },
            { value: "Senin", label: "Senin" },
            { value: "Selasa", label: "Selasa" },
            { value: "Rabu", label: "Rabu" },
            { value: "Kamis", label: "Kamis" },
            { value: "Jumat", label: "Jumat" },
            { value: "Sabtu", label: "Sabtu" },
        ],
    },
]);

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const getDayColor = (day) => {
    const colors = {
        Senin: "bg-red-100 text-red-800",
        Selasa: "bg-orange-100 text-orange-800",
        Rabu: "bg-yellow-100 text-yellow-800",
        Kamis: "bg-green-100 text-green-800",
        Jumat: "bg-blue-100 text-blue-800",
        Sabtu: "bg-purple-100 text-purple-800",
    };
    return colors[day] || "bg-gray-100 text-gray-800";
};

const formatTime = (time) => {
    if (!time) return "-";

    // Handle different time formats
    if (time.includes(":")) {
        return time.substring(0, 5); // Get HH:MM from HH:MM:SS
    }

    return time;
};

const getCapacityPercentage = (enrolled, capacity) => {
    if (!capacity || capacity === 0) return 0;
    return Math.round(((enrolled || 0) / capacity) * 100);
};

const handleDelete = async (jadwal) => {
    const result = await confirmDelete(
        "Hapus Jadwal Kuliah?",
        `Jadwal "${jadwal.mata_kuliah?.name}" kelas ${jadwal.class_name} akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.visit(`/admin/jadwal-kuliah/${jadwal.id}`, {
            method: "delete",
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Jadwal kuliah berhasil dihapus.");
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
