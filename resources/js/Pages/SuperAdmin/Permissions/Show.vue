<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Permission
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi lengkap permission "{{ permission.name }}"
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="
                                route(
                                    'super-admin.permissions.edit',
                                    permission.id
                                )
                            "
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit Permission
                        </Link>
                        <Link
                            :href="route('super-admin.permissions.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Permission Information -->
            <div class="lg:col-span-1">
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">
                            Informasi Permission
                        </h2>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Nama Permission
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 font-semibold flex items-center"
                                >
                                    <ShieldCheckIcon
                                        class="h-4 w-4 text-gray-400 mr-2"
                                    />
                                    {{ permission.name }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Guard
                                </dt>
                                <dd class="mt-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                    >
                                        {{ permission.guard_name }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Kategori
                                </dt>
                                <dd class="mt-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize"
                                    >
                                        {{ permissionCategory }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Jumlah Role
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{
                                        permission.roles
                                            ? permission.roles.length
                                            : 0
                                    }}
                                    role
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Tanggal Dibuat
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ formatDate(permission.created_at) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Terakhir Diubah
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ formatDate(permission.updated_at) }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Roles with this permission -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">
                            Role yang Memiliki Permission Ini
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Daftar role yang memiliki permission "{{
                                permission.name
                            }}"
                        </p>
                    </div>
                    <div class="p-6">
                        <div
                            v-if="
                                permission.roles && permission.roles.length > 0
                            "
                        >
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    v-for="role in permission.roles"
                                    :key="role.id"
                                    class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-md"
                                >
                                    <div class="flex items-center">
                                        <UserGroupIcon
                                            class="h-5 w-5 text-gray-400 mr-3"
                                        />
                                        <div>
                                            <div
                                                class="text-sm font-medium text-gray-900"
                                            >
                                                {{ role.name }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ role.guard_name }}
                                            </div>
                                        </div>
                                    </div>
                                    <Link
                                        :href="
                                            route(
                                                'super-admin.roles.show',
                                                role.id
                                            )
                                        "
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                    >
                                        <EyeIcon class="h-3 w-3 mr-1" />
                                        Lihat
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-12">
                            <UserGroupIcon
                                class="mx-auto h-12 w-12 text-gray-400"
                            />
                            <h3 class="mt-4 text-sm font-medium text-gray-900">
                                Tidak ada role
                            </h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Permission ini belum diberikan kepada role
                                apapun.
                            </p>
                            <div class="mt-6">
                                <Link
                                    :href="route('super-admin.roles.index')"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Kelola Role
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permission Usage Statistics -->
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Statistik Penggunaan
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                {{
                                    permission.roles
                                        ? permission.roles.length
                                        : 0
                                }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Role menggunakan permission ini
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ totalUsers }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Total pengguna terpengaruh
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">
                                {{ permissionCategory }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Kategori permission
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    PencilIcon,
    ShieldCheckIcon,
    UserGroupIcon,
    EyeIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    permission: {
        type: Object,
        required: true,
    },
});

// Computed
const permissionCategory = computed(() => {
    return props.permission.name.split(".")[0] || "other";
});

const totalUsers = computed(() => {
    if (!props.permission.roles) return 0;

    return props.permission.roles.reduce((total, role) => {
        return total + (role.users_count || 0);
    }, 0);
});

// Methods
const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};
</script>
