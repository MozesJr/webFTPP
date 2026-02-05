<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    period: Object,
    lecturerStats: Object, // ✅ FIX: Should be paginated object, not array
    filters: Object,
});

// Filters
const departmentFilter = ref(props.filters?.department || "");
const sortBy = ref(props.filters?.sort || "score_desc");

// Apply filters
const applyFilters = () => {
    router.get(
        route("admin.gpm.edom-period.lecturer-statistics", props.period.id),
        {
            department: departmentFilter.value,
            sort: sortBy.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

// Reset filters
const resetFilters = () => {
    departmentFilter.value = "";
    sortBy.value = "score_desc";
    router.get(
        route("admin.gpm.edom-period.lecturer-statistics", props.period.id),
        {},
        {
            preserveState: true,
        },
    );
};

// ✅ FIX: Get lecturers from pagination data
const lecturers = computed(() => props.lecturerStats?.data || []);

// Get departments from all lecturers
const departments = computed(() => {
    const depts = new Set();
    lecturers.value.forEach((lecturer) => {
        if (lecturer.lecturer?.department) {
            depts.add(lecturer.lecturer.department);
        }
    });
    return Array.from(depts).sort();
});

// Get score color
const getScoreColor = (score) => {
    if (score >= 4.5) return "text-green-600 bg-green-50";
    if (score >= 4.0) return "text-blue-600 bg-blue-50";
    if (score >= 3.5) return "text-yellow-600 bg-yellow-50";
    return "text-red-600 bg-red-50";
};

// Get ranking badge
const getRankingBadge = (rank) => {
    if (rank === 1) return "🥇";
    if (rank === 2) return "🥈";
    if (rank === 3) return "🥉";
    return `#${rank}`;
};

// Get performance label
const getPerformanceLabel = (score) => {
    if (score >= 4.5)
        return { label: "Excellent", color: "bg-green-100 text-green-800" };
    if (score >= 4.0)
        return { label: "Very Good", color: "bg-blue-100 text-blue-800" };
    if (score >= 3.5)
        return { label: "Good", color: "bg-yellow-100 text-yellow-800" };
    if (score >= 3.0)
        return { label: "Fair", color: "bg-orange-100 text-orange-800" };
    return { label: "Needs Improvement", color: "bg-red-100 text-red-800" };
};

// Export results
const exportResults = (format) => {
    window.location.href = route("admin.gpm.edom-period.export-lecturers", {
        period: props.period.id,
        format: format,
        department: departmentFilter.value,
        sort: sortBy.value,
    });
};
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <a
                        :href="route('admin.gpm.edom-period.show', period.id)"
                        class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4"
                    >
                        <svg
                            class="w-4 h-4 mr-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Kembali
                    </a>

                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">
                                Ranking Dosen
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ period.name }} -
                                {{ lecturerStats.total || 0 }} dosen
                            </p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <button
                                @click="exportResults('excel')"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                            >
                                <svg
                                    class="-ml-1 mr-2 h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                    />
                                </svg>
                                Export Excel
                            </button>
                            <button
                                @click="exportResults('pdf')"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                            >
                                <svg
                                    class="-ml-1 mr-2 h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                    />
                                </svg>
                                Export PDF
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Program Studi
                            </label>
                            <select
                                v-model="departmentFilter"
                                @change="applyFilters"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                                <option value="">Semua Program Studi</option>
                                <option
                                    v-for="dept in departments"
                                    :key="dept"
                                    :value="dept"
                                >
                                    {{ dept }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Urutkan
                            </label>
                            <select
                                v-model="sortBy"
                                @change="applyFilters"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                                <option value="score_desc">
                                    Skor Tertinggi
                                </option>
                                <option value="score_asc">Skor Terendah</option>
                                <option value="name_asc">Nama (A-Z)</option>
                                <option value="responses_desc">
                                    Respons Terbanyak
                                </option>
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

                <!-- Top 3 Lecturers -->
                <div
                    v-if="lecturers.length > 0"
                    class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-6"
                >
                    <div
                        v-for="(stat, index) in lecturers.slice(0, 3)"
                        :key="stat.lecturer_id"
                        class="bg-white overflow-hidden shadow rounded-lg border-2"
                        :class="{
                            'border-yellow-400': index === 0,
                            'border-gray-400': index === 1,
                            'border-orange-400': index === 2,
                        }"
                    >
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="text-4xl mr-3">
                                    {{ getRankingBadge(index + 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div
                                        class="text-sm font-medium text-gray-900 truncate"
                                    >
                                        {{ stat.lecturer?.name || "Unknown" }}
                                    </div>
                                    <div class="text-xs text-gray-500 truncate">
                                        {{ stat.lecturer?.department || "-" }}
                                    </div>
                                    <div class="mt-2 flex items-baseline">
                                        <div
                                            :class="[
                                                'text-2xl font-bold',
                                                getScoreColor(
                                                    stat.average_score,
                                                ).split(' ')[0],
                                            ]"
                                        >
                                            {{ stat.average_score.toFixed(2) }}
                                        </div>
                                        <span
                                            class="ml-2 text-sm text-gray-500"
                                        >
                                            / 5.0
                                        </span>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ stat.submission_count }} respons
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lecturers Table -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20"
                                    >
                                        Rank
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Nama Dosen
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Program Studi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Respons
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Avg. Score
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Performance
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="(stat, index) in lecturers"
                                    :key="stat.lecturer_id"
                                    class="hover:bg-gray-50"
                                    :class="{ 'bg-yellow-50': index < 3 }"
                                >
                                    <!-- Rank -->
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <span class="text-2xl">
                                            {{
                                                getRankingBadge(
                                                    lecturerStats.from + index,
                                                )
                                            }}
                                        </span>
                                    </td>

                                    <!-- Name -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div
                                                    class="text-sm font-medium text-gray-900"
                                                >
                                                    {{
                                                        stat.lecturer?.name ||
                                                        "Unknown"
                                                    }}
                                                </div>
                                                <div
                                                    class="text-sm text-gray-500"
                                                >
                                                    {{
                                                        stat.lecturer?.nip ||
                                                        "-"
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Department -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{
                                                stat.lecturer?.department || "-"
                                            }}
                                        </div>
                                    </td>

                                    <!-- Responses -->
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ stat.submission_count }}
                                        </div>
                                    </td>

                                    <!-- Average Score -->
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <span
                                            :class="[
                                                'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold',
                                                getScoreColor(
                                                    stat.average_score,
                                                ),
                                            ]"
                                        >
                                            {{ stat.average_score.toFixed(2) }}
                                        </span>
                                    </td>

                                    <!-- Performance -->
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <span
                                            :class="[
                                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                getPerformanceLabel(
                                                    stat.average_score,
                                                ).color,
                                            ]"
                                        >
                                            {{
                                                getPerformanceLabel(
                                                    stat.average_score,
                                                ).label
                                            }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <a
                                            :href="
                                                route(
                                                    'admin.gpm.edom-period.lecturer-submissions',
                                                    {
                                                        edomPeriod: period.id,
                                                        lecturer_id:
                                                            stat.lecturer_id,
                                                    },
                                                )
                                            "
                                            class="text-blue-600 hover:text-blue-900 text-sm font-medium"
                                        >
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div
                        v-if="lecturers.length === 0"
                        class="text-center py-12"
                    >
                        <svg
                            class="mx-auto h-12 w-12 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                            />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            Belum ada data
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada submission untuk periode ini.
                        </p>
                    </div>
                </div>

                <!-- Pagination -->
                <div
                    v-if="lecturerStats.last_page > 1"
                    class="mt-6 flex items-center justify-between"
                >
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ lecturerStats.from }} -
                        {{ lecturerStats.to }} dari
                        {{ lecturerStats.total }} dosen
                    </div>
                    <div class="flex gap-2">
                        <a
                            href=""
                            v-for="page in lecturerStats.links"
                            :key="page.label"
                            :href="page.url"
                            v-html="page.label"
                            :class="[
                                'px-4 py-2 text-sm border rounded',
                                page.active
                                    ? 'bg-blue-600 text-white border-blue-600'
                                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50',
                                !page.url && 'opacity-50 cursor-not-allowed',
                            ]"
                        ></a>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
