<script setup>
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { useSwal } from "@/Composables/useSwal";

const props = defineProps({
    surveys: Object, // Laravel pagination object
    filters: Object,
});

const { success, error, confirmDelete } = useSwal();
const page = usePage();

// Additional filters
const targetFilter = ref(props.filters?.target || "");
const statusFilter = ref(props.filters?.status || "");

// Table headers
const headers = [
    { key: "title", label: "Judul Survey", align: "left" },
    { key: "target_respondent", label: "Target", align: "center" },
    { key: "period", label: "Periode", align: "center" },
    { key: "questions", label: "Pertanyaan", align: "center" },
    { key: "responses", label: "Respons", align: "center" },
    { key: "status", label: "Status", align: "center" },
    { key: "actions", label: "Aksi", align: "center" },
];

// Apply filters
const applyFilters = () => {
    router.get(
        route("admin.gpm.survey.index"),
        {
            search: props.filters?.search || "",
            target: targetFilter.value,
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
    targetFilter.value = "";
    statusFilter.value = "";
    router.get(
        route("admin.gpm.survey.index"),
        {},
        {
            preserveState: true,
        },
    );
};

// Delete survey
const deleteSurvey = async (survey) => {
    const confirmed = await confirmDelete(
        "Hapus Survey",
        `Yakin ingin menghapus "${survey.title}"? Semua respons akan ikut terhapus.`,
    );

    if (confirmed) {
        router.delete(route("admin.gpm.survey.destroy", survey.id), {
            onSuccess: () => {
                success("Berhasil!", "Survey berhasil dihapus.");
            },
            onError: () => {
                showError("Gagal!", "Terjadi kesalahan saat menghapus survey.");
            },
        });
    }
};

// Toggle active status
const toggleActive = (survey) => {
    router.post(
        route("admin.gpm.survey.toggle-active", survey.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                const status = survey.is_active
                    ? "diaktifkan"
                    : "dinonaktifkan";
                success("Berhasil!", `Survey berhasil ${status}.`);
            },
        },
    );
};

// Get target label
const getTargetLabel = (target) => {
    const labels = {
        mahasiswa: "Mahasiswa",
        dosen: "Dosen",
        alumni: "Alumni",
        stakeholder: "Stakeholder",
    };
    return labels[target] || target;
};

// Get status badge
const getStatusBadge = (survey) => {
    if (survey.status === "running") {
        return { label: "Berjalan", color: "bg-green-100 text-green-800" };
    } else if (survey.status === "scheduled") {
        return { label: "Terjadwal", color: "bg-blue-100 text-blue-800" };
    } else if (survey.status === "ended") {
        return { label: "Selesai", color: "bg-gray-100 text-gray-800" };
    } else {
        return { label: "Draft", color: "bg-yellow-100 text-yellow-800" };
    }
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
                            Survey Kepuasan
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Kelola survey kepuasan stakeholder
                        </p>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <a
                            :href="route('admin.gpm.survey.create')"
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
                            Buat Survey
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Target Responden</label
                            >
                            <select
                                v-model="targetFilter"
                                @change="applyFilters"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                                <option value="">Semua Target</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="alumni">Alumni</option>
                                <option value="stakeholder">Stakeholder</option>
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
                                <option value="running">Berjalan</option>
                                <option value="scheduled">Terjadwal</option>
                                <option value="ended">Selesai</option>
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
                    title="Daftar Survey"
                    :headers="headers"
                    :items="surveys.data"
                    :filters="filters"
                    :pagination="surveys"
                    routeName="admin.gpm.survey.index"
                >
                    <template #body="{ items }">
                        <tr
                            v-for="survey in items"
                            :key="survey.id"
                            class="hover:bg-gray-50"
                        >
                            <!-- Title -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ survey.title }}
                                </div>
                                <div
                                    v-if="survey.description"
                                    class="text-sm text-gray-500 truncate max-w-md"
                                >
                                    {{ survey.description }}
                                </div>
                            </td>

                            <!-- Target -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800"
                                >
                                    {{
                                        getTargetLabel(survey.target_respondent)
                                    }}
                                </span>
                            </td>

                            <!-- Period -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    {{
                                        new Date(
                                            survey.start_date,
                                        ).toLocaleDateString("id-ID", {
                                            day: "numeric",
                                            month: "short",
                                        })
                                    }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    s/d
                                    {{
                                        new Date(
                                            survey.end_date,
                                        ).toLocaleDateString("id-ID", {
                                            day: "numeric",
                                            month: "short",
                                            year: "numeric",
                                        })
                                    }}
                                </div>
                            </td>

                            <!-- Questions Count -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    {{ survey.question_count || 0 }}
                                </div>
                            </td>

                            <!-- Responses -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    {{ survey.total_responses || 0 }}
                                </div>
                                <div
                                    v-if="survey.completion_percentage"
                                    class="text-xs text-gray-500"
                                >
                                    {{ survey.completion_percentage }}%
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button
                                    @click="toggleActive(survey)"
                                    class="inline-flex items-center"
                                >
                                    <span
                                        :class="[
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            getStatusBadge(survey).color,
                                        ]"
                                    >
                                        {{ getStatusBadge(survey).label }}
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
                                                'admin.gpm.survey.show',
                                                survey.id,
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
                                                'admin.gpm.survey.results',
                                                survey.id,
                                            )
                                        "
                                        class="text-purple-600 hover:text-purple-900"
                                        title="Hasil"
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
                                                'admin.gpm.survey.edit',
                                                survey.id,
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
                                        @click="deleteSurvey(survey)"
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
