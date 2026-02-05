<script setup>
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { useSwal } from "@/Composables/useSwal";

const props = defineProps({
    periods: Object, // Laravel pagination object
    filters: Object,
});

const { showSuccess, showError, confirmDelete } = useSwal();
const page = usePage();

// Additional filters
const semesterFilter = ref(props.filters?.semester || "");
const statusFilter = ref(props.filters?.status || "");

// Table headers
const headers = [
    { key: "name", label: "Periode", align: "left" },
    { key: "semester", label: "Semester", align: "center" },
    { key: "academic_year", label: "Tahun Ajaran", align: "center" },
    { key: "submissions", label: "Submission", align: "center" },
    { key: "avg_score", label: "Rata-rata", align: "center" },
    { key: "status", label: "Status", align: "center" },
    { key: "actions", label: "Aksi", align: "center" },
];

// Apply filters
const applyFilters = () => {
    router.get(
        route("admin.gpm.edom-period.index"),
        {
            search: props.filters?.search || "",
            semester: semesterFilter.value,
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
    semesterFilter.value = "";
    statusFilter.value = "";
    router.get(
        route("admin.gpm.edom-period.index"),
        {},
        {
            preserveState: true,
        },
    );
};

// Delete period
const deletePeriod = async (period) => {
    const confirmed = await confirmDelete(
        "Hapus Periode EDOM",
        `Yakin ingin menghapus "${period.name}"? Semua data evaluasi akan ikut terhapus.`,
    );

    if (confirmed) {
        router.delete(route("admin.gpm.edom-period.destroy", period.id), {
            onSuccess: () => {
                showSuccess("Berhasil!", "Periode EDOM berhasil dihapus.");
            },
            onError: () => {
                showError(
                    "Gagal!",
                    "Terjadi kesalahan saat menghapus periode.",
                );
            },
        });
    }
};

// Toggle active status
const toggleActive = (period) => {
    router.post(
        route("admin.gpm.edom-period.toggle-active", period.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                const status = period.is_active
                    ? "dinonaktifkan"
                    : "diaktifkan";
                showSuccess("Berhasil!", `Periode berhasil ${status}.`);
            },
        },
    );
};

// Toggle publish status
const togglePublish = (period) => {
    router.post(
        route("admin.gpm.edom-period.toggle-publish", period.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                const status = period.is_published
                    ? "dipublish"
                    : "di-unpublish";
                showSuccess("Berhasil!", `Hasil evaluasi berhasil ${status}.`);
            },
        },
    );
};

// Get semester label
const getSemesterLabel = (semester) => {
    return semester === "ganjil" ? "Ganjil" : "Genap";
};

// Get semester color
const getSemesterColor = (semester) => {
    return semester === "ganjil"
        ? "bg-blue-100 text-blue-800"
        : "bg-green-100 text-green-800";
};

// Get status info
const getStatusInfo = (period) => {
    if (period.is_active) {
        return { label: "Aktif", color: "bg-green-100 text-green-800" };
    } else if (period.is_published) {
        return { label: "Published", color: "bg-purple-100 text-purple-800" };
    } else {
        return { label: "Selesai", color: "bg-gray-100 text-gray-800" };
    }
};

// Get score color
const getScoreColor = (score) => {
    if (score >= 4.5) return "text-green-600";
    if (score >= 4.0) return "text-blue-600";
    if (score >= 3.5) return "text-yellow-600";
    return "text-red-600";
};

// Show flash messages
if (page.props.flash?.success) {
    showSuccess("Berhasil!", page.props.flash.success);
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
                            Periode EDOM
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Kelola periode Evaluasi Dosen Oleh Mahasiswa
                        </p>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <a
                            :href="route('admin.gpm.edom-period.create')"
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
                            Buat Periode Baru
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Semester</label
                            >
                            <select
                                v-model="semesterFilter"
                                @change="applyFilters"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                                <option value="">Semua Semester</option>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
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
                                <option value="active">Aktif</option>
                                <option value="published">Published</option>
                                <option value="completed">Selesai</option>
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
                    title="Daftar Periode EDOM"
                    :headers="headers"
                    :items="periods.data"
                    :filters="filters"
                    :pagination="periods"
                    routeName="admin.gpm.edom-period.index"
                >
                    <template #body="{ items }">
                        <tr
                            v-for="period in items"
                            :key="period.id"
                            class="hover:bg-gray-50"
                        >
                            <!-- Name -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ period.name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{
                                        new Date(
                                            period.start_date,
                                        ).toLocaleDateString("id-ID", {
                                            day: "numeric",
                                            month: "short",
                                        })
                                    }}
                                    -
                                    {{
                                        new Date(
                                            period.end_date,
                                        ).toLocaleDateString("id-ID", {
                                            day: "numeric",
                                            month: "short",
                                            year: "numeric",
                                        })
                                    }}
                                </div>
                            </td>

                            <!-- Semester -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        getSemesterColor(period.semester),
                                    ]"
                                >
                                    {{ getSemesterLabel(period.semester) }}
                                </span>
                            </td>

                            <!-- Academic Year -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    {{ period.academic_year }}
                                </div>
                            </td>

                            <!-- Submissions -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ period.total_submissions || 0 }} /
                                    {{ period.total_lecturers || 0 }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ period.completion_rate || 0 }}% selesai
                                </div>
                            </td>

                            <!-- Average Score -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div
                                    :class="[
                                        'text-sm font-semibold',
                                        getScoreColor(period.average_score),
                                    ]"
                                >
                                    {{
                                        period.average_score
                                            ? period.average_score.toFixed(2)
                                            : "-"
                                    }}
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex flex-col gap-1 items-center">
                                    <button
                                        @click="toggleActive(period)"
                                        class="inline-flex items-center"
                                    >
                                        <span
                                            :class="[
                                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                getStatusInfo(period).color,
                                            ]"
                                        >
                                            {{ getStatusInfo(period).label }}
                                        </span>
                                    </button>
                                    <button
                                        v-if="!period.is_active"
                                        @click="togglePublish(period)"
                                        class="text-xs"
                                        :class="
                                            period.is_published
                                                ? 'text-purple-600'
                                                : 'text-gray-400'
                                        "
                                    >
                                        {{
                                            period.is_published
                                                ? "👁️ Published"
                                                : "🔒 Private"
                                        }}
                                    </button>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div
                                    class="flex items-center justify-center gap-2"
                                >
                                    <a
                                        :href="
                                            route(
                                                'admin.gpm.edom-period.show',
                                                period.id,
                                            )
                                        "
                                        class="text-green-600 hover:text-green-900"
                                        title="Lihat Statistik"
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
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                            />
                                        </svg>
                                    </a>
                                    <a
                                        :href="
                                            route(
                                                'admin.gpm.edom-period.lecturer-statistics',
                                                period.id,
                                            )
                                        "
                                        class="text-indigo-600 hover:text-indigo-900"
                                        title="Ranking Dosen"
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
                                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                                            />
                                        </svg>
                                    </a>
                                    <a
                                        :href="
                                            route(
                                                'admin.gpm.edom-period.edit',
                                                period.id,
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
                                        @click="deletePeriod(period)"
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
