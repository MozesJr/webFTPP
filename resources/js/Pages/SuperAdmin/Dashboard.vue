<!-- resources/js/Pages/SuperAdmin/Dashboard.vue - Fixed Version -->
<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-12xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg mb-8 overflow-hidden"
                >
                    <div class="flex items-center px-8 py-6">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-white mb-2">
                                Selamat Datang Kembali {{ currentUser.name }}!
                                👋
                            </h1>
                            <p class="text-blue-100 text-lg">
                                Panel Super Admin Fakultas Teknik Pertambangan
                                dan Perminyakan
                            </p>
                            <p class="text-blue-200 text-sm mt-2">
                                Kelola sistem, user, dan permissions
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <img
                                src="/storage/assets/img/Logo_Universitas_Papua.png"
                                alt="Welcome"
                                class="w-32 h-32 object-contain"
                            />
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8"
                >
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <UsersIcon class="h-6 w-6 text-blue-400" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Total Users
                                        </dt>
                                        <dd
                                            class="text-lg font-medium text-gray-900"
                                        >
                                            {{ stats.total_users }}
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
                                    <CheckCircleIcon
                                        class="h-6 w-6 text-green-400"
                                    />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Active Users
                                        </dt>
                                        <dd
                                            class="text-lg font-medium text-gray-900"
                                        >
                                            {{ stats.active_users }}
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
                                    <XCircleIcon class="h-6 w-6 text-red-400" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Inactive Users
                                        </dt>
                                        <dd
                                            class="text-lg font-medium text-gray-900"
                                        >
                                            {{ stats.inactive_users }}
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
                                    <ShieldCheckIcon
                                        class="h-6 w-6 text-purple-400"
                                    />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Total Roles
                                        </dt>
                                        <dd
                                            class="text-lg font-medium text-gray-900"
                                        >
                                            {{ stats.total_roles }}
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
                                    <KeyIcon class="h-6 w-6 text-indigo-400" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt
                                            class="text-sm font-medium text-gray-500 truncate"
                                        >
                                            Permissions
                                        </dt>
                                        <dd
                                            class="text-lg font-medium text-gray-900"
                                        >
                                            {{ stats.total_permissions }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Users by Role -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900 mb-4"
                            >
                                Users by Role
                            </h3>
                            <div class="space-y-3">
                                <div
                                    v-for="role in usersByRole"
                                    :key="role.name"
                                    class="flex items-center justify-between"
                                >
                                    <div class="flex items-center">
                                        <div
                                            class="h-3 w-3 rounded-full mr-3"
                                            :class="getRoleColor(role.name)"
                                        ></div>
                                        <span
                                            class="text-sm font-medium text-gray-900"
                                            >{{ role.display_name }}</span
                                        >
                                    </div>
                                    <span class="text-sm text-gray-500"
                                        >{{ role.users_count }} users</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Users -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900 mb-4"
                            >
                                Recent Users
                            </h3>
                            <div class="space-y-3">
                                <div
                                    v-for="user in recentUsers"
                                    :key="user.id"
                                    class="flex items-center justify-between"
                                >
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ user.name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ user.email }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            :class="
                                                user.is_active
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'
                                            "
                                        >
                                            {{
                                                user.is_active
                                                    ? "Active"
                                                    : "Inactive"
                                            }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ user.created_at }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900 mb-4"
                            >
                                Quick Actions
                            </h3>
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                            >
                                <Link
                                    :href="route('super-admin.users.create')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700"
                                >
                                    <PlusIcon class="h-4 w-4 mr-2" />
                                    Add User
                                </Link>

                                <Link
                                    :href="route('super-admin.roles.create')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700"
                                >
                                    <PlusIcon class="h-4 w-4 mr-2" />
                                    Add Role
                                </Link>

                                <Link
                                    :href="route('super-admin.users.index')"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <UsersIcon class="h-4 w-4 mr-2" />
                                    Manage Users
                                </Link>

                                <Link
                                    :href="route('super-admin.roles.index')"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <ShieldCheckIcon class="h-4 w-4 mr-2" />
                                    Manage Roles
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    UsersIcon,
    CheckCircleIcon,
    XCircleIcon,
    ShieldCheckIcon,
    KeyIcon,
    PlusIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            total_users: 0,
            active_users: 0,
            inactive_users: 0,
            total_roles: 0,
            total_permissions: 0,
        }),
    },
    usersByRole: {
        type: Array,
        default: () => [],
    },
    recentUsers: {
        type: Array,
        default: () => [],
    },
    currentUser: {
        type: Object,
        required: true,
    },
});

const getRoleColor = (roleName) => {
    const colors = {
        super_admin: "bg-red-400",
        admin: "bg-blue-400",
        petugas_umum: "bg-green-400",
        orang_tua: "bg-yellow-400",
    };
    return colors[roleName] || "bg-gray-400";
};
</script>
