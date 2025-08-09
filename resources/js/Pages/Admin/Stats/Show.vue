<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Statistik Tahun {{ stat.year }}
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi lengkap data statistik universitas
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            href="/admin/stats"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                        <Link
                            :href="`/admin/stats/${stat.id}/edit`"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <UsersIcon class="h-10 w-10 text-blue-600" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">
                                    Total Mahasiswa
                                </p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ formatNumber(stat.total_students) }}
                                </p>
                                <p
                                    v-if="growthRates"
                                    class="text-sm mt-1"
                                    :class="
                                        getGrowthClass(growthRates.students)
                                    "
                                >
                                    <component
                                        :is="
                                            getGrowthIcon(growthRates.students)
                                        "
                                        class="inline w-4 h-4 mr-1"
                                    />
                                    {{
                                        formatGrowthRate(growthRates.students)
                                    }}
                                    dari tahun sebelumnya
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <BuildingOfficeIcon
                                    class="h-10 w-10 text-green-600"
                                />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">
                                    Total Kemitraan
                                </p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ formatNumber(stat.total_partnerships) }}
                                </p>
                                <p
                                    v-if="growthRates"
                                    class="text-sm mt-1"
                                    :class="
                                        getGrowthClass(growthRates.partnerships)
                                    "
                                >
                                    <component
                                        :is="
                                            getGrowthIcon(
                                                growthRates.partnerships
                                            )
                                        "
                                        class="inline w-4 h-4 mr-1"
                                    />
                                    {{
                                        formatGrowthRate(
                                            growthRates.partnerships
                                        )
                                    }}
                                    dari tahun sebelumnya
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <AcademicCapIcon
                                    class="h-10 w-10 text-purple-600"
                                />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">
                                    Total Alumni
                                </p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ formatNumber(stat.total_alumni) }}
                                </p>
                                <p
                                    v-if="growthRates"
                                    class="text-sm mt-1"
                                    :class="getGrowthClass(growthRates.alumni)"
                                >
                                    <component
                                        :is="getGrowthIcon(growthRates.alumni)"
                                        class="inline w-4 h-4 mr-1"
                                    />
                                    {{
                                        formatGrowthRate(growthRates.alumni)
                                    }}
                                    dari tahun sebelumnya
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <UserGroupIcon
                                    class="h-10 w-10 text-orange-600"
                                />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">
                                    Total Dosen
                                </p>
                                <p class="text-3xl font-bold text-gray-900">
                                    {{ formatNumber(stat.total_lecturers) }}
                                </p>
                                <p
                                    v-if="growthRates"
                                    class="text-sm mt-1"
                                    :class="
                                        getGrowthClass(growthRates.lecturers)
                                    "
                                >
                                    <component
                                        :is="
                                            getGrowthIcon(growthRates.lecturers)
                                        "
                                        class="inline w-4 h-4 mr-1"
                                    />
                                    {{
                                        formatGrowthRate(growthRates.lecturers)
                                    }}
                                    dari tahun sebelumnya
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Year Comparison -->
                <div
                    v-if="previousYear || nextYear"
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Perbandingan Tahun
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div v-if="previousYear" class="text-center">
                                <h3
                                    class="text-lg font-medium text-gray-900 mb-4"
                                >
                                    {{ previousYear.year }}
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Mahasiswa:</span
                                        >
                                        <span class="text-sm font-medium">{{
                                            formatNumber(
                                                previousYear.total_students
                                            )
                                        }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Kemitraan:</span
                                        >
                                        <span class="text-sm font-medium">{{
                                            formatNumber(
                                                previousYear.total_partnerships
                                            )
                                        }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Alumni:</span
                                        >
                                        <span class="text-sm font-medium">{{
                                            formatNumber(
                                                previousYear.total_alumni
                                            )
                                        }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Dosen:</span
                                        >
                                        <span class="text-sm font-medium">{{
                                            formatNumber(
                                                previousYear.total_lecturers
                                            )
                                        }}</span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="text-center border-l border-r border-gray-200 px-6"
                            >
                                <h3
                                    class="text-lg font-medium text-gray-900 mb-4"
                                >
                                    {{ stat.year }}
                                    <span
                                        v-if="stat.is_current"
                                        class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                    >
                                        Current
                                    </span>
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Mahasiswa:</span
                                        >
                                        <span
                                            class="text-sm font-bold text-blue-600"
                                            >{{
                                                formatNumber(
                                                    stat.total_students
                                                )
                                            }}</span
                                        >
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Kemitraan:</span
                                        >
                                        <span
                                            class="text-sm font-bold text-green-600"
                                            >{{
                                                formatNumber(
                                                    stat.total_partnerships
                                                )
                                            }}</span
                                        >
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Alumni:</span
                                        >
                                        <span
                                            class="text-sm font-bold text-purple-600"
                                            >{{
                                                formatNumber(stat.total_alumni)
                                            }}</span
                                        >
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Dosen:</span
                                        >
                                        <span
                                            class="text-sm font-bold text-orange-600"
                                            >{{
                                                formatNumber(
                                                    stat.total_lecturers
                                                )
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <div v-if="nextYear" class="text-center">
                                <h3
                                    class="text-lg font-medium text-gray-900 mb-4"
                                >
                                    {{ nextYear.year }}
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Mahasiswa:</span
                                        >
                                        <span class="text-sm font-medium">{{
                                            formatNumber(
                                                nextYear.total_students
                                            )
                                        }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Kemitraan:</span
                                        >
                                        <span class="text-sm font-medium">{{
                                            formatNumber(
                                                nextYear.total_partnerships
                                            )
                                        }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Alumni:</span
                                        >
                                        <span class="text-sm font-medium">{{
                                            formatNumber(nextYear.total_alumni)
                                        }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600"
                                            >Dosen:</span
                                        >
                                        <span class="text-sm font-medium">{{
                                            formatNumber(
                                                nextYear.total_lecturers
                                            )
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Quick Actions
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <Link
                            :href="`/admin/stats/${stat.id}/edit`"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <PencilIcon class="h-4 w-4 mr-2" />
                            Edit Data
                        </Link>

                        <button
                            v-if="!stat.is_current"
                            @click="setCurrent"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-green-300 shadow-sm text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            <CheckCircleIcon class="h-4 w-4 mr-2" />
                            Set as Current
                        </button>

                        <button
                            @click="handleDelete"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            <TrashIcon class="h-4 w-4 mr-2" />
                            Delete Data
                        </button>
                    </div>
                </div>

                <!-- Navigation -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Navigation
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <Link
                            v-if="previousYear"
                            :href="`/admin/stats/${previousYear.id}`"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            <ArrowLeftIcon class="h-4 w-4 mr-2" />
                            {{ previousYear.year }}
                        </Link>

                        <Link
                            v-if="nextYear"
                            :href="`/admin/stats/${nextYear.id}`"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            {{ nextYear.year }}
                            <ArrowRightIcon class="h-4 w-4 ml-2" />
                        </Link>
                    </div>
                </div>

                <!-- Metadata -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Metadata
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Status
                            </label>
                            <span
                                :class="
                                    stat.is_current
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800'
                                "
                                class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            >
                                {{
                                    stat.is_current
                                        ? "Current Year"
                                        : "Historical Data"
                                }}
                            </span>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Created At
                            </label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ formatDateTime(stat.created_at) }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Last Updated
                            </label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ formatDateTime(stat.updated_at) }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Record ID
                            </label>
                            <p class="mt-1 text-sm text-gray-500 font-mono">
                                #{{ stat.id }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    ArrowLeftIcon,
    ArrowRightIcon,
    PencilIcon,
    TrashIcon,
    CheckCircleIcon,
    UsersIcon,
    BuildingOfficeIcon,
    AcademicCapIcon,
    UserGroupIcon,
    TrendingUpIcon,
    TrendingDownIcon,
    MinusIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    stat: {
        type: Object,
        required: true,
    },
    previousYear: {
        type: Object,
        default: null,
    },
    nextYear: {
        type: Object,
        default: null,
    },
    growthRates: {
        type: Object,
        default: null,
    },
});

// Composables
const { success, error, confirmDelete } = useSwal();

// Methods
const formatNumber = (number) => {
    if (number === null || number === undefined) return "0";
    return new Intl.NumberFormat("id-ID").format(number);
};

const formatDateTime = (dateString) => {
    if (!dateString) return "-";
    return new Date(dateString).toLocaleString("id-ID");
};

const getGrowthClass = (rate) => {
    if (rate > 0) return "text-green-600";
    if (rate < 0) return "text-red-600";
    return "text-gray-600";
};

const getGrowthIcon = (rate) => {
    if (rate > 0) return TrendingUpIcon;
    if (rate < 0) return TrendingDownIcon;
    return MinusIcon;
};

const formatGrowthRate = (rate) => {
    const sign = rate > 0 ? "+" : "";
    return `${sign}${Math.abs(rate)}%`;
};

const setCurrent = () => {
    router.patch(
        route("admin.stats.set-current", props.stat.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                success(
                    "Berhasil!",
                    `Data tahun ${props.stat.year} berhasil diset sebagai data terkini.`
                );
            },
            onError: (errors) => {
                console.log("Set current errors:", errors);
                error("Error!", "Terjadi kesalahan saat mengubah status data.");
            },
        }
    );
};

const handleDelete = async () => {
    const result = await confirmDelete(
        "Hapus Data Statistik?",
        `Data statistik tahun ${props.stat.year} akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/stats/${props.stat.id}`, {
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
</script>
