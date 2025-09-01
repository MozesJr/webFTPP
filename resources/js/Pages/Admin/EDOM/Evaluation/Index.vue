<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Data Evaluasi EDOM.
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola dan review hasil evaluasi dosen oleh
                            mahasiswa
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <button
                            @click="exportData"
                            :disabled="exportLoading"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                        >
                            <ArrowDownTrayIcon class="w-4 h-4 mr-2" />
                            <span v-if="exportLoading">Exporting...</span>
                            <span v-else>Export Excel</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Cari Evaluasi
                        </label>
                        <input
                            v-model="filterForm.search"
                            type="text"
                            placeholder="NIM, nama, atau email..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @input="debounceFilter"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Kuesioner
                        </label>
                        <select
                            v-model="filterForm.questionnaire_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @change="applyFilter"
                        >
                            <option value="">Semua Kuesioner</option>
                            <option
                                v-for="questionnaire in questionnaires"
                                :key="questionnaire.id"
                                :value="questionnaire.id"
                            >
                                {{ questionnaire.title }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Program Studi
                        </label>
                        <select
                            v-model="filterForm.prodi_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @change="applyFilter"
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
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Semester Diambil
                        </label>
                        <select
                            v-model="filterForm.semester_taken"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @change="applyFilter"
                        >
                            <option value="">Semua Semester</option>
                            <option v-for="n in 13" :key="n" :value="n">
                                Semester {{ n }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <button
                        @click="resetFilter"
                        type="button"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Reset Filter
                    </button>

                    <div class="text-sm text-gray-600">
                        Menampilkan {{ evaluations.from || 0 }} -
                        {{ evaluations.to || 0 }} dari
                        {{ evaluations.total || 0 }} evaluasi
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluations Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Daftar Evaluasi
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Mahasiswa
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Kuesioner
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Program Studi
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Semester
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Dosen
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Tanggal Submit
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="evaluations.data.length === 0">
                            <td colspan="7" class="px-6 py-12 text-center">
                                <DocumentTextIcon
                                    class="mx-auto h-12 w-12 text-gray-400"
                                />
                                <h3
                                    class="mt-4 text-lg font-medium text-gray-900"
                                >
                                    Belum ada evaluasi
                                </h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    Evaluasi akan muncul setelah mahasiswa
                                    mengisi kuesioner.
                                </p>
                            </td>
                        </tr>

                        <tr
                            v-for="evaluation in evaluations.data"
                            :key="evaluation.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4">
                                <div>
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ evaluation.student_name || "N/A" }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ evaluation.student_nim }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ evaluation.student_email }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ evaluation.questionnaire?.title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ evaluation.questionnaire?.semester }}
                                        {{
                                            evaluation.questionnaire
                                                ?.academic_year
                                        }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    {{
                                        evaluation.questionnaire?.program_studi
                                            ?.name || "N/A"
                                    }}
                                </span>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                Semester {{ evaluation.semester_taken }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="text-sm text-gray-900">
                                        <span class="font-medium">1.</span>
                                        {{
                                            evaluation.lecturer1?.name || "N/A"
                                        }}
                                        <span class="text-xs text-gray-500 ml-2"
                                            >({{
                                                evaluation.attendance_lecturer_1
                                            }})</span
                                        >
                                    </div>
                                    <div
                                        v-if="evaluation.lecturer_count === 2"
                                        class="text-sm text-gray-900"
                                    >
                                        <span class="font-medium">2.</span>
                                        {{
                                            evaluation.lecturer2?.name || "N/A"
                                        }}
                                        <span class="text-xs text-gray-500 ml-2"
                                            >({{
                                                evaluation.attendance_lecturer_2
                                            }})</span
                                        >
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ evaluation.lecturer_count }} dosen
                                    </div>
                                </div>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ formatDateTime(evaluation.submitted_at) }}
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <div
                                    class="flex items-center justify-end space-x-2"
                                >
                                    <!-- View Button -->
                                    <Link
                                        :href="`/admin/edom/evaluation/${evaluation.id}`"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-indigo-600 hover:text-indigo-900"
                                        title="Lihat Detail"
                                    >
                                        <EyeIcon class="h-4 w-4" />
                                    </Link>

                                    <!-- Delete Button -->
                                    <button
                                        @click="handleDelete(evaluation)"
                                        type="button"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-red-600 hover:text-red-900"
                                        title="Hapus"
                                    >
                                        <TrashIcon class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                v-if="evaluations.links && evaluations.links.length > 3"
                class="px-6 py-4 border-t border-gray-200"
            >
                <nav class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <Link
                            v-if="evaluations.prev_page_url"
                            :href="evaluations.prev_page_url"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Previous
                        </Link>
                        <Link
                            v-if="evaluations.next_page_url"
                            :href="evaluations.next_page_url"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Next
                        </Link>
                    </div>
                    <div
                        class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{
                                    evaluations.from
                                }}</span>
                                to
                                <span class="font-medium">{{
                                    evaluations.to
                                }}</span>
                                of
                                <span class="font-medium">{{
                                    evaluations.total
                                }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            <nav
                                class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination"
                            >
                                <Link
                                    v-for="(link, index) in evaluations.links"
                                    :key="index"
                                    :href="link.url"
                                    v-html="link.label"
                                    :class="[
                                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                        link.active
                                            ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                        index === 0 ? 'rounded-l-md' : '',
                                        index === evaluations.links.length - 1
                                            ? 'rounded-r-md'
                                            : '',
                                    ]"
                                />
                            </nav>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    EyeIcon,
    TrashIcon,
    DocumentTextIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/outline";
import { debounce } from "lodash";

// Props
const props = defineProps({
    evaluations: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    questionnaires: {
        type: Array,
        default: () => [],
    },
    programStudis: {
        type: Array,
        default: () => [],
    },
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Reactive data
const filterForm = ref({
    search: props.filters.search || "",
    questionnaire_id: props.filters.questionnaire_id || "",
    prodi_id: props.filters.prodi_id || "",
    semester_taken: props.filters.semester_taken || "",
});

const exportLoading = ref(false);

// Methods
const applyFilter = () => {
    router.get(route("admin.edom.evaluation.index"), filterForm.value, {
        preserveState: true,
        replace: true,
    });
};

const debounceFilter = debounce(() => {
    applyFilter();
}, 500);

const resetFilter = () => {
    filterForm.value = {
        search: "",
        questionnaire_id: "",
        prodi_id: "",
        semester_taken: "",
    };
    applyFilter();
};

const exportData = async () => {
    exportLoading.value = true;

    try {
        const params = new URLSearchParams(filterForm.value);
        const response = await fetch(
            `/admin/edom/evaluation/export?${params.toString()}`,
            {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            }
        );

        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.style.display = "none";
            a.href = url;
            a.download = `evaluasi-dosen-${
                new Date().toISOString().split("T")[0]
            }.xlsx`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);

            success("Berhasil!", "Data evaluasi berhasil diexport.");
        } else {
            error("Error!", "Gagal mengexport data evaluasi.");
        }
    } catch (err) {
        console.error("Export error:", err);
        error("Error!", "Terjadi kesalahan saat mengexport data.");
    } finally {
        exportLoading.value = false;
    }
};

const handleDelete = async (evaluation) => {
    const result = await confirmDelete(
        "Hapus Evaluasi?",
        `Evaluasi dari mahasiswa "${
            evaluation.student_name || evaluation.student_nim
        }" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/edom/evaluation/${evaluation.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Evaluasi berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus evaluasi.");
            },
        });
    }
};

const formatDateTime = (datetime) => {
    return new Date(datetime).toLocaleString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
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
