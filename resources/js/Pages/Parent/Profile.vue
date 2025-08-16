<!-- resources/js/Pages/Parent/Profile.vue -->
<template>
    <ParentLayout :student="student" :parent="parent">
        <div class="space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Profil Mahasiswa</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Informasi lengkap mahasiswa dan ringkasan KHS
                </p>
            </div>

            <!-- Student Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Mahasiswa</h3>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- Photo Placeholder -->
                        <div class="sm:col-span-6">
                            <div class="flex items-center">
                                <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center">
                                    <UserIcon class="h-10 w-10 text-gray-400" />
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ student.name }}</h4>
                                    <p class="text-sm text-gray-500">{{ student.nim }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Info -->
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">NIM</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ student.nim }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ student.name }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ student.email || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ student.phone || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ student.gender || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ student.birth_place ? `${student.birth_place}, ` : '' }}{{ formatDate(student.birth_date) || '-' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-6">
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ student.address || '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Akademik</h3>

                    <dl class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ student.program_studi || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Semester</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ student.semester || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Tahun Masuk</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ student.tahun_masuk || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        student.status_badge
                                    ]"
                                >
                                    {{ student.status || 'Unknown' }}
                                </span>
                            </dd>
                        </div>
                        <div v-if="student.ipk" class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">IPK</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono text-lg font-semibold">{{ student.ipk }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- KHS Summary -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Ringkasan KHS</h3>
                        <Link
                            :href="route('parent.khs.index')"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Lihat semua KHS
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <DocumentTextIcon class="h-6 w-6 text-blue-600" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-900">Total KHS</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ khsSummary.total_files }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <CalendarIcon class="h-6 w-6 text-green-600" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-900">Periode Terbaru</p>
                                    <p class="text-sm font-semibold text-green-600">
                                        {{ khsSummary.latest_period?.name || 'Belum ada' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <CalendarIcon class="h-6 w-6 text-purple-600" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-purple-900">Periode Pertama</p>
                                    <p class="text-sm font-semibold text-purple-600">
                                        {{ khsSummary.first_period?.name || 'Belum ada' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parent Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Akun Orang Tua</h3>

                    <dl class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Nama</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ parent.name }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Hubungan</dt>
                            <dd class="mt-1">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        parent.relation_badge
                                    ]"
                                >
                                    {{ parent.relation_label }}
                                </span>
                            </dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ parent.email || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ parent.phone || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ parent.occupation || '-' }}</dd>
                        </div>
                        <div class="sm:col-span-3">
                            <dt class="text-sm font-medium text-gray-500">Login Terakhir</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ formatDateTime(parent.last_login_at) || 'Belum pernah' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-6">
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ parent.address || '-' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Keamanan Akun</h4>
                                <p class="text-sm text-gray-500">Kelola password dan keamanan akun Anda</p>
                            </div>
                            <Link
                                :href="route('parent.change-password')"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                            >
                                <KeyIcon class="mr-2 h-4 w-4" />
                                Ubah Password
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Access -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Aktivitas Terbaru</h3>
                        <Link
                            :href="route('parent.access-history')"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Lihat semua aktivitas
                        </Link>
                    </div>

                    <div v-if="recentAccess.length === 0" class="text-center py-8">
                        <ClockIcon class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aktivitas</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Aktivitas akses KHS akan muncul di sini
                        </p>
                    </div>

                    <div v-else class="space-y-3">
                        <div
                            v-for="access in recentAccess.slice(0, 5)"
                            :key="access.id"
                            class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"
                        >
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <component
                                        :is="getAccessIcon(access.access_type)"
                                        :class="['h-5 w-5', getAccessColor(access.access_type)]"
                                    />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ access.access_type_label }} KHS
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ access.khs_file?.semester_name }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ formatDateTime(access.accessed_at) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ParentLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import ParentLayout from '@/Layouts/ParentLayout.vue'
import {
    UserIcon,
    DocumentTextIcon,
    CalendarIcon,
    KeyIcon,
    ClockIcon,
    EyeIcon,
    ArrowDownTrayIcon
} from '@heroicons/vue/24/outline'

