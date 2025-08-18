<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <Link
                            :href="route('super-admin.khs.index')"
                            class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-1" />
                            Kembali ke KHS Management
                        </Link>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="route('super-admin.khs.periods.create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PlusIcon class="w-4 h-4 mr-2" />
                            Tambah Period
                        </Link>
                    </div>
                </div>
                <div class="mt-4">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Kelola Period Akademik
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Kelola semester dan tahun akademik untuk sistem KHS
                    </p>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <CalendarIcon class="h-8 w-8 text-blue-600" />
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">
                            Total Period
                        </div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ periods.length }}
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <CheckCircleIcon class="h-8 w-8 text-green-600" />
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">
                            Period Aktif
                        </div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ activePeriods }}
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <DocumentTextIcon class="h-8 w-8 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">
                            Total KHS Files
                        </div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ totalKhsFiles }}
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
            >
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <AcademicCapIcon class="h-8 w-8 text-yellow-600" />
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-500">
                            Tahun Akademik
                        </div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ uniqueYears }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Periods Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">
                    Daftar Period Akademik
                </h2>
            </div>
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Period
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Tahun & Semester
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Tanggal
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                KHS Files
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="periods.length === 0">
                            <td colspan="6" class="px-6 py-12 text-center">
                                <CalendarIcon
                                    class="mx-auto h-12 w-12 text-gray-400"
                                />
                                <h3
                                    class="mt-4 text-lg font-medium text-gray-900"
                                >
                                    Belum ada period akademik
                                </h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    Mulai dengan menambahkan period akademik
                                    baru.
                                </p>
                                <div class="mt-6">
                                    <Link
                                        :href="
                                            route(
                                                'super-admin.khs.periods.create'
                                            )
                                        "
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        <PlusIcon class="w-4 h-4 mr-2" />
                                        Tambah Period
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        <tr
                            v-for="period in periods"
                            :key="period.id"
                            class="hover:bg-gray-50"
                        >
                            <!-- Period Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            :class="[
                                                'h-10 w-10 rounded-full flex items-center justify-center',
                                                period.is_active
                                                    ? 'bg-green-100'
                                                    : 'bg-gray-100',
                                            ]"
                                        >
                                            <CalendarIcon
                                                :class="[
                                                    'h-5 w-5',
                                                    period.is_active
                                                        ? 'text-green-600'
                                                        : 'text-gray-600',
                                                ]"
                                            />
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ period.name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ period.academic_year }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Year & Semester -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    Tahun {{ period.year }}
                                </div>
                                <div class="text-sm text-gray-500 capitalize">
                                    Semester {{ period.semester }}
                                </div>
                            </td>

                            <!-- Date Range -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ formatDate(period.start_date) || "-" }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    s/d {{ formatDate(period.end_date) || "-" }}
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        period.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-800',
                                    ]"
                                >
                                    {{
                                        period.is_active
                                            ? "Aktif"
                                            : "Tidak Aktif"
                                    }}
                                </span>
                            </td>

                            <!-- KHS Files Count -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ period.khs_files_count || 0 }} file
                                </div>
                                <div class="text-sm text-gray-500">
                                    KHS terupload
                                </div>
                            </td>

                            <!-- Actions -->
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <div
                                    class="flex items-center justify-end space-x-2"
                                >
                                    <!-- Activate/Deactivate -->
                                    <button
                                        v-if="!period.is_active"
                                        @click="activatePeriod(period)"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    >
                                        <CheckIcon class="h-4 w-4 mr-1" />
                                        Aktifkan
                                    </button>

                                    <!-- Edit -->
                                    <Link
                                        :href="
                                            route(
                                                'super-admin.khs.periods.edit',
                                                period.id
                                            )
                                        "
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        <PencilIcon class="h-4 w-4 mr-1" />
                                        Edit
                                    </Link>

                                    <!-- Delete -->
                                    <button
                                        @click="deletePeriod(period)"
                                        :disabled="period.khs_files_count > 0"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    >
                                        <TrashIcon class="h-4 w-4 mr-1" />
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed, onMounted } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    ArrowLeftIcon,
    PlusIcon,
    CalendarIcon,
    CheckCircleIcon,
    DocumentTextIcon,
    AcademicCapIcon,
    CheckIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    periods: {
        type: Array,
        default: () => [],
    },
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Computed
const activePeriods = computed(() => {
    return props.periods.filter((period) => period.is_active).length;
});

const totalKhsFiles = computed(() => {
    return props.periods.reduce(
        (total, period) => total + (period.khs_files_count || 0),
        0
    );
});

const uniqueYears = computed(() => {
    const years = [...new Set(props.periods.map((period) => period.year))];
    return years.length;
});

// Methods
const formatDate = (date) => {
    if (!date) return null;
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const activatePeriod = async (period) => {
    const result = await confirmDelete(
        "Aktifkan Period?",
        `Apakah Anda yakin ingin mengaktifkan period ${period.name}? Period lain akan dinonaktifkan.`
    );

    if (result.isConfirmed) {
        router.post(
            route("super-admin.khs.periods.activate", period.id),
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    success(
                        "Berhasil!",
                        `Period ${period.name} berhasil diaktifkan.`
                    );
                },
                onError: (errors) => {
                    error("Error!", "Gagal mengaktifkan period.");
                },
            }
        );
    }
};

const deletePeriod = async (period) => {
    if (period.khs_files_count > 0) {
        error(
            "Tidak Dapat Dihapus!",
            "Period yang memiliki file KHS tidak dapat dihapus."
        );
        return;
    }

    const result = await confirmDelete(
        "Hapus Period?",
        `Period ${period.name} akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(route("super-admin.khs.periods.destroy", period.id), {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Period berhasil dihapus.");
            },
            onError: (errors) => {
                error("Error!", "Terjadi kesalahan saat menghapus period.");
            },
        });
    }
};

const handleFlashMessages = () => {
    try {
        const flash = page.props.value?.flash;
        if (flash?.message) {
            if (flash.type === "success") {
                success("Berhasil!", flash.message);
            } else if (flash.type === "warning") {
                error("Peringatan!", flash.message);
            } else if (flash.type === "error") {
                error("Error!", flash.message);
            }
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
