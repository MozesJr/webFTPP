<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Statistik Fakultas
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola data statistik mahasiswa, kemitraan, alumni,
                            dan dosen
                        </p>
                    </div>
                    <Link
                        href="/admin/stats/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Data
                    </Link>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div
            v-if="summaryData.current"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6"
        >
            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <UsersIcon class="h-8 w-8 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">
                            Total Mahasiswa
                        </p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{
                                formatNumber(summaryData.current.total_students)
                            }}
                        </p>
                        <p
                            v-if="summaryData.avgGrowthRates"
                            class="text-sm"
                            :class="
                                getGrowthClass(
                                    summaryData.avgGrowthRates.students
                                )
                            "
                        >
                            <component
                                :is="
                                    getGrowthIcon(
                                        summaryData.avgGrowthRates.students
                                    )
                                "
                                class="inline w-4 h-4 mr-1"
                            />
                            {{ Math.abs(summaryData.avgGrowthRates.students) }}%
                            rata-rata/tahun
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <BuildingOfficeIcon class="h-8 w-8 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">
                            Kemitraan
                        </p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{
                                formatNumber(
                                    summaryData.current.total_partnerships
                                )
                            }}
                        </p>
                        <p
                            v-if="summaryData.avgGrowthRates"
                            class="text-sm"
                            :class="
                                getGrowthClass(
                                    summaryData.avgGrowthRates.partnerships
                                )
                            "
                        >
                            <component
                                :is="
                                    getGrowthIcon(
                                        summaryData.avgGrowthRates.partnerships
                                    )
                                "
                                class="inline w-4 h-4 mr-1"
                            />
                            {{
                                Math.abs(
                                    summaryData.avgGrowthRates.partnerships
                                )
                            }}% rata-rata/tahun
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <AcademicCapIcon class="h-8 w-8 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Alumni</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ formatNumber(summaryData.current.total_alumni) }}
                        </p>
                        <p
                            v-if="summaryData.avgGrowthRates"
                            class="text-sm"
                            :class="
                                getGrowthClass(
                                    summaryData.avgGrowthRates.alumni
                                )
                            "
                        >
                            <component
                                :is="
                                    getGrowthIcon(
                                        summaryData.avgGrowthRates.alumni
                                    )
                                "
                                class="inline w-4 h-4 mr-1"
                            />
                            {{ Math.abs(summaryData.avgGrowthRates.alumni) }}%
                            rata-rata/tahun
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <UserGroupIcon class="h-8 w-8 text-orange-600" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Dosen</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{
                                formatNumber(
                                    summaryData.current.total_lecturers
                                )
                            }}
                        </p>
                        <p
                            v-if="summaryData.avgGrowthRates"
                            class="text-sm"
                            :class="
                                getGrowthClass(
                                    summaryData.avgGrowthRates.lecturers
                                )
                            "
                        >
                            <component
                                :is="
                                    getGrowthIcon(
                                        summaryData.avgGrowthRates.lecturers
                                    )
                                "
                                class="inline w-4 h-4 mr-1"
                            />
                            {{
                                Math.abs(summaryData.avgGrowthRates.lecturers)
                            }}% rata-rata/tahun
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Tren Statistik per Tahun
                    </h2>
                    <div class="flex space-x-2">
                        <button
                            @click="toggleChartType('line')"
                            :class="
                                chartType === 'line'
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-gray-200 text-gray-700'
                            "
                            class="px-3 py-1 rounded-md text-sm font-medium"
                        >
                            Line Chart
                        </button>
                        <button
                            @click="toggleChartType('bar')"
                            :class="
                                chartType === 'bar'
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-gray-200 text-gray-700'
                            "
                            class="px-3 py-1 rounded-md text-sm font-medium"
                        >
                            Bar Chart
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="h-96">
                    <div v-if="props.chartData.years.length > 0">
                        <div class="chart-wrapper h-80 relative">
                            <canvas
                                :key="chartKey"
                                ref="chartCanvas"
                                class="w-full h-full"
                            ></canvas>
                        </div>
                    </div>
                    <div
                        v-else
                        class="flex items-center justify-center h-full bg-gray-50 rounded-lg"
                    >
                        <div class="text-center">
                            <ChartBarIcon
                                class="mx-auto h-12 w-12 text-gray-400"
                            />
                            <p class="mt-2 text-sm text-gray-600">
                                No data available for chart
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Tahun
                        </label>
                        <select
                            v-model="filterForm.year"
                            @change="applyFilters"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Semua Tahun</option>
                            <option
                                v-for="year in availableYears"
                                :key="year"
                                :value="year"
                            >
                                {{ year }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Cari
                        </label>
                        <input
                            v-model="filterForm.search"
                            @keyup.enter="applyFilters"
                            type="text"
                            placeholder="Cari tahun..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>
                <div class="flex justify-end mt-4 space-x-2">
                    <button
                        @click="applyFilters"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                    >
                        <MagnifyingGlassIcon class="w-4 h-4 mr-2" />
                        Cari
                    </button>
                    <button
                        @click="resetFilters"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                    >
                        <XMarkIcon class="w-4 h-4 mr-2" />
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Data Statistik per Tahun
                </h3>
            </div>
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Tahun
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Mahasiswa
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Kemitraan
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Alumni
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Dosen
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="stats.data.length === 0">
                            <td colspan="7" class="px-6 py-12 text-center">
                                <ChartBarIcon
                                    class="mx-auto h-12 w-12 text-gray-400"
                                />
                                <h3
                                    class="mt-4 text-lg font-medium text-gray-900"
                                >
                                    Belum ada data statistik
                                </h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    Mulai dengan menambahkan data statistik
                                    pertama.
                                </p>
                                <div class="mt-6">
                                    <Link
                                        href="/admin/stats/create"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                                    >
                                        <PlusIcon class="w-4 h-4 mr-2" />
                                        Tambah Data
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        <tr
                            v-for="stat in stats.data"
                            :key="stat.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ stat.year }}
                                    </div>
                                    <span
                                        v-if="stat.is_current"
                                        class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                    >
                                        Terkini
                                    </span>
                                </div>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ formatNumber(stat.total_students) }}
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ formatNumber(stat.total_partnerships) }}
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ formatNumber(stat.total_alumni) }}
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ formatNumber(stat.total_lecturers) }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <button
                                    v-if="!stat.is_current"
                                    @click="setCurrent(stat)"
                                    class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    Set as Current
                                </button>
                                <span
                                    v-else
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                >
                                    Current Year
                                </span>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <div
                                    class="flex items-center justify-end space-x-2"
                                >
                                    <Link
                                        :href="`/admin/stats/${stat.id}`"
                                        class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        <EyeIcon class="h-4 w-4 mr-1" />
                                        View
                                    </Link>

                                    <Link
                                        :href="`/admin/stats/${stat.id}/edit`"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
                                    >
                                        <PencilIcon class="h-4 w-4 mr-1" />
                                        Edit
                                    </Link>

                                    <button
                                        @click="handleDelete(stat)"
                                        type="button"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700"
                                    >
                                        <TrashIcon class="h-4 w-4 mr-1" />
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                v-if="stats.links"
                class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6"
            >
                <div class="flex items-center justify-between">
                    <div class="flex justify-between flex-1 sm:hidden">
                        <Link
                            v-if="stats.prev_page_url"
                            :href="stats.prev_page_url"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Previous
                        </Link>
                        <Link
                            v-if="stats.next_page_url"
                            :href="stats.next_page_url"
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
                                Showing {{ stats.from }} to {{ stats.to }} of
                                {{ stats.total }} results
                            </p>
                        </div>
                        <div>
                            <nav
                                class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            >
                                <template
                                    v-for="link in stats.links"
                                    :key="link.label"
                                >
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        v-html="link.label"
                                        :class="[
                                            'relative inline-flex items-center px-2 py-2 border text-sm font-medium',
                                            link.active
                                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                        ]"
                                    />
                                    <span
                                        v-else
                                        v-html="link.label"
                                        class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed"
                                    />
                                </template>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import {
    onMounted,
    ref,
    reactive,
    computed,
    watch,
    onBeforeUnmount,
    nextTick,
} from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    ChartBarIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
    MagnifyingGlassIcon,
    XMarkIcon,
    UsersIcon,
    BuildingOfficeIcon,
    AcademicCapIcon,
    UserGroupIcon,
    ArrowTrendingUpIcon,
    ArrowTrendingDownIcon,
    MinusIcon,
} from "@heroicons/vue/24/outline";

