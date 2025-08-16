<!-- resources/js/Pages/Parent/Khs/Detail.vue -->
<template>
    <ParentLayout :student="student">
        <div class="space-y-6">
            <!-- Back Button -->
            <div>
                <Link
                    :href="route('parent.khs.index')"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700"
                >
                    <ChevronLeftIcon class="mr-2 h-4 w-4" />
                    Kembali ke Daftar KHS
                </Link>
            </div>

            <!-- Header -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center"
                                >
                                    <DocumentTextIcon
                                        class="h-6 w-6 text-indigo-600"
                                    />
                                </div>
                            </div>
                            <div class="ml-4">
                                <h1 class="text-2xl font-bold text-gray-900">
                                    {{ khsFile.semester_name }}
                                </h1>
                                <p class="text-sm text-gray-600">
                                    {{ khsFile.academic_period?.display_name }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button
                                @click="previewKhs"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <EyeIcon class="mr-2 h-4 w-4" />
                                Preview
                            </button>
                            <button
                                @click="downloadKhs"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <ArrowDownTrayIcon class="mr-2 h-4 w-4" />
                                Download PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Informasi File
                    </h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Nama File
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ khsFile.original_filename }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Ukuran File
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ khsFile.file_size_human }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Tanggal Upload
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ formatDate(khsFile.upload_date) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Status
                            </dt>
                            <dd class="mt-1">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        khsFile.status_badge_class,
                                    ]"
                                >
                                    {{ khsFile.status_label }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Jumlah Akses
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ khsFile.access_count || 0 }} kali
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Terakhir Diakses
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{
                                    khsFile.last_accessed_human ||
                                    "Belum pernah"
                                }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Student Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Informasi Mahasiswa
                    </h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                NIM
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">
                                {{ student.nim }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Nama Lengkap
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ student.name }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Program Studi
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ student.program_studi || "-" }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Semester
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ student.semester || "-" }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Status
                            </dt>
                            <dd class="mt-1">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        student.status_badge,
                                    ]"
                                >
                                    {{ student.status || "Unknown" }}
                                </span>
                            </dd>
                        </div>
                        <div v-if="student.ipk">
                            <dt class="text-sm font-medium text-gray-500">
                                IPK
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">
                                {{ student.ipk }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Academic Period Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Informasi Periode Akademik
                    </h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Nama Periode
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ khsFile.academic_period?.name }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Tahun Akademik
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ khsFile.academic_period?.academic_year }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Tahun
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ khsFile.academic_period?.year }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Semester
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ khsFile.academic_period?.semester_label }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-medium text-blue-900">
                            Aksi Cepat
                        </h3>
                        <p class="text-sm text-blue-700 mt-1">
                            Pilihan untuk mengakses file KHS ini
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button
                            @click="previewKhs"
                            class="inline-flex items-center px-3 py-2 border border-blue-300 rounded-md text-sm font-medium text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <EyeIcon class="mr-2 h-4 w-4" />
                            Lihat Online
                        </button>
                        <button
                            @click="downloadKhs"
                            class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <ArrowDownTrayIcon class="mr-2 h-4 w-4" />
                            Download
                        </button>
                    </div>
                </div>
            </div>

            <!-- Help Text -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex">
                    <InformationCircleIcon
                        class="h-5 w-5 text-gray-600 mt-0.5"
                    />
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-gray-900">
                            Panduan Penggunaan
                        </h4>
                        <div class="mt-2 text-sm text-gray-600">
                            <ul class="list-disc list-inside space-y-1">
                                <li>
                                    <strong>Lihat Online:</strong> Membuka file
                                    KHS di browser untuk dibaca langsung
                                </li>
                                <li>
                                    <strong>Download:</strong> Mengunduh file
                                    KHS ke perangkat Anda
                                </li>
                                <li>
                                    File dalam format PDF dan dapat dibuka
                                    dengan aplikasi pembaca PDF
                                </li>
                                <li>
                                    Jika mengalami masalah, silakan hubungi
                                    bagian akademik
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ParentLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import ParentLayout from "@/Layouts/ParentLayout.vue";
import {
    DocumentTextIcon,
    EyeIcon,
    ArrowDownTrayIcon,
    ChevronLeftIcon,
    InformationCircleIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    khsFile: Object,
    student: Object,
});

// Methods
const previewKhs = () => {
    window.open(route("parent.khs.preview", props.khsFile.id), "_blank");
};

const downloadKhs = () => {
    window.location.href = route("parent.khs.download", props.khsFile.id);
};

const formatDate = (dateString) => {
    if (!dateString) return "-";
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>
