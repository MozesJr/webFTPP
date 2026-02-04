<script setup>
import { ref, onMounted, computed } from "vue";
import { Chart, registerables } from "chart.js";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Register Chart.js components
Chart.register(...registerables);

const props = defineProps({
    survey: Object,
    statistics: Object,
    responses: Array,
    questionStats: Array,
});

const charts = ref({});

// Format date
const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
};

// Get average rating color
const getRatingColor = (avg) => {
    if (avg >= 4.5) return "text-green-600";
    if (avg >= 3.5) return "text-blue-600";
    if (avg >= 2.5) return "text-yellow-600";
    return "text-red-600";
};

// Initialize charts
onMounted(() => {
    initializeCharts();
});

const initializeCharts = () => {
    // Response Timeline Chart
    if (props.statistics?.response_timeline) {
        const ctx = document.getElementById("responseTimelineChart");
        if (ctx) {
            const labels = props.statistics.response_timeline.map((item) =>
                new Date(item.date).toLocaleDateString("id-ID", {
                    day: "numeric",
                    month: "short",
                }),
            );
            const data = props.statistics.response_timeline.map(
                (item) => item.count,
            );

            charts.value.timeline = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Respons per Hari",
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

    // Initialize question-specific charts
    props.questionStats.forEach((stat, index) => {
        if (stat.type === "rating" || stat.type === "scale") {
            initRatingChart(stat, index);
        } else if (stat.type === "multiple_choice" || stat.type === "yes_no") {
            initPieChart(stat, index);
        }
    });
};

const initRatingChart = (stat, index) => {
    const ctx = document.getElementById(`ratingChart${index}`);
    if (!ctx) return;

    const labels = Object.keys(stat.distribution || {});
    const data = Object.values(stat.distribution || {});

    charts.value[`rating${index}`] = new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels.map((l) => `Rating ${l}`),
            datasets: [
                {
                    label: "Jumlah Respons",
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
                    ticks: {
                        stepSize: 1,
                    },
                },
            },
        },
    });
};

const initPieChart = (stat, index) => {
    const ctx = document.getElementById(`pieChart${index}`);
    if (!ctx) return;

    const labels = Object.keys(stat.distribution || {});
    const data = Object.values(stat.distribution || {});

    const backgroundColors = [
        "rgba(59, 130, 246, 0.8)",
        "rgba(16, 185, 129, 0.8)",
        "rgba(245, 158, 11, 0.8)",
        "rgba(239, 68, 68, 0.8)",
        "rgba(139, 92, 246, 0.8)",
    ];

    charts.value[`pie${index}`] = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: labels,
            datasets: [
                {
                    data: data,
                    backgroundColor: backgroundColors,
                    borderWidth: 2,
                    borderColor: "#fff",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom",
                },
            },
        },
    });
};

// Export results
const exportResults = (format) => {
    window.location.href = route("admin.gpm.survey.export", {
        survey: props.survey.id,
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
                        :href="route('admin.gpm.survey.show', survey.id)"
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
                                Hasil Survey: {{ survey.title }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Analisis dan statistik hasil survey
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
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Total Respons
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div
                                                class="text-2xl font-semibold text-gray-900"
                                            >
                                                {{
                                                    statistics?.total_responses ||
                                                    0
                                                }}
                                            </div>
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
                                            Tingkat Penyelesaian
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
                                            Rating Rata-rata
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div
                                                :class="[
                                                    'text-2xl font-semibold',
                                                    getRatingColor(
                                                        statistics?.average_rating ||
                                                            0,
                                                    ),
                                                ]"
                                            >
                                                {{
                                                    (
                                                        statistics?.average_rating ||
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
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Waktu Rata-rata
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div
                                                class="text-2xl font-semibold text-gray-900"
                                            >
                                                {{
                                                    statistics?.average_time ||
                                                    0
                                                }}
                                            </div>
                                            <span
                                                class="ml-2 text-sm text-gray-500"
                                                >menit</span
                                            >
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Response Timeline Chart -->
                <div
                    v-if="statistics?.response_timeline"
                    class="bg-white shadow rounded-lg p-6 mb-6"
                >
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Timeline Respons
                    </h3>
                    <div class="h-64">
                        <canvas id="responseTimelineChart"></canvas>
                    </div>
                </div>

                <!-- Question Statistics -->
                <div class="space-y-6">
                    <div
                        v-for="(stat, index) in questionStats"
                        :key="stat.question_id"
                        class="bg-white shadow rounded-lg p-6"
                    >
                        <h3 class="text-base font-medium text-gray-900 mb-4">
                            {{ index + 1 }}. {{ stat.question_text }}
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Chart -->
                            <div
                                v-if="
                                    stat.type === 'rating' ||
                                    stat.type === 'scale'
                                "
                                class="h-64"
                            >
                                <canvas :id="`ratingChart${index}`"></canvas>
                            </div>
                            <div
                                v-else-if="
                                    stat.type === 'multiple_choice' ||
                                    stat.type === 'yes_no'
                                "
                                class="h-64"
                            >
                                <canvas :id="`pieChart${index}`"></canvas>
                            </div>

                            <!-- Statistics -->
                            <div>
                                <dl class="grid grid-cols-1 gap-4">
                                    <div
                                        v-if="stat.average"
                                        class="border-l-4 border-blue-500 pl-4"
                                    >
                                        <dt
                                            class="text-sm font-medium text-gray-500"
                                        >
                                            Nilai Rata-rata
                                        </dt>
                                        <dd
                                            :class="[
                                                'mt-1 text-3xl font-semibold',
                                                getRatingColor(stat.average),
                                            ]"
                                        >
                                            {{ stat.average.toFixed(2) }}
                                        </dd>
                                    </div>
                                    <div
                                        class="border-l-4 border-green-500 pl-4"
                                    >
                                        <dt
                                            class="text-sm font-medium text-gray-500"
                                        >
                                            Total Jawaban
                                        </dt>
                                        <dd
                                            class="mt-1 text-3xl font-semibold text-gray-900"
                                        >
                                            {{ stat.total_responses }}
                                        </dd>
                                    </div>
                                    <div
                                        v-if="stat.most_common"
                                        class="border-l-4 border-purple-500 pl-4"
                                    >
                                        <dt
                                            class="text-sm font-medium text-gray-500"
                                        >
                                            Jawaban Terbanyak
                                        </dt>
                                        <dd
                                            class="mt-1 text-lg font-semibold text-gray-900"
                                        >
                                            {{ stat.most_common }}
                                        </dd>
                                    </div>
                                </dl>

                                <!-- Text Responses Preview -->
                                <div
                                    v-if="
                                        stat.type === 'text' ||
                                        stat.type === 'textarea'
                                    "
                                    class="mt-4"
                                >
                                    <h4
                                        class="text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Sample Jawaban:
                                    </h4>
                                    <div class="space-y-2">
                                        <div
                                            v-for="(
                                                response, idx
                                            ) in stat.sample_responses?.slice(
                                                0,
                                                3,
                                            )"
                                            :key="idx"
                                            class="text-sm text-gray-600 p-2 bg-gray-50 rounded border border-gray-200"
                                        >
                                            "{{ response }}"
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
