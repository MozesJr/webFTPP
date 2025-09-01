<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Kuesioner EDOM
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola kuesioner evaluasi dosen oleh mahasiswa
                        </p>
                    </div>
                    <Link
                        href="/admin/edom/questionnaire/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Buat Kuesioner
                    </Link>
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
                            Cari Kuesioner
                        </label>
                        <input
                            v-model="filterForm.search"
                            type="text"
                            placeholder="Judul atau tahun akademik..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @input="debounceFilter"
                        />
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
                            Status
                        </label>
                        <select
                            v-model="filterForm.is_active"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @change="applyFilter"
                        >
                            <option value="">Semua Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button
                            @click="resetFilter"
                            type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questionnaires Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Daftar Kuesioner ({{ questionnaires.total }})
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
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
                                Periode
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Pertanyaan
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Responden
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="questionnaires.data.length === 0">
                            <td colspan="7" class="px-6 py-12 text-center">
                                <DocumentTextIcon
                                    class="mx-auto h-12 w-12 text-gray-400"
                                />
                                <h3
                                    class="mt-4 text-lg font-medium text-gray-900"
                                >
                                    Belum ada kuesioner
                                </h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    Mulai dengan membuat kuesioner EDOM pertama.
                                </p>
                                <div class="mt-6">
                                    <Link
                                        href="/admin/edom/questionnaire/create"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        <PlusIcon class="w-4 h-4 mr-2" />
                                        Buat Kuesioner
                                    </Link>
                                </div>
                            </td>
                        </tr>

                        <tr
                            v-for="questionnaire in questionnaires.data"
                            :key="questionnaire.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4">
                                <div>
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ questionnaire.title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ questionnaire.description || "-" }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    {{
                                        questionnaire.program_studi?.name || "-"
                                    }}
                                </span>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                <div>{{ questionnaire.semester }}</div>
                                <div class="text-gray-500">
                                    {{ questionnaire.academic_year }}
                                </div>
                                <div
                                    v-if="
                                        questionnaire.start_date ||
                                        questionnaire.end_date
                                    "
                                    class="text-xs text-gray-400 mt-1"
                                >
                                    {{
                                        formatDateRange(
                                            questionnaire.start_date,
                                            questionnaire.end_date
                                        )
                                    }}
                                </div>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ questionnaire.total_questions || 0 }}
                                pertanyaan
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <UsersIcon
                                        class="h-4 w-4 text-gray-400 mr-1"
                                    />
                                    <span class="text-sm text-gray-900">
                                        {{
                                            questionnaire.submission_count || 0
                                        }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        questionnaire.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800',
                                    ]"
                                >
                                    {{
                                        questionnaire.is_active
                                            ? "Aktif"
                                            : "Tidak Aktif"
                                    }}
                                </span>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <div
                                    class="flex items-center justify-end space-x-2"
                                >
                                    <!-- View Button -->
                                    <Link
                                        :href="`/admin/edom/questionnaire/${questionnaire.id}`"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-indigo-600 hover:text-indigo-900"
                                        title="Lihat Detail"
                                    >
                                        <EyeIcon class="h-4 w-4" />
                                    </Link>

                                    <!-- Edit Button -->
                                    <Link
                                        :href="`/admin/edom/questionnaire/${questionnaire.id}/edit`"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-indigo-600 hover:text-indigo-900"
                                        title="Edit"
                                    >
                                        <PencilIcon class="h-4 w-4" />
                                    </Link>

                                    <!-- Toggle Active Button -->
                                    <button
                                        @click="toggleActive(questionnaire)"
                                        type="button"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-yellow-600 hover:text-yellow-900"
                                        :title="
                                            questionnaire.is_active
                                                ? 'Nonaktifkan'
                                                : 'Aktifkan'
                                        "
                                    >
                                        <component
                                            :is="
                                                questionnaire.is_active
                                                    ? PauseIcon
                                                    : PlayIcon
                                            "
                                            class="h-4 w-4"
                                        />
                                    </button>

                                    <!-- Duplicate Button -->
                                    <button
                                        @click="
                                            duplicateQuestionnaire(
                                                questionnaire
                                            )
                                        "
                                        type="button"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-green-600 hover:text-green-900"
                                        title="Duplikasi"
                                    >
                                        <DocumentDuplicateIcon
                                            class="h-4 w-4"
                                        />
                                    </button>

                                    <!-- Delete Button -->
                                    <button
                                        @click="handleDelete(questionnaire)"
                                        type="button"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded text-red-600 hover:text-red-900"
                                        title="Hapus"
                                        :disabled="
                                            questionnaire.submission_count > 0
                                        "
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
                v-if="questionnaires.links && questionnaires.links.length > 3"
                class="px-6 py-4 border-t border-gray-200"
            >
                <nav class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <Link
                            v-if="questionnaires.prev_page_url"
                            :href="questionnaires.prev_page_url"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Previous
                        </Link>
                        <Link
                            v-if="questionnaires.next_page_url"
                            :href="questionnaires.next_page_url"
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
                                    questionnaires.from
                                }}</span>
                                to
                                <span class="font-medium">{{
                                    questionnaires.to
                                }}</span>
                                of
                                <span class="font-medium">{{
                                    questionnaires.total
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
                                    v-for="(
                                        link, index
                                    ) in questionnaires.links"
                                    :key="index"
                                    :href="link.url"
                                    v-html="link.label"
                                    :class="[
                                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                        link.active
                                            ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                        index === 0 ? 'rounded-l-md' : '',
                                        index ===
                                        questionnaires.links.length - 1
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
import { ref, computed, onMounted } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
    DocumentTextIcon,
    UsersIcon,
    DocumentDuplicateIcon,
    PauseIcon,
    PlayIcon,
} from "@heroicons/vue/24/outline";
import { debounce } from "lodash";

