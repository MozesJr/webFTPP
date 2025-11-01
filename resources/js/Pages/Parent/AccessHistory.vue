<!-- resources/js/Pages/Parent/AccessHistory.vue -->
<template>
    <ParentLayout :student="student">
        <div class="space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Riwayat Akses KHS
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    Semua aktivitas akses KHS untuk {{ student.name }} ({{
                        student.nim
                    }})
                </p>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <ClockIcon class="h-6 w-6 text-gray-400" />
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
                                        {{ accessLogs.length }}
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
                                <EyeIcon class="h-6 w-6 text-blue-600" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-gray-500 truncate"
                                    >
                                        Views
                                    </dt>
                                    <dd
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        {{
                                            accessLogs.filter(
                                                (log) =>
                                                    log.access_type === "view"
                                            ).length
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
                                <ArrowDownTrayIcon
                                    class="h-6 w-6 text-green-600"
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
                                            accessLogs.filter(
                                                (log) =>
                                                    log.access_type ===
                                                    "download"
                                            ).length
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
                                <DocumentTextIcon
                                    class="h-6 w-6 text-purple-600"
                                />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt
                                        class="text-sm font-medium text-gray-500 truncate"
                                    >
                                        File Unik
                                    </dt>
                                    <dd
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        {{ uniqueFiles }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Access History -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Riwayat Aktivitas
                    </h3>

                    <div
                        v-if="Object.keys(groupedLogs).length === 0"
                        class="text-center py-12"
                    >
                        <ClockIcon class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            Belum ada aktivitas
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Riwayat akses KHS akan muncul di sini setelah Anda
                            mengakses file KHS
                        </p>
                    </div>

                    <div v-else class="space-y-6">
                        <div
                            v-for="(logs, date) in groupedLogs"
                            :key="date"
                            class="border border-gray-200 rounded-lg overflow-hidden"
                        >
                            <div
                                class="bg-gray-50 px-4 py-3 border-b border-gray-200"
                            >
                                <h4 class="text-sm font-medium text-gray-900">
                                    {{ formatDateHeader(date) }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ logs.length }} aktivitas
                                </p>
                            </div>

                            <div class="divide-y divide-gray-200">
                                <div
                                    v-for="log in logs"
                                    :key="log.id"
                                    class="px-4 py-4 hover:bg-gray-50"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <component
                                                    :is="
                                                        getAccessIcon(
                                                            log.access_type
                                                        )
                                                    "
                                                    :class="[
                                                        'h-5 w-5',
                                                        getAccessColor(
                                                            log.access_type
                                                        ),
                                                    ]"
                                                />
                                            </div>
                                            <div class="ml-4">
                                                <p
                                                    class="text-sm font-medium text-gray-900"
                                                >
                                                    {{
                                                        log.access_type_label
                                                    }}
                                                    KHS
                                                </p>
                                                <p
                                                    class="text-sm text-gray-500"
                                                >
                                                    {{
                                                        log.khs_file
                                                            ?.semester_name
                                                    }}
                                                    <span class="mx-2">•</span>
                                                    {{
                                                        log.khs_file
                                                            ?.academic_period
                                                            ?.academic_year
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-900">
                                                {{
                                                    formatTime(log.accessed_at)
                                                }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ log.ip_address }}
                                            </p>
                                        </div>
                                    </div>
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
import { computed } from "vue";
import ParentLayout from "@/Layouts/ParentLayout.vue";
import {
    ClockIcon,
    EyeIcon,
    ArrowDownTrayIcon,
    DocumentTextIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    accessLogs: Array,
    groupedLogs: Object,
    student: Object,
});

// Computed
const uniqueFiles = computed(() => {
    const fileIds = props.accessLogs.map((log) => log.khs_file_id);
    return [...new Set(fileIds)].length;
});

// Methods
const formatDateHeader = (dateString) => {
    const date = new Date(dateString);
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);

    if (date.toDateString() === today.toDateString()) {
        return "Hari Ini";
    } else if (date.toDateString() === yesterday.toDateString()) {
        return "Kemarin";
    } else {
        return date.toLocaleDateString("id-ID", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        });
    }
};

const formatTime = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
    });
};

const getAccessIcon = (accessType) => {
    switch (accessType) {
        case "download":
            return ArrowDownTrayIcon;
        case "view":
        case "preview":
            return EyeIcon;
        default:
            return DocumentTextIcon;
    }
};

const getAccessColor = (accessType) => {
    switch (accessType) {
        case "download":
            return "text-green-600";
        case "view":
        case "preview":
            return "text-blue-600";
        default:
            return "text-gray-600";
    }
};
</script>
