<!-- resources/js/Pages/Parent/Dashboard.vue (Breeze Compatible) -->
<template>
    <Head title="Dashboard Parent" />

    <ParentLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Welcome Section -->
                        <div
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-lg text-white mb-8"
                        >
                            <div class="px-6 py-8">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h1 class="text-2xl font-bold">
                                            Selamat Datang,
                                            {{ $page.props.auth.parent?.name }}
                                        </h1>
                                        <p class="text-blue-100 mt-2">
                                            Portal KHS untuk
                                            {{ $page.props.auth.student?.name }}
                                            ({{
                                                $page.props.auth.student?.nim
                                            }})
                                        </p>
                                    </div>
                                    <div class="hidden md:block">
                                        <AcademicCapIcon
                                            class="h-16 w-16 text-blue-200"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div
                            class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8"
                        >
                            <!-- Total KHS Files -->
                            <div
                                class="bg-white overflow-hidden shadow rounded-lg border"
                            >
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
                                                    {{ totalKhsFiles || 0 }}
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
                            <div
                                class="bg-white overflow-hidden shadow rounded-lg border"
                            >
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <CalendarIcon
                                                class="h-6 w-6 text-gray-400"
                                            />
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

                            <!-- Access Stats -->
                            <div
                                class="bg-white overflow-hidden shadow rounded-lg border"
                            >
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <EyeIcon
                                                class="h-6 w-6 text-gray-400"
                                            />
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
                                                    {{
                                                        accessStats?.total_access ||
                                                        0
                                                    }}
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3">
                                    <div class="text-sm">
                                        <Link
                                            :href="
                                                route('parent.access-history')
                                            "
                                            class="font-medium text-indigo-700 hover:text-indigo-900"
                                        >
                                            Lihat riwayat
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <!-- Downloads -->
                            <div
                                class="bg-white overflow-hidden shadow rounded-lg border"
                            >
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
                                                    {{
                                                        accessStats?.downloads ||
                                                        0
                                                    }}
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3">
                                    <div class="text-sm">
                                        <span class="text-gray-500"
                                            >30 hari terakhir</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent KHS Files -->
                        <div class="bg-white shadow rounded-lg border">
                            <div class="px-4 py-5 sm:p-6">
                                <div
                                    class="flex items-center justify-between mb-4"
                                >
                                    <h3
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        KHS Terbaru
                                    </h3>
                                    <Link
                                        :href="route('parent.khs.index')"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                                    >
                                        Lihat semua
                                    </Link>
                                </div>

                                <div
                                    v-if="!khsFiles || khsFiles.length === 0"
                                    class="text-center py-8"
                                >
                                    <DocumentTextIcon
                                        class="mx-auto h-12 w-12 text-gray-400"
                                    />
                                    <h3
                                        class="mt-2 text-sm font-medium text-gray-900"
                                    >
                                        Belum ada KHS
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        File KHS akan tampil di sini setelah
                                        diunggah oleh admin.
                                    </p>
                                </div>

                                <div v-else class="space-y-3">
                                    <div
                                        v-for="khs in khsFiles.slice(0, 5)"
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
                                                <p
                                                    class="text-sm text-gray-500"
                                                >
                                                    {{
                                                        khs.academic_period
                                                            ?.display_name
                                                    }}
                                                    • {{ khs.file_size_human }}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center space-x-2"
                                        >
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
                                                <ArrowDownTrayIcon
                                                    class="h-4 w-4"
                                                />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div
                            class="mt-8 bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-200 rounded-lg p-6"
                        >
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3
                                        class="text-base font-medium text-indigo-900"
                                    >
                                        Aksi Cepat
                                    </h3>
                                    <p class="text-sm text-indigo-700 mt-1">
                                        Akses langsung ke fitur yang sering
                                        digunakan
                                    </p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <Link
                                        :href="route('parent.khs.index')"
                                        class="inline-flex items-center px-4 py-2 border border-indigo-300 rounded-md text-sm font-medium text-indigo-700 bg-white hover:bg-indigo-50"
                                    >
                                        <DocumentTextIcon
                                            class="mr-2 h-4 w-4"
                                        />
                                        Lihat Semua KHS
                                    </Link>
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
                    </div>
                </div>
            </div>
        </div>
    </ParentLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ParentLayout from "@/Layouts/ParentLayout.vue";
import {
    AcademicCapIcon,
    DocumentTextIcon,
    CalendarIcon,
    EyeIcon,
    ArrowDownTrayIcon,
    UserIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
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
</script>
