<!-- resources/js/Pages/Parent/Dashboard.vue -->
<template>
    <ParentLayout :student="student" :parent="parent">
        <div class="space-y-6">
            <!-- Welcome Section -->
            <div
                class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-lg text-white mb-8"
            >
                <div class="px-6 py-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold">
                                Selamat Datang, {{ parent.name }}
                            </h1>
                            <p class="text-blue-100 mt-2">
                                Portal KHS untuk {{ student.name }} ({{
                                    student.nim
                                }})
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <AcademicCapIcon class="h-16 w-16 text-blue-200" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total KHS Files -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <DocumentTextIcon
                                    class="h-6 w-6 text-gray-400"
                                />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-gray-500 truncate"
                                    >
                                        Total KHS
                                    </dt>
                                    <dd
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        {{ totalKhsFiles }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <Link
                                :href="route('parent.khs.index')"
                                class="font-medium text-indigo-700 hover:text-indigo-900"
                            >
                                Lihat semua
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Latest Period -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <CalendarIcon class="h-6 w-6 text-gray-400" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-gray-500 truncate"
                                    >
                                        KHS Terbaru
                                    </dt>
                                    <dd
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{
                                            latestKhs?.semester_name ||
                                            "Belum ada"
                                        }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <button
                                v-if="latestKhs"
                                @click="downloadLatest"
                                class="font-medium text-indigo-700 hover:text-indigo-900"
                            >
                                Download
                            </button>
                            <span v-else class="text-gray-500"
                                >Tidak tersedia</span
                            >
                        </div>
                    </div>
                </div>

                <!-- Total Access -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <EyeIcon class="h-6 w-6 text-gray-400" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-gray-500 truncate"
                                    >
                                        Total Akses
                                    </dt>
                                    <dd
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        {{ accessStats.total_access || 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <Link
                                :href="route('parent.access-history')"
                                class="font-medium text-indigo-700 hover:text-indigo-900"
                            >
                                Lihat riwayat
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Downloads -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <ArrowDownTrayIcon
                                    class="h-6 w-6 text-gray-400"
                                />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-gray-500 truncate"
                                    >
                                        Downloads
                                    </dt>
                                    <dd
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        {{ accessStats.downloads || 0 }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <span class="text-gray-500">30 hari terakhir</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent KHS Files -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            KHS Terbaru
                        </h3>
                        <Link
                            :href="route('parent.khs.index')"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Lihat semua
                        </Link>
                    </div>

                    <div v-if="khsFiles.length === 0" class="text-center py-8">
                        <DocumentTextIcon
                            class="mx-auto h-12 w-12 text-gray-400"
                        />
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            Belum ada KHS
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            File KHS akan tampil di sini setelah diunggah oleh
                            admin.
                        </p>
                    </div>

                    <div v-else class="space-y-3">
                        <div
                            v-for="khs in khsFiles"
                            :key="khs.id"
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <DocumentTextIcon
                                        class="h-8 w-8 text-indigo-600"
                                    />
                                </div>
                                <div class="ml-4">
                                    <h4
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ khs.semester_name }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        {{
                                            khs.academic_period?.display_name
                                        }}
                                        • {{ khs.file_size_human }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button
                                    @click="previewKhs(khs)"
                                    class="inline-flex items-center p-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <EyeIcon class="h-4 w-4" />
                                </button>
                                <button
                                    @click="downloadKhs(khs)"
                                    class="inline-flex items-center p-2 border border-transparent rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                                >
                                    <ArrowDownTrayIcon class="h-4 w-4" />
                                </button>
                                <Link
                                    :href="route('parent.khs.detail', khs.id)"
                                    class="inline-flex items-center p-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <ChevronRightIcon class="h-4 w-4" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Periods with KHS -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Periode Akademik Tersedia
                    </h3>

                    <div
                        v-if="periodsWithKhs.length === 0"
                        class="text-center py-8"
                    >
                        <CalendarIcon class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            Belum ada periode
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Periode akademik dengan KHS akan tampil di sini.
                        </p>
                    </div>

                    <div
                        v-else
                        class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <div
                            v-for="period in periodsWithKhs"
                            :key="period.id"
                            class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm hover:border-gray-400 cursor-pointer"
                            @click="goToPeriodKhs(period)"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-sm font-medium text-gray-900 truncate"
                                    >
                                        {{ period.name }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ period.academic_year }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span
                                        :class="[
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            period.status_badge,
                                        ]"
                                    >
                                        {{
                                            period.is_current
                                                ? "Aktif"
                                                : "Selesai"
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Profile Summary -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            Profil Mahasiswa
                        </h3>
                        <Link
                            :href="route('parent.profile')"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Lihat detail
                        </Link>
                    </div>

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
                        <div v-if="student.semester">
                            <dt class="text-sm font-medium text-gray-500">
                                Semester
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ student.semester }}
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

            <!-- Quick Actions -->
            <div
                class="bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-200 rounded-lg p-6"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-medium text-indigo-900">
                            Aksi Cepat
                        </h3>
                        <p class="text-sm text-indigo-700 mt-1">
                            Akses langsung ke fitur yang sering digunakan
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <Link
                            :href="route('parent.khs.index')"
                            class="inline-flex items-center px-4 py-2 border border-indigo-300 rounded-md text-sm font-medium text-indigo-700 bg-white hover:bg-indigo-50"
                        >
                            <DocumentTextIcon class="mr-2 h-4 w-4" />
                            Lihat Semua KHS
                        </Link>
                        <button
                            v-if="latestKhs"
                            @click="downloadLatest"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                        >
                            <ArrowDownTrayIcon class="mr-2 h-4 w-4" />
                            Download Terbaru
                        </button>
                        <Link
                            :href="route('parent.profile')"
                            class="inline-flex items-center px-4 py-2 border border-indigo-300 rounded-md text-sm font-medium text-indigo-700 bg-white hover:bg-indigo-50"
                        >
                            <UserIcon class="mr-2 h-4 w-4" />
                            Profil
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                <div class="flex">
                    <InformationCircleIcon
                        class="h-5 w-5 text-gray-600 mt-0.5"
                    />
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-gray-900">
                            Panduan Penggunaan Portal
                        </h4>
                        <div class="mt-2 text-sm text-gray-600">
                            <ul class="list-disc list-inside space-y-1">
                                <li>
                                    Gunakan menu
                                    <strong>Daftar KHS</strong> untuk melihat
                                    semua file KHS yang tersedia
                                </li>
                                <li>
                                    Klik tombol <strong>Preview</strong> untuk
                                    melihat KHS online tanpa mengunduh
                                </li>
                                <li>
                                    Klik tombol <strong>Download</strong> untuk
                                    mengunduh file KHS ke perangkat Anda
                                </li>
                                <li>
                                    Semua aktivitas akses KHS akan tercatat
                                    dalam riwayat akses
                                </li>
                                <li>
                                    Hubungi bagian akademik jika mengalami
                                    masalah atau membutuhkan bantuan
                                </li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <a
                                href="mailto:admin@faculty.ac.id"
                                class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500"
                            >
                                <EnvelopeIcon class="mr-2 h-4 w-4" />
                                Hubungi Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ParentLayout>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import ParentLayout from "@/Layouts/ParentLayout.vue";
import {
    AcademicCapIcon,
    DocumentTextIcon,
    CalendarIcon,
    EyeIcon,
    ArrowDownTrayIcon,
    ChevronRightIcon,
    UserIcon,
    InformationCircleIcon,
    EnvelopeIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    student: Object,
    parent: Object,
    khsFiles: Array,
    periodsWithKhs: Array,
    accessStats: Object,
    latestKhs: Object,
    totalKhsFiles: Number,
});

// Methods
const previewKhs = (khs) => {
    window.open(route("parent.khs.preview", khs.id), "_blank");
};

const downloadKhs = (khs) => {
    window.location.href = route("parent.khs.download", khs.id);
};

const downloadLatest = () => {
    if (props.latestKhs) {
        window.location.href = route("parent.khs.download", props.latestKhs.id);
    }
};

const goToPeriodKhs = (period) => {
    router.get(route("parent.khs.index"), { period_id: period.id });
};
</script>
