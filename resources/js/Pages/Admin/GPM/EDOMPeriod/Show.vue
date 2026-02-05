<script setup>
import { ref, onMounted } from "vue";
import { Chart, registerables } from "chart.js";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Register Chart.js components
Chart.register(...registerables);

const props = defineProps({
    period: Object,
    statistics: Object,
    dailySubmissions: Array,
    departmentStats: Array,
});

const charts = ref({});

// Format date
const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};

// Get score color
const getScoreColor = (score) => {
    if (score >= 4.5) return "text-green-600";
    if (score >= 4.0) return "text-blue-600";
    if (score >= 3.5) return "text-yellow-600";
    return "text-red-600";
};

// Get completion color
const getCompletionColor = (rate) => {
    if (rate >= 80) return "bg-green-500";
    if (rate >= 60) return "bg-blue-500";
    if (rate >= 40) return "bg-yellow-500";
    return "bg-red-500";
};

// Initialize charts
onMounted(() => {
    initializeCharts();
});

const initializeCharts = () => {
    // Daily Submissions Chart
    if (props.dailySubmissions && props.dailySubmissions.length > 0) {
        const ctx = document.getElementById("dailySubmissionsChart");
        if (ctx) {
            const labels = props.dailySubmissions.map((item) =>
                new Date(item.date).toLocaleDateString("id-ID", {
                    day: "numeric",
                    month: "short",
                }),
            );
            const data = props.dailySubmissions.map((item) => item.count);

            charts.value.daily = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Submission per Hari",
                            data: data,
                            borderColor: "rgb(59, 130, 246)",
                            backgroundColor: "rgba(59, 130, 246, 0.1)",
                            tension: 0.4,
                            fill: true,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                            },
                        },
                    },
                },
            });
        }
    }

    // Department Stats Chart
    if (props.departmentStats && props.departmentStats.length > 0) {
        const ctx = document.getElementById("departmentChart");
        if (ctx) {
            const labels = props.departmentStats.map(
                (item) => item.department_name,
            );
            const data = props.departmentStats.map(
                (item) => item.average_score,
            );

            charts.value.department = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Rata-rata Skor",
                            data: data,
                            backgroundColor: "rgba(59, 130, 246, 0.8)",
                            borderColor: "rgb(59, 130, 246)",
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            ticks: {
                                stepSize: 0.5,
                            },
                        },
                    },
                },
            });
        }
    }
};

// Export results
const exportResults = (format) => {
    window.location.href = route("admin.gpm.edom-period.export", {
        period: props.period.id,
        format: format,
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
                        :href="route('admin.gpm.edom-period.index')"
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
                                {{ period.name }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ formatDate(period.start_date) }} -
                                {{ formatDate(period.end_date) }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a
                                :href="
                                    route(
                                        'admin.gpm.edom-period.lecturer-statistics',
                                        period.id,
                                    )
                                "
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
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
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                                    />
                                </svg>
                                Lihat Ranking Dosen
                            </a>
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
                                Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div
                    class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-6"
                >
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Total Submission
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div
                                                class="text-2xl font-semibold text-gray-900"
                                            >
                                                {{
                                                    statistics?.total_submissions ||
                                                    0
                                                }}
                                            </div>
                                            <span
                                                class="ml-2 text-sm text-gray-500"
                                            >
                                                /
                                                {{
                                                    statistics?.total_lecturers ||
                                                    0
                                                }}
                                            </span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Tingkat Pengisian
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div
                                                class="text-2xl font-semibold text-gray-900"
                                            >
                                                {{
                                                    statistics?.completion_rate ||
                                                    0
                                                }}%
                                            </div>
                                        </dd>
                                    </dl>
                                    <div
                                        class="mt-3 w-full bg-gray-200 rounded-full h-2"
                                    >
                                        <div
                                            :class="[
                                                'h-2 rounded-full',
                                                getCompletionColor(
                                                    statistics?.completion_rate ||
                                                        0,
                                                ),
                                            ]"
                                            :style="{
                                                width: `${statistics?.completion_rate || 0}%`,
                                            }"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Rata-rata Skor
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div
                                                :class="[
                                                    'text-2xl font-semibold',
                                                    getScoreColor(
                                                        statistics?.average_score ||
                                                            0,
                                                    ),
                                                ]"
                                            >
                                                {{
                                                    (
                                                        statistics?.average_score ||
                                                        0
                                                    ).toFixed(2)
                                                }}
                                            </div>
                                            <span
                                                class="ml-2 text-sm text-gray-500"
                                                >/ 5.0</span
                                            >
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Total Responden
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div
                                                class="text-2xl font-semibold text-gray-900"
                                            >
                                                {{
                                                    statistics?.total_students ||
                                                    0
                                                }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Daily Submissions Chart -->
                    <div
                        v-if="dailySubmissions && dailySubmissions.length > 0"
                        class="bg-white shadow rounded-lg p-6"
                    >
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Submission per Hari
                        </h3>
                        <div class="h-64">
                            <canvas id="dailySubmissionsChart"></canvas>
                        </div>
                    </div>

                    <!-- Department Stats Chart -->
                    <div
                        v-if="departmentStats && departmentStats.length > 0"
                        class="bg-white shadow rounded-lg p-6"
                    >
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Rata-rata per Program Studi
                        </h3>
                        <div class="h-64">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Department Stats Table -->
                <div
                    v-if="departmentStats && departmentStats.length > 0"
                    class="bg-white shadow rounded-lg overflow-hidden"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Statistik per Program Studi
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Program Studi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Dosen
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Submission
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Completion
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Avg. Score
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="dept in departmentStats"
                                    :key="dept.department_id"
                                    class="hover:bg-gray-50"
                                >
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                    >
                                        {{ dept.department_name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900"
                                    >
                                        {{ dept.total_lecturers }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900"
                                    >
                                        {{ dept.total_submissions }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <span
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ dept.completion_rate }}%
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <span
                                            :class="[
                                                'text-sm font-semibold',
                                                getScoreColor(
                                                    dept.average_score,
                                                ),
                                            ]"
                                        >
                                            {{ dept.average_score.toFixed(2) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
