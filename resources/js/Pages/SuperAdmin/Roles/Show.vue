<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Role
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi lengkap role "{{ role.name }}"
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="route('super-admin.roles.edit', role.id)"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit Role
                        </Link>
                        <Link
                            :href="route('super-admin.roles.index')"
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
            <!-- Role Information -->
            <div class="lg:col-span-1">
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">
                            Informasi Role
                        </h2>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Nama Role
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 font-semibold"
                                >
                                    {{ role.name }}
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
                                        {{ role.guard_name }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Jumlah Pengguna
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{
                                        role.users ? role.users.length : 0
                                    }}
                                    pengguna
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Jumlah Permission
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{
                                        role.permissions
                                            ? role.permissions.length
                                            : 0
                                    }}
                                    permission
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Tanggal Dibuat
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ formatDate(role.created_at) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Terakhir Diubah
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ formatDate(role.updated_at) }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">
                            Permission yang Dimiliki
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Daftar permission yang diberikan kepada role ini
                        </p>
                    </div>
                    <div class="p-6">
                        <div
                            v-if="
                                role.permissions && role.permissions.length > 0
                            "
                        >
                            <div
                                v-for="(
                                    permissionGroup, groupName
                                ) in groupedPermissions"
                                :key="groupName"
                                class="mb-6"
                            >
                                <h3
                                    class="text-sm font-medium text-gray-900 mb-3 capitalize bg-gray-50 px-3 py-2 rounded-md"
                                >
                                    {{ groupName }} ({{
                                        permissionGroup.length
                                    }})
                                </h3>
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 pl-4"
                                >
                                    <div
                                        v-for="permission in permissionGroup"
                                        :key="permission.id"
                                        class="flex items-center p-2 bg-green-50 border border-green-200 rounded-md"
                                    >
                                        <CheckCircleIcon
                                            class="h-4 w-4 text-green-500 mr-2"
                                        />
                                        <span class="text-sm text-gray-900">{{
                                            permission.name
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-12">
                            <ShieldExclamationIcon
                                class="mx-auto h-12 w-12 text-gray-400"
                            />
                            <h3 class="mt-4 text-sm font-medium text-gray-900">
                                Tidak ada permission
                            </h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Role ini belum memiliki permission apapun.
                            </p>
                            <div class="mt-6">
                                <Link
                                    :href="
                                        route('super-admin.roles.edit', role.id)
                                    "
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <PlusIcon class="w-4 h-4 mr-2" />
                                    Tambah Permission
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users with this role -->
        <div v-if="role.users && role.users.length > 0" class="mt-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Pengguna dengan Role Ini
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Daftar pengguna yang memiliki role "{{ role.name }}"
                    </p>
                </div>
                <div class="p-6">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                    >
                        <div
                            v-for="user in role.users"
                            :key="user.id"
                            class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-md"
                        >
                            <UserIcon class="h-8 w-8 text-gray-400 mr-3" />
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    {{ user.name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ user.email }}
                                </div>
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
    CheckCircleIcon,
    ShieldExclamationIcon,
    PlusIcon,
    UserIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    role: {
        type: Object,
        required: true,
    },
});

// Computed
const groupedPermissions = computed(() => {
    if (!props.role.permissions) return {};

    return props.role.permissions.reduce((groups, permission) => {
        const groupName = permission.name.split(".")[0] || "other";
        if (!groups[groupName]) {
            groups[groupName] = [];
        }
        groups[groupName].push(permission);
        return groups;
    }, {});
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
