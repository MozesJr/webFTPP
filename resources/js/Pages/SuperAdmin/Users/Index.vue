<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-12xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">
                                    User Management
                                </h1>
                                <p class="text-sm text-gray-600 mt-1">
                                    Kelola semua user dalam sistem
                                </p>
                            </div>
                            <div class="flex space-x-3">
                                <Link
                                    :href="route('super-admin.parents.index')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <UserGroupIcon class="w-4 h-4 mr-2" />
                                    Portal Orang Tua
                                </Link>
                                <Link
                                    :href="route('super-admin.users.create')"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <PlusIcon class="w-4 h-4 mr-2" />
                                    Tambah User
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <UsersIcon class="h-8 w-8 text-blue-600" />
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">
                                    Total User
                                </div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ users.total || 0 }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <CheckCircleIcon
                                    class="h-8 w-8 text-green-600"
                                />
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">
                                    User Aktif
                                </div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ activeUsersCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <ShieldCheckIcon
                                    class="h-8 w-8 text-purple-600"
                                />
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">
                                    Super Admin
                                </div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ superAdminCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <UserGroupIcon
                                    class="h-8 w-8 text-indigo-600"
                                />
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">
                                    Portal Orang Tua
                                </div>
                                <div class="text-2xl font-bold text-gray-900">
                                    -
                                </div>
                                <Link
                                    :href="route('super-admin.parents.index')"
                                    class="text-xs text-indigo-600 hover:text-indigo-500"
                                >
                                    Kelola →
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                <div
                    v-if="$page.props.flash?.message"
                    class="mb-6 bg-green-50 border border-green-200 rounded-md p-4"
                >
                    <div class="flex">
                        <CheckCircleIcon class="h-5 w-5 text-green-400" />
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ $page.props.flash.message }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Search</label
                                >
                                <input
                                    type="text"
                                    v-model="searchForm.search"
                                    @input="debounceSearch"
                                    placeholder="Search name or email..."
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Role</label
                                >
                                <select
                                    v-model="searchForm.role"
                                    @change="handleFilter"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                    <option value="">All Roles</option>
                                    <option
                                        v-for="role in roles"
                                        :key="role.id"
                                        :value="role.name"
                                    >
                                        {{ role.name }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                    >Status</label
                                >
                                <select
                                    v-model="searchForm.is_active"
                                    @change="handleFilter"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                >
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button
                                    @click="clearFilters"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div
                            class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                        >
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            User
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Role
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Created
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr v-if="users.data.length === 0">
                                        <td
                                            colspan="5"
                                            class="px-6 py-12 text-center"
                                        >
                                            <UsersIcon
                                                class="mx-auto h-12 w-12 text-gray-400"
                                            />
                                            <h3
                                                class="mt-4 text-lg font-medium text-gray-900"
                                            >
                                                No users found
                                            </h3>
                                            <p
                                                class="mt-2 text-sm text-gray-600"
                                            >
                                                Get started by creating a new
                                                user.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="user in users.data"
                                        :key="user.id"
                                        class="hover:bg-gray-50"
                                    >
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-10 w-10 flex-shrink-0"
                                                >
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center"
                                                    >
                                                        <span
                                                            class="text-sm font-medium text-gray-700"
                                                        >
                                                            {{
                                                                user.name
                                                                    .charAt(0)
                                                                    .toUpperCase()
                                                            }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div
                                                        class="text-sm font-medium text-gray-900"
                                                    >
                                                        {{ user.name }}
                                                    </div>
                                                    <div
                                                        class="text-sm text-gray-500"
                                                    >
                                                        {{ user.email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                v-for="role in user.roles"
                                                :key="role.id"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mr-1"
                                                :class="
                                                    getRoleBadgeClass(role.name)
                                                "
                                            >
                                                {{ formatRoleName(role.name) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                :class="[
                                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                    user.is_active
                                                        ? 'bg-green-100 text-green-800'
                                                        : 'bg-red-100 text-red-800',
                                                ]"
                                            >
                                                {{
                                                    user.is_active
                                                        ? "Active"
                                                        : "Inactive"
                                                }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                        >
                                            {{ formatDate(user.created_at) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                        >
                                            <div
                                                class="flex items-center justify-end space-x-2"
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'super-admin.users.show',
                                                            user.id
                                                        )
                                                    "
                                                    class="text-blue-600 hover:text-blue-900 px-2 py-1 rounded"
                                                >
                                                    <EyeIcon class="h-4 w-4" />
                                                </Link>
                                                <Link
                                                    :href="
                                                        route(
                                                            'super-admin.users.edit',
                                                            user.id
                                                        )
                                                    "
                                                    class="text-indigo-600 hover:text-indigo-900 px-2 py-1 rounded"
                                                >
                                                    <PencilIcon
                                                        class="h-4 w-4"
                                                    />
                                                </Link>
                                                <button
                                                    @click="
                                                        toggleUserStatus(user)
                                                    "
                                                    :disabled="
                                                        user.id ===
                                                        $page.props.auth.user.id
                                                    "
                                                    class="text-yellow-600 hover:text-yellow-900 px-2 py-1 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                                >
                                                    <component
                                                        :is="
                                                            user.is_active
                                                                ? XCircleIcon
                                                                : CheckCircleIcon
                                                        "
                                                        class="h-4 w-4"
                                                    />
                                                </button>
                                                <button
                                                    @click="deleteUser(user)"
                                                    :disabled="
                                                        user.id ===
                                                        $page.props.auth.user.id
                                                    "
                                                    class="text-red-600 hover:text-red-900 px-2 py-1 rounded disabled:opacity-50 disabled:cursor-not-allowed"
                                                >
                                                    <TrashIcon
                                                        class="h-4 w-4"
                                                    />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6" v-if="users.last_page > 1">
                            <nav class="flex items-center justify-between">
                                <div
                                    class="flex-1 flex justify-between sm:hidden"
                                >
                                    <Link
                                        v-if="users.prev_page_url"
                                        :href="users.prev_page_url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Previous
                                    </Link>
                                    <Link
                                        v-if="users.next_page_url"
                                        :href="users.next_page_url"
                                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Next
                                    </Link>
                                </div>
                                <div
                                    class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                                >
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Showing
                                            <span class="font-medium">{{
                                                users.from || 0
                                            }}</span>
                                            to
                                            <span class="font-medium">{{
                                                users.to || 0
                                            }}</span>
                                            of
                                            <span class="font-medium">{{
                                                users.total
                                            }}</span>
                                            results
                                        </p>
                                    </div>
                                    <div class="flex space-x-1">
                                        <template
                                            v-for="link in users.links"
                                            :key="link.label"
                                        >
                                            <Link
                                                v-if="link.url"
                                                :href="link.url"
                                                v-html="link.label"
                                                :class="[
                                                    'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                                    link.active
                                                        ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                                                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                                ]"
                                            >
                                            </Link>
                                            <span
                                                v-else
                                                v-html="link.label"
                                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed"
                                            >
                                            </span>
                                        </template>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    PlusIcon,
    UsersIcon,
    UserGroupIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
    CheckCircleIcon,
    XCircleIcon,
    ShieldCheckIcon,
} from "@heroicons/vue/24/outline";
import { debounce } from "lodash";

const props = defineProps({
    users: Object,
    filters: Object,
    roles: Array,
});

const searchForm = reactive({
    search: props.filters.search || "",
    role: props.filters.role || "",
    is_active: props.filters.is_active || "",
});

// Computed properties for stats
const activeUsersCount = computed(() => {
    return props.users.data.filter((user) => user.is_active).length;
});

const superAdminCount = computed(() => {
    return props.users.data.filter((user) =>
        user.roles.some((role) => role.name === "super_admin")
    ).length;
});

const debounceSearch = debounce(() => {
    handleFilter();
}, 500);

const handleFilter = () => {
    const params = {};

    if (searchForm.search) params.search = searchForm.search;
    if (searchForm.role) params.role = searchForm.role;
    if (searchForm.is_active !== "") params.is_active = searchForm.is_active;

    router.get(route("super-admin.users.index"), params, {
        preserveState: true,
        replace: true,
    });
};

const clearFilters = () => {
    searchForm.search = "";
    searchForm.role = "";
    searchForm.is_active = "";
    router.get(
        route("super-admin.users.index"),
        {},
        {
            preserveState: true,
            replace: true,
        }
    );
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const formatRoleName = (roleName) => {
    const roleNames = {
        super_admin: "Super Admin",
        admin: "Admin",
        petugas_umum: "Petugas",
        orang_tua: "Parent",
    };
    return roleNames[roleName] || roleName;
};

const getRoleBadgeClass = (roleName) => {
    const classes = {
        super_admin: "bg-red-100 text-red-800",
        admin: "bg-blue-100 text-blue-800",
        petugas_umum: "bg-green-100 text-green-800",
        orang_tua: "bg-yellow-100 text-yellow-800",
    };
    return classes[roleName] || "bg-gray-100 text-gray-800";
};

const toggleUserStatus = async (user) => {
    const action = user.is_active ? "deactivate" : "activate";

    if (confirm(`Are you sure you want to ${action} ${user.name}?`)) {
        try {
            const response = await fetch(
                route("super-admin.users.toggle-status", user.id),
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
                user.is_active = data.is_active;
                const event = new CustomEvent("show-toast", {
                    detail: { message: data.message, type: "success" },
                });
                window.dispatchEvent(event);
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error("Error:", error);
            alert("An error occurred while updating user status");
        }
    }
};

const deleteUser = (user) => {
    if (
        confirm(
            `Are you sure you want to delete ${user.name}? This action cannot be undone.`
        )
    ) {
        router.delete(route("super-admin.users.destroy", user.id), {
            preserveScroll: true,
            onSuccess: () => {
                // Success message will be handled by flash message
            },
            onError: (errors) => {
                console.error("Delete errors:", errors);
                alert("An error occurred while deleting the user");
            },
        });
    }
};
</script>