// Props
const props = defineProps({
    student: Object,
    parent: Object,
    khsSummary: Object,
    recentAccess: Array
})

// Methods
const formatDate = (dateString) => {
    if (!dateString) return null
    const date = new Date(dateString)
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

const formatDateTime = (dateString) => {
    if (!dateString) return null
    const date = new Date(dateString)
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

const getAccessIcon = (accessType) => {
    switch (accessType) {
        case 'download':
            return ArrowDownTrayIcon
        case 'view':
        case 'preview':
            return EyeIcon
        default:
            return DocumentTextIcon
    }
}

const getAccessColor = (accessType) => {
    switch (accessType) {
        case 'download':
            return 'text-green-600'
        case 'view':
        case 'preview':
            return 'text-blue-600'
        default:
            return 'text-gray-600'
    }
}
</script>

<!-- resources/js/Pages/Parent/AccessHistory.vue -->
<template>
    <ParentLayout :student="student">
        <div class="space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Akses KHS</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Semua aktivitas akses KHS untuk {{ student.name }} ({{ student.nim }})
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Akses</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ accessLogs.length }}</dd>
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Views</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ accessLogs.filter(log => log.access_type === 'view').length }}
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
                                <ArrowDownTrayIcon class="h-6 w-6 text-green-600" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Downloads</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ accessLogs.filter(log => log.access_type === 'download').length }}
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
                                <DocumentTextIcon class="h-6 w-6 text-purple-600" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">File Unik</dt>
                                    <dd class="text-lg font-medium text-gray-900">
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
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Aktivitas</h3>

                    <div v-if="Object.keys(groupedLogs).length === 0" class="text-center py-12">
                        <ClockIcon class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada aktivitas</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Riwayat akses KHS akan muncul di sini setelah Anda mengakses file KHS
                        </p>
                    </div>

                    <div v-else class="space-y-6">
                        <div
                            v-for="(logs, date) in groupedLogs"
                            :key="date"
                            class="border border-gray-200 rounded-lg overflow-hidden"
                        >
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
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
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <component
                                                    :is="getAccessIcon(log.access_type)"
                                                    :class="['h-5 w-5', getAccessColor(log.access_type)]"
                                                />
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ log.access_type_label }} KHS
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ log.khs_file?.semester_name }}
                                                    <span class="mx-2">•</span>
                                                    {{ log.khs_file?.academic_period?.academic_year }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-900">
                                                {{ formatTime(log.accessed_at) }}
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
import { computed } from 'vue'
import ParentLayout from '@/Layouts/ParentLayout.vue'
import {
    ClockIcon,
    EyeIcon,
    ArrowDownTrayIcon,
    DocumentTextIcon
} from '@heroicons/vue/24/outline'

// Props
const props = defineProps({
    accessLogs: Array,
    groupedLogs: Object,
    student: Object
})

// Computed
const uniqueFiles = computed(() => {
    const fileIds = props.accessLogs.map(log => log.khs_file_id)
    return [...new Set(fileIds)].length
})

// Methods
const formatDateHeader = (dateString) => {
    const date = new Date(dateString)
    const today = new Date()
    const yesterday = new Date(today)
    yesterday.setDate(yesterday.getDate() - 1)

    if (date.toDateString() === today.toDateString()) {
        return 'Hari Ini'
    } else if (date.toDateString() === yesterday.toDateString()) {
        return 'Kemarin'
    } else {
        return date.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        })
    }
}

const formatTime = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    })
}

const getAccessIcon = (accessType) => {
    switch (accessType) {
        case 'download':
            return ArrowDownTrayIcon
        case 'view':
        case 'preview':
            return EyeIcon
        default:
            return DocumentTextIcon
    }
}

const getAccessColor = (accessType) => {
    switch (accessType) {
        case 'download':
            return 'text-green-600'
        case 'view':
        case 'preview':
            return 'text-blue-600'
        default:
            return 'text-gray-600'
    }
}
</script>
