<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            KHS Management
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola file KHS mahasiswa per semester
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="route('super-admin.khs.periods')"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <CalendarIcon class="w-4 h-4 mr-2" />
                            Kelola Period
                        </Link>
                        <Link
                            :href="route('super-admin.khs.bulk-upload')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <DocumentArrowUpIcon class="w-4 h-4 mr-2" />
                            Bulk Upload
                        </Link>
                        <Link
                            :href="route('super-admin.khs.upload')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PlusIcon class="w-4 h-4 mr-2" />
                            Upload KHS
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div
            v-if="statistics"
            class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6"
        >
            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <DocumentTextIcon class="h-8 w-8 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">
                            Total KHS
                        </div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ statistics.total }}
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <CheckCircleIcon class="h-8 w-8 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">
                            Berhasil Upload
                        </div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ statistics.ready }}
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <ClockIcon class="h-8 w-8 text-yellow-600" />
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">
                            Mengunggah
                        </div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ statistics.uploading }}
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <ExclamationTriangleIcon class="h-8 w-8 text-red-600" />
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">
                            Gagal Upload
                        </div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ statistics.failed }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Period Info -->
        <div
            v-if="currentPeriod"
            class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6"
        >
            <div class="flex items-center">
                <InformationCircleIcon class="h-5 w-5 text-blue-600 mr-2" />
                <div>
                    <span class="text-sm font-medium text-blue-800">
                        Period Aktif: {{ currentPeriod.display_name }}
                    </span>
                    <span v-if="statistics" class="text-sm text-blue-600 ml-4">
                        Progress: {{ statistics.percentage }}% ({{
                            statistics.ready
                        }}/{{ statistics.total_students }} mahasiswa)
                    </span>
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
                            Pencarian
                        </label>
                        <input
                            type="text"
                            v-model="searchForm.search"
                            @input="debounceSearch"
                            placeholder="Cari NIM, nama, atau filename..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Period Akademik
                        </label>
                        <select
                            v-model="searchForm.period_id"
                            @change="handleFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">Semua Period</option>
                            <option
                                v-for="period in periods"
                                :key="period.id"
                                :value="period.id"
                            >
                                {{
                                    period.display_name ??
                                    period.name ??
                                    period.semester + " " + period.academic_year
                                }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Status Upload
                        </label>
                        <select
                            v-model="searchForm.status"
                            @change="handleFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">Semua Status</option>
                            <option value="ready">Berhasil</option>
                            <option value="uploading">Mengunggah</option>
                            <option value="failed">Gagal</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button
                            @click="clearFilters"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- KHS Files Table -->
        <DataTable
            :title="'Daftar File KHS'"
            :headers="tableHeaders"
            :items="khsFiles.data"
            :filters="filters"
            :pagination="khsFiles"
            :route-name="'super-admin.khs.index'"
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
                            Belum ada file KHS
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan mengupload file KHS mahasiswa.
                        </p>
                        <div class="mt-6">
                            <Link
                                :href="route('super-admin.khs.upload')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Upload KHS
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr v-for="khs in items" :key="khs.id" class="hover:bg-gray-50">
                    <!-- Student Info -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div
                                    class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center"
                                >
                                    <AcademicCapIcon
                                        class="h-5 w-5 text-indigo-600"
                                    />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ khs.student_name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    NIM: {{ khs.student_nim }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <!-- Period -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ khs.semester_name }}
                        </div>
                    </td>

                    <!-- Filename -->
                    <td class="px-6 py-4">
                        <div
                            class="text-sm text-gray-900 truncate max-w-xs"
                            :title="khs.original_filename"
                        >
                            {{ khs.original_filename }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ khs.file_size_human }}
                        </div>
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                khs.status_badge_class,
                            ]"
                        >
                            {{ khs.status_label }}
                        </span>
                    </td>

                    <!-- Upload Info -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ khs.uploader?.name || "Unknown" }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ formatDate(khs.upload_date) }}
                        </div>
                    </td>

                    <!-- Access Count -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ khs.access_count }} kali
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ khs.last_accessed_human }}
                        </div>
                    </td>

                    <!-- Actions -->
                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <!-- View Details -->
                            <Link
                                :href="route('super-admin.khs.show', khs.id)"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            >
                                <EyeIcon class="h-4 w-4 mr-1" />
                                Detail
                            </Link>

                            <!-- Download/Preview (if ready) -->
                            <a
                                v-if="khs.can_download"
                                :href="khs.gdrive_download_url"
                                target="_blank"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <ArrowDownTrayIcon class="h-4 w-4 mr-1" />
                                Download
                            </a>

                            <!-- Retry (if failed) -->
                            <button
                                v-if="khs.upload_status === 'failed'"
                                @click="retryUpload(khs)"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                            >
                                <ArrowPathIcon class="h-4 w-4 mr-1" />
                                Retry
                            </button>

                            <!-- Delete -->
                            <button
                                @click="deleteKhs(khs)"
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
import { onMounted, ref, reactive } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    DocumentTextIcon,
    DocumentArrowUpIcon,
    CalendarIcon,
    CheckCircleIcon,
    ClockIcon,
    ExclamationTriangleIcon,
    InformationCircleIcon,
    EyeIcon,
    ArrowDownTrayIcon,
    ArrowPathIcon,
    TrashIcon,
    AcademicCapIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";