// Chart.js imports - Use auto import for simplicity
import Chart from "chart.js/auto";

// Props
const props = defineProps({
    stats: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({ search: "", year: "" }),
    },
    chartData: {
        type: Object,
        default: () => ({
            years: [],
            students: [],
            partnerships: [],
            alumni: [],
            lecturers: [],
        }),
    },
    summaryData: {
        type: Object,
        default: () => ({}),
    },
    availableYears: {
        type: Array,
        default: () => [],
    },
});

// Reactive data
const chartType = ref("line");
const chartCanvas = ref(null);
const chartInstance = ref(null);
const chartKey = ref(0); // Key to force re-render of canvas

// Filter form
const filterForm = reactive({
    search: props.filters.search || "",
    year: props.filters.year || "",
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Chart data
const chartDataConfig = computed(() => ({
    labels: props.chartData.years,
    datasets: [
        {
            label: "Mahasiswa",
            data: props.chartData.students,
            borderColor: "rgb(59, 130, 246)",
            backgroundColor:
                chartType.value === "bar"
                    ? "rgba(59, 130, 246, 0.8)"
                    : "rgba(59, 130, 246, 0.1)",
            tension: chartType.value === "line" ? 0.4 : 0,
        },
        {
            label: "Kemitraan",
            data: props.chartData.partnerships,
            borderColor: "rgb(34, 197, 94)",
            backgroundColor:
                chartType.value === "bar"
                    ? "rgba(34, 197, 94, 0.8)"
                    : "rgba(34, 197, 94, 0.1)",
            tension: chartType.value === "line" ? 0.4 : 0,
        },
        {
            label: "Alumni",
            data: props.chartData.alumni,
            borderColor: "rgb(168, 85, 247)",
            backgroundColor:
                chartType.value === "bar"
                    ? "rgba(168, 85, 247, 0.8)"
                    : "rgba(168, 85, 247, 0.1)",
            tension: chartType.value === "line" ? 0.4 : 0,
        },
        {
            label: "Dosen",
            data: props.chartData.lecturers,
            borderColor: "rgb(249, 115, 22)",
            backgroundColor:
                chartType.value === "bar"
                    ? "rgba(249, 115, 22, 0.8)"
                    : "rgba(249, 115, 22, 0.1)",
            tension: chartType.value === "line" ? 0.4 : 0,
        },
    ],
}));

const chartOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: "top",
        },
        title: {
            display: false,
        },
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                callback: function (value) {
                    return formatNumber(value);
                },
            },
        },
    },
    interaction: {
        intersect: false,
    },
}));

