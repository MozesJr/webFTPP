<!-- resources/js/Pages/Parent/Khs/Index.vue -->
<template>
    <ParentLayout :student="student">
        <div class="space-y-6">
            <!-- Header -->
            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between"
            >
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Daftar KHS</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Kartu Hasil Studi {{ student.name }} ({{ student.nim }})
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="text-sm text-gray-500">
                        Total:
                        <span class="font-medium">{{ khsFiles.total }}</span>
                        file KHS
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <!-- Year Filter -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Tahun Akademik
                            </label>
                            <select
                                v-model="selectedYear"
                                @change="applyFilters"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
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

                        <!-- Period Filter -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Periode
                            </label>
                            <select
                                v-model="selectedPeriod"
                                @change="applyFilters"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            >
                                <option value="">Semua Periode</option>
                                <option
                                    v-for="period in availablePeriods"
                                    :key="period.id"
                                    :value="period.id"
                                >
                                    {{ period.display_name }}
                                </option>
                            </select>
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex items-end">
                            <button
                                @click="clearFilters"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Download Latest -->
            <div
                v-if="khsFiles.data.length > 0"
                class="bg-blue-50 border border-blue-200 rounded-lg p-4"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-blue-900">
                            Download Terbaru
                        </h3>
                        <p class="text-sm text-blue-700">
                            KHS terbaru dari periode
                            {{ khsFiles.data[0]?.semester_name }}
                        </p>
                    </div>
                    <Link
                        :href="route('parent.download-latest')"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <ArrowDownTrayIcon class="mr-2 h-4 w-4" />
                        Download
                    </Link>
                </div>
            </div>

            <!-- KHS List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div
                    v-if="khsFiles.data.length === 0"
                    class="text-center py-12"
                >
                    <DocumentTextIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        Tidak ada KHS
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{
                            filters.year || filters.period_id
                                ? "Tidak ada KHS untuk filter yang dipilih."
                                : "Belum ada file KHS yang tersedia."
                        }}
                    </p>
                </div>

                <ul v-else class="divide-y divide-gray-200">
                    <li
                        v-for="khs in khsFiles.data"
                        :key="khs.id"
                        class="hover:bg-gray-50 transition-colors duration-150"
                    >
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <DocumentTextIcon
                                                class="h-10 w-10 text-indigo-600"
                                            />
                                        </div>
                                        <div class="ml-4 flex-1 min-w-0">
                                            <h3
                                                class="text-lg font-medium text-gray-900 truncate"
                                            >
                                                {{ khs.semester_name }}
                                            </h3>
                                            <div
                                                class="mt-1 flex items-center text-sm text-gray-500"
                                            >
                                                <CalendarIcon
                                                    class="flex-shrink-0 mr-1.5 h-4 w-4"
                                                />
                                                {{
                                                    khs.academic_period
                                                        ?.display_name
                                                }}
                                                <span class="mx-2">•</span>
                                                <span>{{
                                                    khs.file_size_human
                                                }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{
                                                    khs.uploaded_at_human
                                                }}</span>
                                            </div>
                                            <div
                                                class="mt-2 flex items-center text-sm text-gray-500"
                                            >
                                                <EyeIcon
                                                    class="flex-shrink-0 mr-1.5 h-4 w-4"
                                                />
                                                {{ khs.access_count || 0 }} kali
                                                diakses
                                                <span
                                                    v-if="
                                                        khs.last_accessed_human
                                                    "
                                                    class="mx-2"
                                                    >•</span
                                                >
                                                <span
                                                    v-if="
                                                        khs.last_accessed_human
                                                    "
                                                >
                                                    Terakhir:
                                                    {{
                                                        khs.last_accessed_human
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="flex-shrink-0 flex items-center space-x-2"
                                >
                                    <!-- Action Buttons -->
                                    <button
                                        @click="previewKhs(khs)"
                                        class="inline-flex items-center p-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        title="Preview KHS"
                                    >
                                        <EyeIcon class="h-4 w-4" />
                                    </button>
                                    <button
                                        @click="downloadKhs(khs)"
                                        class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        title="Download KHS"
                                    >
                                        <ArrowDownTrayIcon class="h-4 w-4" />
                                    </button>
                                    <Link
                                        :href="
                                            route('parent.khs.detail', khs.id)
                                        "
                                        class="inline-flex items-center p-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        title="Detail KHS"
                                    >
                                        <ChevronRightIcon class="h-4 w-4" />
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Pagination -->
            <div
                v-if="khsFiles.last_page > 1"
                class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow"
            >
                <div class="flex-1 flex justify-between sm:hidden">
                    <Link
                        v-if="khsFiles.prev_page_url"
                        :href="khsFiles.prev_page_url"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                    >
                        Previous
                    </Link>
                    <Link
                        v-if="khsFiles.next_page_url"
                        :href="khsFiles.next_page_url"
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
                            <span class="font-medium">{{ khsFiles.from }}</span>
                            to
                            <span class="font-medium">{{ khsFiles.to }}</span>
                            of
                            <span class="font-medium">{{
                                khsFiles.total
                            }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav
                            class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                        >
                            <Link
                                v-if="khsFiles.prev_page_url"
                                :href="khsFiles.prev_page_url"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                            >
                                <ChevronLeftIcon class="h-5 w-5" />
                            </Link>

                            <template
                                v-for="page in paginationLinks"
                                :key="page.label"
                            >
                                <Link
                                    v-if="page.url"
                                    :href="page.url"
                                    :class="[
                                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                        page.active
                                            ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                    ]"
                                    v-html="page.label"
                                />
                                <span
                                    v-else
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
                                    v-html="page.label"
                                />
                            </template>

                            <Link
                                v-if="khsFiles.next_page_url"
                                :href="khsFiles.next_page_url"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                            >
                                <ChevronRightIcon class="h-5 w-5" />
                            </Link>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </ParentLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";
import ParentLayout from "@/Layouts/ParentLayout.vue";
import {
    DocumentTextIcon,
    CalendarIcon,
    EyeIcon,
    ArrowDownTrayIcon,
    ChevronRightIcon,
    ChevronLeftIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    student: Object,
    khsFiles: Object,
    availablePeriods: Array,
    availableYears: Array,
    filters: Object,
});

// State
const selectedYear = ref(props.filters?.year || "");
const selectedPeriod = ref(props.filters?.period_id || "");

// Computed
const paginationLinks = computed(() => {
    if (!props.khsFiles.links) return [];
    return props.khsFiles.links.slice(1, -1); // Remove first and last (prev/next)
});

// Methods
const applyFilters = () => {
    const params = {};
    if (selectedYear.value) params.year = selectedYear.value;
    if (selectedPeriod.value) params.period_id = selectedPeriod.value;

    router.get(route("parent.khs.index"), params, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    selectedYear.value = "";
    selectedPeriod.value = "";
    router.get(
        route("parent.khs.index"),
        {},
        {
            preserveState: true,
        }
    );
};

const previewKhs = (khs) => {
    window.open(route("parent.khs.preview", khs.id), "_blank");
};

const downloadKhs = (khs) => {
    window.location.href = route("parent.khs.download", khs.id);
};
</script>