// Props
const props = defineProps({
    questionnaires: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({}),
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
    prodi_id: props.filters.prodi_id || "",
    is_active: props.filters.is_active || "",
});

// Methods
const applyFilter = () => {
    router.get(route("admin.edom.questionnaire.index"), filterForm.value, {
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
        prodi_id: "",
        is_active: "",
    };
    applyFilter();
};

const handleDelete = async (questionnaire) => {
    if (questionnaire.submission_count > 0) {
        error(
            "Error!",
            "Tidak dapat menghapus kuesioner yang sudah memiliki respons."
        );
        return;
    }

    const result = await confirmDelete(
        "Hapus Kuesioner?",
        `Kuesioner "${questionnaire.title}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/edom/questionnaire/${questionnaire.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Kuesioner berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus kuesioner.");
            },
        });
    }
};

const toggleActive = async (questionnaire) => {
    const action = questionnaire.is_active ? "nonaktifkan" : "aktifkan";
    const result = await confirmDelete(
        `${action.charAt(0).toUpperCase() + action.slice(1)} Kuesioner?`,
        `Kuesioner "${questionnaire.title}" akan di${action}.`
    );

    if (result.isConfirmed) {
        router.patch(
            `/admin/edom/questionnaire/${questionnaire.id}/toggle-active`,
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    success("Berhasil!", `Kuesioner berhasil di${action}.`);
                },
                onError: () => {
                    error(
                        "Error!",
                        `Terjadi kesalahan saat ${action} kuesioner.`
                    );
                },
            }
        );
    }
};

const duplicateQuestionnaire = async (questionnaire) => {
    const result = await confirmDelete(
        "Duplikasi Kuesioner?",
        `Kuesioner "${questionnaire.title}" akan diduplikasi.`
    );

    if (result.isConfirmed) {
        router.post(
            `/admin/edom/questionnaire/${questionnaire.id}/duplicate`,
            {},
            {
                onSuccess: () => {
                    success("Berhasil!", "Kuesioner berhasil diduplikasi.");
                },
                onError: () => {
                    error(
                        "Error!",
                        "Terjadi kesalahan saat menduplikasi kuesioner."
                    );
                },
            }
        );
    }
};

const formatDateRange = (startDate, endDate) => {
    if (!startDate && !endDate) return "";

    const formatDate = (date) => {
        return new Date(date).toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "short",
            year: "numeric",
        });
    };

    if (startDate && endDate) {
        return `${formatDate(startDate)} - ${formatDate(endDate)}`;
    } else if (startDate) {
        return `Mulai ${formatDate(startDate)}`;
    } else {
        return `Sampai ${formatDate(endDate)}`;
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