// Methods
const destroyChart = () => {
    if (chartInstance.value) {
        try {
            chartInstance.value.destroy();
        } catch (error) {
            console.warn("Error destroying chart:", error);
        }
        chartInstance.value = null;
    }
};

const createChart = async () => {
    // Destroy existing chart first
    destroyChart();

    // Wait for next tick to ensure DOM is updated
    await nextTick();

    if (!chartCanvas.value) {
        console.warn("Chart canvas not found");
        return;
    }

    if (!props.chartData.years.length) {
        console.warn("No chart data available");
        return;
    }

    try {
        const ctx = chartCanvas.value.getContext("2d");
        chartInstance.value = new Chart(ctx, {
            type: chartType.value,
            data: chartDataConfig.value,
            options: chartOptions.value,
        });
    } catch (error) {
        console.error("Error creating chart:", error);
    }
};

// Watch chartType changes
const toggleChartType = async (type) => {
    if (chartType.value === type) return;

    chartType.value = type;
    chartKey.value += 1; // Force canvas re-render

    // Wait for DOM update then create new chart
    await nextTick();
    setTimeout(() => {
        createChart();
    }, 50);
};

const formatNumber = (number) => {
    if (number === null || number === undefined) return "0";
    return new Intl.NumberFormat("id-ID").format(number);
};

const getGrowthClass = (rate) => {
    if (rate > 0) return "text-green-600";
    if (rate < 0) return "text-red-600";
    return "text-gray-600";
};

const getGrowthIcon = (rate) => {
    if (rate > 0) return ArrowTrendingUpIcon;
    if (rate < 0) return ArrowTrendingDownIcon;
    return MinusIcon;
};

const applyFilters = () => {
    router.get(route("admin.stats.index"), filterForm, {
        preserveState: true,
        replace: true,
    });
};

const resetFilters = () => {
    Object.keys(filterForm).forEach((key) => {
        filterForm[key] = "";
    });
    applyFilters();
};

const setCurrent = (stat) => {
    router.patch(
        route("admin.stats.set-current", stat.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                success(
                    "Berhasil!",
                    `Data tahun ${stat.year} berhasil diset sebagai data terkini.`
                );
            },
            onError: (errors) => {
                console.log("Set current errors:", errors);
                error("Error!", "Terjadi kesalahan saat mengubah status data.");
            },
        }
    );
};

const handleDelete = async (stat) => {
    const result = await confirmDelete(
        "Hapus Data Statistik?",
        `Data statistik tahun ${stat.year} akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/stats/${stat.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Data statistik berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus data.");
            },
        });
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

    // Create chart after small delay to ensure DOM is ready
    setTimeout(() => {
        if (props.chartData.years.length > 0) {
            createChart();
        }
    }, 200);
});

onBeforeUnmount(() => {
    // Cleanup chart instance when component is destroyed
    destroyChart();
});

// Watch for data changes to update chart
watch(
    () => props.chartData,
    async (newData) => {
        if (newData.years.length > 0 && chartInstance.value) {
            // Update existing chart data
            chartInstance.value.data = chartDataConfig.value;
            chartInstance.value.update();
        } else if (newData.years.length > 0) {
            // Create chart if it doesn't exist
            await createChart();
        }
    },
    { deep: true }
);
</script>
