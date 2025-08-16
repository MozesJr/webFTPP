<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Orang Tua
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi lengkap akun orang tua "{{ parent.name }}"
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <button
                            @click="resetPassword"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <KeyIcon class="w-4 h-4 mr-2" />
                            Reset Password
                        </button>
                        <Link
                            :href="route('super-admin.parents.edit', parent.id)"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit Data
                        </Link>
                        <Link
                            :href="route('super-admin.parents.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Parent Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Data Orang Tua
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-16 w-16">
                            <div
                                class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center"
                            >
                                <UserIcon class="h-8 w-8 text-indigo-600" />
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-medium text-gray-900">
                                {{ parent.name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ parent.email || "Tidak ada email" }}
                            </div>
                        </div>
                    </div>

                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Username
                            </dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 font-mono bg-gray-50 px-2 py-1 rounded"
                            >
                                {{ parent.username }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Hubungan
                            </dt>
                            <dd class="mt-1">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        getRelationBadgeClass(parent.relation),
                                    ]"
                                >
                                    {{ getRelationLabel(parent.relation) }}
                                </span>
                            </dd>
                        </div>
                        <div v-if="parent.phone">
                            <dt class="text-sm font-medium text-gray-500">
                                Telepon
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ parent.phone }}
                            </dd>
                        </div>
                        <div v-if="parent.occupation">
                            <dt class="text-sm font-medium text-gray-500">
                                Pekerjaan
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ parent.occupation }}
                            </dd>
                        </div>
                        <div v-if="parent.address">
                            <dt class="text-sm font-medium text-gray-500">
                                Alamat
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ parent.address }}
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
                                        parent.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800',
                                    ]"
                                >
                                    {{
                                        parent.is_active
                                            ? "Aktif"
                                            : "Tidak Aktif"
                                    }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Terakhir Login
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{
                                    formatDate(parent.last_login_at) ||
                                    "Belum pernah login"
                                }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Dibuat
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ formatDate(parent.created_at) }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Student Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Data Siswa
                    </h2>
                </div>
                <div class="p-6">
                    <div v-if="parent.student" class="space-y-4">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 h-16 w-16">
                                <div
                                    class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center"
                                >
                                    <AcademicCapIcon
                                        class="h-8 w-8 text-blue-600"
                                    />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-medium text-gray-900">
                                    {{ parent.student.name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    NIM: {{ parent.student.nim }}
                                </div>
                            </div>
                        </div>

                        <dl class="space-y-4">
                            <div v-if="parent.student.email">
                                <dt class="text-sm font-medium text-gray-500">
                                    Email
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ parent.student.email }}
                                </dd>
                            </div>
                            <div v-if="parent.student.phone">
                                <dt class="text-sm font-medium text-gray-500">
                                    Telepon
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ parent.student.phone }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Jenis Kelamin
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{
                                        parent.student.gender === "L"
                                            ? "Laki-laki"
                                            : "Perempuan"
                                    }}
                                </dd>
                            </div>
                            <div v-if="parent.student.birth_date">
                                <dt class="text-sm font-medium text-gray-500">
                                    Tanggal Lahir
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ formatDate(parent.student.birth_date) }}
                                </dd>
                            </div>
                            <div v-if="parent.student.birth_place">
                                <dt class="text-sm font-medium text-gray-500">
                                    Tempat Lahir
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ parent.student.birth_place }}
                                </dd>
                            </div>
                            <div v-if="parent.student.program_studi">
                                <dt class="text-sm font-medium text-gray-500">
                                    Program Studi
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ parent.student.program_studi }}
                                </dd>
                            </div>
                            <div v-if="parent.student.semester">
                                <dt class="text-sm font-medium text-gray-500">
                                    Semester
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ parent.student.semester }}
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
                                            getStatusBadgeClass(
                                                parent.student.status
                                            ),
                                        ]"
                                    >
                                        {{ parent.student.status }}
                                    </span>
                                </dd>
                            </div>
                            <div v-if="parent.student.tahun_masuk">
                                <dt class="text-sm font-medium text-gray-500">
                                    Tahun Masuk
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ parent.student.tahun_masuk }}
                                </dd>
                            </div>
                            <div v-if="parent.student.ipk">
                                <dt class="text-sm font-medium text-gray-500">
                                    IPK
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ parent.student.ipk }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Activity -->
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">
                    Aktivitas Login
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Riwayat aktivitas login orang tua
                </p>
            </div>
            <div class="p-6">
                <div class="text-center py-12">
                    <ClockIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-4 text-sm font-medium text-gray-900">
                        Riwayat Login
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        {{
                            parent.last_login_at
                                ? "Terakhir login: " +
                                  formatDate(parent.last_login_at)
                                : "Belum pernah login"
                        }}
                    </p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    ArrowLeftIcon,
    PencilIcon,
    KeyIcon,
    UserIcon,
    AcademicCapIcon,
    ClockIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    parent: {
        type: Object,
        required: true,
    },
});

// Composables
const { success, error, confirmDelete } = useSwal();

// Methods
const resetPassword = async () => {
    const result = await confirmDelete(
        "Reset Password?",
        `Password untuk "${props.parent.name}" akan direset ke default (${props.parent.username}123)`
    );

    if (result.isConfirmed) {
        try {
            const response = await fetch(
                `/super-admin/parents/${props.parent.id}/reset-password`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                }
            );

            const data = await response.json();

            if (data.success) {
                success("Berhasil!", data.message);
            } else {
                error("Error!", data.message);
            }
        } catch (e) {
            error("Error!", "Terjadi kesalahan saat reset password.");
        }
    }
};

const formatDate = (date) => {
    if (!date) return null;
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const getRelationLabel = (relation) => {
    const labels = {
        ayah: "Ayah",
        ibu: "Ibu",
        wali: "Wali",
    };
    return labels[relation] || relation;
};

const getRelationBadgeClass = (relation) => {
    const classes = {
        ayah: "bg-blue-100 text-blue-800",
        ibu: "bg-pink-100 text-pink-800",
        wali: "bg-gray-100 text-gray-800",
    };
    return classes[relation] || "bg-gray-100 text-gray-800";
};

const getStatusBadgeClass = (status) => {
    const classes = {
        aktif: "bg-green-100 text-green-800",
        cuti: "bg-yellow-100 text-yellow-800",
        lulus: "bg-blue-100 text-blue-800",
        DO: "bg-red-100 text-red-800",
    };
    return classes[status] || "bg-gray-100 text-gray-800";
};
</script>