import { debounce } from "lodash";

// Props
const props = defineProps({
    khsFiles: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    periods: {
        type: Array,
        default: () => [],
    },
    currentPeriod: {
        type: Object,
        default: null,
    },
    statistics: {
        type: Object,
        default: null,
    },
    filters: {
        type: Object,
        default: () => ({
            search: "",
            period_id: "",
            status: "",
        }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "student", label: "Mahasiswa", align: "left" },
    { key: "period", label: "Period", align: "left" },
    { key: "filename", label: "File", align: "left" },
    { key: "status", label: "Status", align: "left" },
    { key: "upload_info", label: "Upload Info", align: "left" },
    { key: "access", label: "Akses", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Reactive search form
const searchForm = reactive({
    search: props.filters.search || "",
    period_id: props.filters.period_id || "",
    status: props.filters.status || "",
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Debounced search
const debounceSearch = debounce(() => {
    handleFilter();
}, 500);

// Methods
const handleFilter = () => {
    const params = {};

    if (searchForm.search) params.search = searchForm.search;
    if (searchForm.period_id) params.period_id = searchForm.period_id;
    if (searchForm.status) params.status = searchForm.status;

    router.get(route("super-admin.khs.index"), params, {
        preserveState: true,
        replace: true,
    });
};

const clearFilters = () => {
    searchForm.search = "";
    searchForm.period_id = "";
    searchForm.status = "";
    router.get(
        route("super-admin.khs.index"),
        {},
        {
            preserveState: true,
            replace: true,
        }
    );
};

const retryUpload = async (khs) => {
    const result = await confirmDelete(
        "Retry Upload?",
        `Apakah Anda yakin ingin retry upload untuk ${khs.student_name}?`
    );

    if (result.isConfirmed) {
        router.post(
            route("super-admin.khs.retry", khs.id),
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    success("Berhasil!", "File ditandai untuk retry upload.");
                },
                onError: (errors) => {
                    error("Error!", "Gagal retry upload.");
                },
            }
        );
    }
};

const deleteKhs = async (khs) => {
    const result = await confirmDelete(
        "Hapus File KHS?",
        `File KHS untuk ${khs.student_name} akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(route("super-admin.khs.destroy", khs.id), {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "File KHS berhasil dihapus.");
            },
            onError: (errors) => {
                error("Error!", "Terjadi kesalahan saat menghapus file.");
            },
        });
    }
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const handleFlashMessages = () => {
    try {
        const flash = page.props.value?.flash;
        if (flash?.message) {
            if (flash.type === "success") {
                success("Berhasil!", flash.message);
            } else if (flash.type === "warning") {
                error("Peringatan!", flash.message);
            } else if (flash.type === "error") {
                error("Error!", flash.message);
            }
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
