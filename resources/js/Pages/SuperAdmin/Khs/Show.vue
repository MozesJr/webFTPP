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
                            Kembali ke Daftar KHS
                        </Link>
                    </div>
                    <div class="flex space-x-3">
                        <!-- Download Button -->
                        <a
                            v-if="khsFile.can_download"
                            :href="khsFile.gdrive_download_url"
                            target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowDownTrayIcon class="w-4 h-4 mr-2" />
                            Download PDF
                        </a>

                        <!-- Retry Button -->
                        <button
                            v-if="khsFile.upload_status === 'failed'"
                            @click="retryUpload"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowPathIcon class="w-4 h-4 mr-2" />
                            Retry Upload
                        </button>

                        <!-- Delete Button -->
                        <button
                            @click="deleteKhs"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <TrashIcon class="w-4 h-4 mr-2" />
                            Hapus File
                        </button>
                    </div>
                </div>
                <div class="mt-4">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Detail KHS - {{ khsFile.student_name }}
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Informasi lengkap dan riwayat akses file KHS
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Student Information -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2
                            class="text-lg font-semibold text-gray-900 flex items-center"
                        >
                            <AcademicCapIcon
                                class="w-5 h-5 mr-2 text-blue-600"
                            />
                            Informasi Mahasiswa
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Nama Lengkap
                                </label>
                                <p class="text-sm text-gray-900 font-medium">
                                    {{ khsFile.student_name }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    NIM
                                </label>
                                <p class="text-sm text-gray-900 font-medium">
                                    {{ khsFile.student_nim }}
                                </p>
                            </div>
                            <div v-if="khsFile.student">
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Program Studi
                                </label>
                                <p class="text-sm text-gray-900">
                                    {{ khsFile.student.program_studi || "-" }}
                                </p>
                            </div>
                            <div v-if="khsFile.student">
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Status Mahasiswa
                                </label>
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        khsFile.student.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800',
                                    ]"
                                >
                                    {{
                                        khsFile.student.is_active
                                            ? "Aktif"
                                            : "Tidak Aktif"
                                    }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Information -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2
                            class="text-lg font-semibold text-gray-900 flex items-center"
                        >
                            <DocumentTextIcon
                                class="w-5 h-5 mr-2 text-green-600"
                            />
                            Informasi File
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Nama File Asli
                                </label>
                                <p class="text-sm text-gray-900 break-all">
                                    {{ khsFile.original_filename }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Ukuran File
                                </label>
                                <p class="text-sm text-gray-900">
                                    {{ khsFile.file_size_human }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Status Upload
                                </label>
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        khsFile.status_badge_class,
                                    ]"
                                >
                                    {{ khsFile.status_label }}
                                </span>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Tanggal Upload
                                </label>
                                <p class="text-sm text-gray-900">
                                    {{ formatDate(khsFile.upload_date) }}
                                </p>
                            </div>
                            <div v-if="khsFile.uploader">
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Diupload Oleh
                                </label>
                                <p class="text-sm text-gray-900">
                                    {{ khsFile.uploader.name }}
                                </p>
                            </div>
                            <div v-if="khsFile.gdrive_file_id">
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Google Drive ID
                                </label>
                                <p
                                    class="text-sm text-gray-900 font-mono text-xs break-all"
                                >
                                    {{ khsFile.gdrive_file_id }}
                                </p>
                            </div>
                        </div>

                        <!-- Error Message (if failed) -->
                        <div
                            v-if="
                                khsFile.upload_status === 'failed' &&
                                khsFile.error_message
                            "
                            class="mt-6 p-4 bg-red-50 border border-red-200 rounded-md"
                        >
                            <div class="flex">
                                <ExclamationTriangleIcon
                                    class="h-5 w-5 text-red-400"
                                />
                                <div class="ml-3">
                                    <h3
                                        class="text-sm font-medium text-red-800"
                                    >
                                        Error Upload
                                    </h3>
                                    <p class="mt-2 text-sm text-red-700">
                                        {{ khsFile.error_message }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Access Logs -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2
                            class="text-lg font-semibold text-gray-900 flex items-center"
                        >
                            <ClockIcon class="w-5 h-5 mr-2 text-purple-600" />
                            Riwayat Akses
                            <span
                                class="ml-2 text-sm font-normal text-gray-500"
                            >
                                ({{ khsFile.access_logs?.length || 0 }} akses)
                            </span>
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div
                            v-if="
                                khsFile.access_logs &&
                                khsFile.access_logs.length > 0
                            "
                            class="space-y-4"
                        >
                            <div
                                v-for="log in khsFile.access_logs.slice(0, 10)"
                                :key="log.id"
                                class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0"
                            >
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center"
                                        >
                                            <UserIcon
                                                class="h-4 w-4 text-purple-600"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{
                                                log.parent?.name ||
                                                "Unknown User"
                                            }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ log.access_type || "view" }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-900">
                                        {{ formatDate(log.accessed_at) }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{
                                            log.user_agent
                                                ? getDeviceInfo(log.user_agent)
                                                : "-"
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div
                                v-if="khsFile.access_logs.length > 10"
                                class="text-center pt-4"
                            >
                                <p class="text-sm text-gray-500">
                                    Dan
                                    {{ khsFile.access_logs.length - 10 }} akses
                                    lainnya...
                                </p>
                            </div>
                        </div>
                        <div v-else class="text-center py-8">
                            <ClockIcon
                                class="mx-auto h-12 w-12 text-gray-400"
                            />
                            <h3 class="mt-4 text-sm font-medium text-gray-900">
                                Belum ada akses
                            </h3>
                            <p class="mt-2 text-sm text-gray-500">
                                File belum pernah diakses oleh siapapun.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Stats & Actions -->
            <div class="space-y-6">
                <!-- Period Information -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2
                            class="text-lg font-semibold text-gray-900 flex items-center"
                        >
                            <CalendarIcon
                                class="w-5 h-5 mr-2 text-indigo-600"
                            />
                            Period Akademik
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Nama Period
                                </label>
                                <p class="text-sm text-gray-900 font-medium">
                                    {{
                                        khsFile.academic_period?.name ||
                                        khsFile.semester_name
                                    }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Tahun Akademik
                                </label>
                                <p class="text-sm text-gray-900">
                                    {{ khsFile.academic_period?.academic_year }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 mb-1"
                                >
                                    Semester
                                </label>
                                <p class="text-sm text-gray-900 capitalize">
                                    {{ khsFile.academic_period?.semester }}
                                </p>
                            </div>
                            <div v-if="khsFile.academic_period?.is_active">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                >
                                    Period Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Access Statistics -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2
                            class="text-lg font-semibold text-gray-900 flex items-center"
                        >
                            <ChartBarIcon
                                class="w-5 h-5 mr-2 text-yellow-600"
                            />
                            Statistik Akses
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500"
                                    >Total Akses</span
                                >
                                <span class="text-lg font-bold text-gray-900">
                                    {{ accessStats?.total_access || 0 }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500"
                                    >Pengguna Unik</span
                                >
                                <span class="text-lg font-bold text-gray-900">
                                    {{ accessStats?.unique_users || 0 }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500"
                                    >Akses Terakhir</span
                                >
                                <span class="text-sm text-gray-900">
                                    {{
                                        khsFile.last_accessed_human ||
                                        "Belum pernah"
                                    }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500"
                                    >Akses Hari Ini</span
                                >
                                <span class="text-lg font-bold text-gray-900">
                                    {{ accessStats?.today_access || 0 }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500"
                                    >Akses Minggu Ini</span
                                >
                                <span class="text-lg font-bold text-gray-900">
                                    {{ accessStats?.week_access || 0 }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2
                            class="text-lg font-semibold text-gray-900 flex items-center"
                        >
                            <CogIcon class="w-5 h-5 mr-2 text-gray-600" />
                            Aksi Cepat
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <!-- Preview PDF -->
                        <a
                            v-if="khsFile.can_download"
                            :href="
                                khsFile.gdrive_preview_url ||
                                khsFile.gdrive_download_url
                            "
                            target="_blank"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            <EyeIcon class="w-4 h-4 mr-2" />
                            Preview PDF
                        </a>

                        <!-- Share Link -->
                        <button
                            v-if="khsFile.can_download"
                            @click="copyShareLink"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            <LinkIcon class="w-4 h-4 mr-2" />
                            Copy Link
                        </button>

                        <!-- Generate Report -->
                        <Link
                            :href="
                                route(
                                    'super-admin.khs.report',
                                    khsFile.academic_period_id
                                )
                            "
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            <DocumentChartBarIcon class="w-4 h-4 mr-2" />
                            Report Period
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { onMounted } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    ArrowLeftIcon,
    ArrowDownTrayIcon,
    ArrowPathIcon,
    TrashIcon,
    AcademicCapIcon,
    DocumentTextIcon,
    ClockIcon,
    CalendarIcon,
    ChartBarIcon,
    CogIcon,
    EyeIcon,
    LinkIcon,
    UserIcon,
    ExclamationTriangleIcon,
    DocumentChartBarIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    khsFile: {
        type: Object,
        required: true,
    },
    accessStats: {
        type: Object,
        default: () => ({}),
    },
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const getDeviceInfo = (userAgent) => {
    if (!userAgent) return "-";

    // Simple device detection
    if (userAgent.includes("Mobile")) return "Mobile";
    if (userAgent.includes("Tablet")) return "Tablet";
    if (userAgent.includes("Windows")) return "Windows";
    if (userAgent.includes("Mac")) return "Mac";
    if (userAgent.includes("Linux")) return "Linux";

    return "Unknown";
};

const retryUpload = async () => {
    const result = await confirmDelete(
        "Retry Upload?",
        `Apakah Anda yakin ingin retry upload untuk ${props.khsFile.student_name}?`
    );

    if (result.isConfirmed) {
        router.post(
            route("super-admin.khs.retry", props.khsFile.id),
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    success("Berhasil!", "File ditandai untuk retry upload.");
                },
                onError: (errors) => {
                    error("Error!", "Gagal retry upload.");
                },
            }
        );
    }
};

const deleteKhs = async () => {
    const result = await confirmDelete(
        "Hapus File KHS?",
        `File KHS untuk ${props.khsFile.student_name} akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(route("super-admin.khs.destroy", props.khsFile.id), {
            onSuccess: () => {
                success("Berhasil!", "File KHS berhasil dihapus.");
                router.visit(route("super-admin.khs.index"));
            },
            onError: (errors) => {
                error("Error!", "Terjadi kesalahan saat menghapus file.");
            },
        });
    }
};

const copyShareLink = async () => {
    try {
        const url = props.khsFile.gdrive_download_url || window.location.href;
        await navigator.clipboard.writeText(url);
        success("Berhasil!", "Link berhasil disalin ke clipboard.");
    } catch (err) {
        error("Error!", "Gagal menyalin link.");
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
