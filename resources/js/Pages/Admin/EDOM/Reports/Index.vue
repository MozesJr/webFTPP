<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Laporan & Analytics EDOM
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Dashboard analytics dan statistik evaluasi dosen
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="route('admin.edom.reports.lecturer')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <UserIcon class="w-4 h-4 mr-2" />
                            Laporan Dosen
                        </Link>
                        <Link
                            :href="route('admin.edom.reports.category')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ChartBarIcon class="w-4 h-4 mr-2" />
                            Laporan Kategori
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Filter Laporan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                            Semester
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

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Dari Tanggal
                        </label>
                        <input
                            v-model="filterForm.date_from"
                            type="date"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @change="applyFilter"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Sampai Tanggal
                        </label>
                        <input
                            v-model="filterForm.date_to"
                            type="date"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @change="applyFilter"
                        />
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
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <DocumentCheckIcon class="h-8 w-8 text-green-600" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt
                                    class="text-sm font-medium text-gray-500 truncate"
                                >
                                    Total Evaluasi
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{
                                        statistics.total_evaluations.toLocaleString()
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
                            <UserGroupIcon class="h-8 w-8 text-blue-600" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt
                                    class="text-sm font-medium text-gray-500 truncate"
                                >
                                    Program Studi Aktif
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ statistics.response_rates.length }}
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
                            <AcademicCapIcon class="h-8 w-8 text-purple-600" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt
                                    class="text-sm font-medium text-gray-500 truncate"
                                >
                                    Rata-rata Skor
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ averageOverallScore }}
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
                            <ChartPieIcon class="h-8 w-8 text-orange-600" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt
                                    class="text-sm font-medium text-gray-500 truncate"
                                >
                                    Kategori Evaluasi
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ statistics.category_analysis.length }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Response Rates Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Response Rate per Program Studi
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div
                            v-for="rate in statistics.response_rates"
                            :key="rate.name"
                            class="relative"
                        >
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ rate.name }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ rate.response_rate }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div
                                    class="bg-indigo-600 h-2 rounded-full transition-all duration-300"
                                    :style="{ width: `${rate.response_rate}%` }"
                                ></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ rate.completed_evaluations }} dari
                                {{ rate.total_questionnaires }} evaluasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Lecturers -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Dosen Terbaik (Top 10)
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div
                            v-for="(
                                lecturer, index
                            ) in statistics.top_lecturers.slice(0, 10)"
                            :key="lecturer.name"
                            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"
                        >
                            <div class="flex items-center space-x-3">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 text-xs font-medium text-white bg-indigo-600 rounded-full"
                                >
                                    {{ index + 1 }}
                                </span>
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ lecturer.name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ lecturer.prodi_name }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span
                                    class="text-lg font-semibold text-indigo-600"
                                >
                                    {{ lecturer.average_score }}
                                </span>
                                <p class="text-xs text-gray-500">
                                    {{ lecturer.total_evaluations }} evaluasi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluation Trends -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Tren Evaluasi (12 Bulan Terakhir)
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Trend Chart Placeholder -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700">
                            Jumlah Evaluasi per Bulan
                        </h4>
                        <div
                            class="relative h-64 bg-gray-50 rounded-lg flex items-center justify-center"
                        >
                            <div class="text-center">
                                <ChartBarIcon
                                    class="h-12 w-12 text-gray-400 mx-auto mb-2"
                                />
                                <p class="text-sm text-gray-500">
                                    Chart will be implemented
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Average Score Trend -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-medium text-gray-700">
                            Rata-rata Skor per Bulan
                        </h4>
                        <div class="space-y-2">
                            <div
                                v-for="trend in statistics.evaluation_trends"
                                :key="trend.month"
                                class="flex items-center justify-between p-2 bg-gray-50 rounded"
                            >
                                <span class="text-sm text-gray-700">{{
                                    formatMonth(trend.month)
                                }}</span>
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="text-sm font-medium text-indigo-600"
                                        >{{ trend.avg_score }}</span
                                    >
                                    <span class="text-xs text-gray-500"
                                        >({{ trend.count }} eval)</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Analysis -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Analisis per Kategori
                </h3>
            </div>
            <div class="p-6">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        v-for="category in statistics.category_analysis"
                        :key="category.category_name"
                        class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-lg p-6 border border-indigo-100"
                    >
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900">
                                {{ category.category_name }}
                            </h4>
                            <span
                                :class="[
                                    'px-3 py-1 rounded-full text-sm font-medium',
                                    getScoreColor(category.avg_score),
                                ]"
                            >
                                {{ category.avg_score }}
                            </span>
                        </div>

                        <!-- Score Bar -->
                        <div class="mb-3">
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div
                                    :class="[
                                        'h-3 rounded-full transition-all duration-300',
                                        getScoreBarColor(category.avg_score),
                                    ]"
                                    :style="{
                                        width: `${
                                            (category.avg_score / 5) * 100
                                        }%`,
                                    }"
                                ></div>
                            </div>
                        </div>

                        <div class="text-sm text-gray-600">
                            <p>
                                {{
                                    category.total_answers.toLocaleString()
                                }}
                                jawaban
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    v-if="statistics.category_analysis.length === 0"
                    class="text-center py-12"
                >
                    <ChartPieIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-4 text-lg font-medium text-gray-900">
                        Belum ada data kategori
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Data akan muncul setelah ada evaluasi yang masuk.
                    </p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    UserIcon,
    ChartBarIcon,
    DocumentCheckIcon,
    UserGroupIcon,
    AcademicCapIcon,
    ChartPieIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    filters: {
        type: Object,
        default: () => ({}),
    },
    statistics: {
        type: Object,
        required: true,
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

// Reactive data
const filterForm = ref({
    questionnaire_id: props.filters.questionnaire_id || "",
    prodi_id: props.filters.prodi_id || "",
    semester_taken: props.filters.semester_taken || "",
    date_from: props.filters.date_from || "",
    date_to: props.filters.date_to || "",
});

// Computed
const averageOverallScore = computed(() => {
    if (props.statistics.category_analysis.length === 0) return "0.00";
    const total = props.statistics.category_analysis.reduce(
        (sum, category) => sum + category.avg_score,
        0
    );
    return (total / props.statistics.category_analysis.length).toFixed(2);
});

// Methods
const applyFilter = () => {
    router.get(route("admin.edom.reports.index"), filterForm.value, {
        preserveState: true,
        replace: true,
    });
};

const resetFilter = () => {
    filterForm.value = {
        questionnaire_id: "",
        prodi_id: "",
        semester_taken: "",
        date_from: "",
        date_to: "",
    };
    applyFilter();
};

const formatMonth = (monthString) => {
    const [year, month] = monthString.split("-");
    const date = new Date(year, month - 1);
    return date.toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
    });
};

const getScoreColor = (score) => {
    if (score >= 4.5) return "bg-green-100 text-green-800";
    if (score >= 4.0) return "bg-blue-100 text-blue-800";
    if (score >= 3.5) return "bg-yellow-100 text-yellow-800";
    if (score >= 3.0) return "bg-orange-100 text-orange-800";
    return "bg-red-100 text-red-800";
};

const getScoreBarColor = (score) => {
    if (score >= 4.5) return "bg-green-500";
    if (score >= 4.0) return "bg-blue-500";
    if (score >= 3.5) return "bg-yellow-500";
    if (score >= 3.0) return "bg-orange-500";
    return "bg-red-500";
};
</script>
