<script setup>
import { ref, onMounted } from "vue";
import { Chart, registerables } from "chart.js";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Register Chart.js components
Chart.register(...registerables);

const props = defineProps({
    period: Object,
    lecturer: Object,
    submissions: Array,
    questionStats: Array,
    overallStats: Object,
});

const charts = ref({});

// Get score color
const getScoreColor = (score) => {
    if (score >= 4.5) return "text-green-600";
    if (score >= 4.0) return "text-blue-600";
    if (score >= 3.5) return "text-yellow-600";
    return "text-red-600";
};

// Format date
const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

// Initialize charts
onMounted(() => {
    initializeCharts();
});

const initializeCharts = () => {
    // Score Distribution Chart
    if (props.questionStats && props.questionStats.length > 0) {
        const ctx = document.getElementById("scoreDistributionChart");
        if (ctx) {
            const labels = props.questionStats.map(
                (_, index) => `Q${index + 1}`,
            );
            const data = props.questionStats.map((stat) => stat.average_score);

            charts.value.distribution = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Rata-rata Skor",
                            data: data,
                            backgroundColor: data.map((score) => {
                                if (score >= 4.5)
                                    return "rgba(16, 185, 129, 0.8)";
                                if (score >= 4.0)
                                    return "rgba(59, 130, 246, 0.8)";
                                if (score >= 3.5)
                                    return "rgba(245, 158, 11, 0.8)";
                                return "rgba(239, 68, 68, 0.8)";
                            }),
                            borderColor: data.map((score) => {
                                if (score >= 4.5) return "rgb(16, 185, 129)";
                                if (score >= 4.0) return "rgb(59, 130, 246)";
                                if (score >= 3.5) return "rgb(245, 158, 11)";
                                return "rgb(239, 68, 68)";
                            }),
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
    window.location.href = route(
        "admin.gpm.edom-period.export-lecturer-detail",
        {
            period: props.period.id,
            lecturer: props.lecturer.id,
            format: format,
        },
    );
};
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <a
                        :href="
                            route(
                                'admin.gpm.edom-period.lecturer-statistics',
                                period.id,
                            )
                        "
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
                        Kembali ke Ranking
                    </a>

                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ lecturer.name }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ lecturer.department }} • {{ period.name }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
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

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-6">
                    <dd class="text-lg font-semibold text-gray-900">
                        {{ overallStats?.total_responses || 0 }}
                    </dd>
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
                                        <dd
                                            class="text-lg font-semibold text-gray-900"
                                        >
                                            {{
                                                overallStats?.total_responses ||
                                                0
                                            }}
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
                                        <dd
                                            :class="[
                                                'text-lg font-semibold',
                                                getScoreColor(
                                                    overallStats?.average_score ||
                                                        0,
                                                ),
                                            ]"
                                        >
                                            {{
                                                (
                                                    overallStats?.average_score ||
                                                    0
                                                ).toFixed(2)
                                            }}
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
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Skor Tertinggi
                                        </dt>
                                        <dd
                                            class="text-lg font-semibold text-green-600"
                                        >
                                            {{
                                                (
                                                    overallStats?.highest_score ||
                                                    0
                                                ).toFixed(2)
                                            }}
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
                                            d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Skor Terendah
                                        </dt>
                                        <dd
                                            class="text-lg font-semibold text-red-600"
                                        >
                                            {{
                                                (
                                                    overallStats?.lowest_score ||
                                                    0
                                                ).toFixed(2)
                                            }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Score Distribution Chart -->
                <div
                    v-if="questionStats && questionStats.length > 0"
                    class="bg-white shadow rounded-lg p-6 mb-6"
                >
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Distribusi Skor per Pertanyaan
                    </h3>
                    <div class="h-64">
                        <canvas id="scoreDistributionChart"></canvas>
                    </div>
                </div>

                <!-- Question Statistics Table -->
                <div
                    v-if="questionStats && questionStats.length > 0"
                    class="bg-white shadow rounded-lg overflow-hidden mb-6"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Detail per Pertanyaan
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Pertanyaan
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Rata-rata
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Tertinggi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Terendah
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Std Dev
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="(stat, index) in questionStats"
                                    :key="index"
                                    class="hover:bg-gray-50"
                                >
                                    <td class="px-6 py-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ index + 1 }}.
                                            {{ stat.question_text }}
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <span
                                            :class="[
                                                'text-sm font-semibold',
                                                getScoreColor(
                                                    stat.average_score,
                                                ),
                                            ]"
                                        >
                                            {{ stat.average_score.toFixed(2) }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900"
                                    >
                                        {{ stat.highest_score }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900"
                                    >
                                        {{ stat.lowest_score }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900"
                                    >
                                        {{
                                            stat.std_deviation?.toFixed(2) ||
                                            "-"
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Submissions List -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Daftar Submission ({{ submissions.length }})
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
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Waktu Submit
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Skor
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Komentar
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="submission in submissions"
                                    :key="submission.id"
                                    class="hover:bg-gray-50"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{
                                                submission.student_name ||
                                                "Anonymous"
                                            }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ submission.student_nim || "-" }}
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500"
                                    >
                                        {{
                                            formatDate(submission.submitted_at)
                                        }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        <span
                                            :class="[
                                                'text-sm font-semibold',
                                                getScoreColor(
                                                    submission.average_score,
                                                ),
                                            ]"
                                        >
                                            {{
                                                submission.average_score.toFixed(
                                                    2,
                                                )
                                            }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div class="max-w-xs truncate">
                                            {{ submission.comments || "-" }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div
                        v-if="submissions.length === 0"
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
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            Belum ada submission
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada mahasiswa yang mengisi evaluasi untuk
                            dosen ini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
