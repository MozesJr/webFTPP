<!-- resources/js/Components/ModernSidebar.vue - FINAL FIX -->
<template>
    <!-- Sidebar -->
    <div
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 border-r border-gray-200 h-screen overflow-auto"
        :class="{ '-translate-x-full': !sidebarOpen }"
    >
        <!-- Logo -->
        <div
            class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-blue-600 to-blue-700"
        >
            <div class="flex items-center">
                <img
                    src="/storage/assets/img/Logo_Universitas_Papua.png"
                    alt="FTPP"
                    class="w-8 h-8"
                />
                <span class="ml-3 text-white font-bold text-lg">
                    {{ getPanelTitle() }}
                </span>
            </div>
            <button
                @click="$emit('close')"
                class="lg:hidden text-white hover:text-gray-200"
            >
                <XMarkIcon class="w-6 h-6" />
            </button>
        </div>

        <!-- User Role Badge -->
        <div v-if="user" class="px-4 py-3 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center"
                    >
                        <span class="text-xs font-semibold text-gray-700">
                            {{
                                user.name
                                    ? user.name.charAt(0).toUpperCase()
                                    : "U"
                            }}
                        </span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">
                            {{ user.name || "User" }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ getRoleDisplay() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Debug info (remove in production) -->
            <!-- <div class="mt-2 p-2 bg-gray-100 rounded text-xs">
                <div><strong>Debug Info:</strong></div>
                <div>User: {{ user ? user.name : "Not found" }}</div>
                <div>Roles Array: {{ JSON.stringify(userRoles) }}</div>
                <div>Auth Flags: {{ JSON.stringify(authBooleans) }}</div>
                <div>
                    Functions: Super={{ isSuperAdmin() }}, Admin={{
                        isAdmin()
                    }}, Petugas={{ isPetugas() }}, Parent={{ isParent() }}
                </div>
                <div>URL: {{ currentUrl }}</div>
            </div> -->
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-4 space-y-1">
                <!-- SUPER ADMIN NAVIGATION -->
                <template v-if="isSuperAdmin()">
                    <!-- Super Admin Dashboard -->
                    <SidebarItem
                        href="/super-admin/dashboard"
                        :active="currentUrl === '/super-admin/dashboard'"
                        icon="HomeIcon"
                    >
                        Super Admin Dashboard
                    </SidebarItem>

                    <!-- Super Admin Management -->
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-red-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            System Management
                        </span>
                    </div>

                    <SidebarItem
                        href="/super-admin/users"
                        :active="
                            currentUrl.startsWith('/super-admin/users') ||
                            currentUrl.startsWith('/super-admin/parents')
                        "
                        icon="UsersIcon"
                    >
                        User Management
                    </SidebarItem>

                    <SidebarDropdown
                        title="Roles & Permissions"
                        icon="UsersIcon"
                        :active="
                            currentUrl.startsWith('/super-admin/roles') ||
                            currentUrl.startsWith('/super-admin/permissions')
                        "
                    >
                        <SidebarSubItem href="/super-admin/roles">
                            Roles
                        </SidebarSubItem>
                        <SidebarSubItem href="/super-admin/permissions">
                            Permissions
                        </SidebarSubItem>
                    </SidebarDropdown>

                    <!-- Access to Admin Features -->
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-blue-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            Admin Features Access
                        </span>
                    </div>

                    <SidebarItem
                        href="/admin/dashboard"
                        :active="currentUrl === '/admin/dashboard'"
                        icon="HomeIcon"
                    >
                        Admin Dashboard
                    </SidebarItem>
                </template>

                <!-- ADMIN & SUPER ADMIN SHARED NAVIGATION -->
                <template v-if="isAdmin() || isSuperAdmin()">
                    <!-- Dashboard (for Admin only) -->
                    <template v-if="isAdmin() && !isSuperAdmin()">
                        <SidebarItem
                            href="/admin/dashboard"
                            :active="currentUrl === '/admin/dashboard'"
                            icon="HomeIcon"
                        >
                            Dashboard
                        </SidebarItem>
                    </template>

                    <!-- Content Management -->
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            Content Management
                        </span>
                    </div>

                    <SidebarItem
                        href="/admin/about"
                        :active="currentUrl === '/admin/about'"
                        icon="HomeIcon"
                    >
                        About
                    </SidebarItem>

                    <!-- Program Studi -->
                    <SidebarItem
                        href="/admin/program-studi"
                        :active="currentUrl.startsWith('/admin/program-studi')"
                        icon="AcademicCapIcon"
                    >
                        Program Studi
                    </SidebarItem>

                    <!-- News -->
                    <SidebarItem
                        href="/admin/news"
                        :active="currentUrl.startsWith('/admin/news')"
                        icon="NewspaperIcon"
                    >
                        News
                    </SidebarItem>

                    <!-- Academic Management -->
                    <SidebarDropdown
                        title="Akademik"
                        icon="UsersIcon"
                        :active="
                            currentUrl.startsWith('/admin/kurikulum') ||
                            currentUrl.startsWith('/admin/mata-kuliah') ||
                            currentUrl.startsWith('/admin/rps') ||
                            currentUrl.startsWith('/admin/jadwal-kuliah') ||
                            currentUrl.startsWith('/admin/dosen-mata-kuliah')
                        "
                    >
                        <SidebarSubItem href="/admin/kurikulum">
                            Kurikulum
                        </SidebarSubItem>
                        <SidebarSubItem href="/admin/mata-kuliah">
                            Mata Kuliah
                        </SidebarSubItem>
                        <SidebarSubItem href="/admin/rps"> RPS </SidebarSubItem>
                        <SidebarSubItem href="/admin/jadwal-kuliah">
                            Jadwal Kuliah
                        </SidebarSubItem>
                        <SidebarSubItem href="/admin/dosen-mata-kuliah">
                            Dosen Mata Kuliah
                        </SidebarSubItem>
                    </SidebarDropdown>

                    <SidebarItem
                        href="/admin/penjaminan-mutu"
                        :active="
                            currentUrl.startsWith('/admin/penjaminan-mutu')
                        "
                        icon="NewspaperIcon"
                    >
                        Penjaminan Mutu
                    </SidebarItem>
                    <SidebarItem
                        href="/admin/stats"
                        :active="currentUrl.startsWith('/admin/stats')"
                        icon="NewspaperIcon"
                    >
                        Stats
                    </SidebarItem>

                    <!-- Team -->
                    <SidebarDropdown
                        title="Tim & Dosen"
                        icon="UsersIcon"
                        :active="
                            currentUrl.startsWith('/admin/team') ||
                            currentUrl.startsWith('/admin/team-position')
                        "
                    >
                        <SidebarSubItem href="/admin/team">
                            Semua Tim
                        </SidebarSubItem>
                        <SidebarSubItem href="/admin/team-position">
                            Posisi/Jabatan
                        </SidebarSubItem>
                    </SidebarDropdown>

                    <SidebarItem
                        href="khs"
                        :active="currentUrl.startsWith('/super-admin/khs')"
                        icon="NewspaperIcon"
                    >
                        Portal Upload
                    </SidebarItem>

                    <!-- Events -->
                    <SidebarItem
                        href="/admin/events"
                        :active="currentUrl.startsWith('/admin/events')"
                        icon="CalendarIcon"
                    >
                        Events
                    </SidebarItem>

                    <!-- Gallery -->
                    <SidebarItem
                        href="/admin/galleries"
                        :active="currentUrl.startsWith('/admin/galleries')"
                        icon="PhotoIcon"
                    >
                        Gallery
                    </SidebarItem>

                    <!-- Communication -->
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            Communication
                        </span>
                    </div>

                    <!-- Contact Messages -->
                    <SidebarItem
                        href="/admin/contact-messages"
                        :active="
                            currentUrl.startsWith('/admin/contact-messages')
                        "
                        icon="EnvelopeIcon"
                        :badge="unreadCount"
                    >
                        Pesan Kontak
                    </SidebarItem>

                    <!-- System -->
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            System
                        </span>
                    </div>
                    <SidebarItem
                        href="/admin/site-settings"
                        :active="currentUrl.startsWith('/admin/site-settings')"
                        icon="CogIcon"
                    >
                        Site Setting
                    </SidebarItem>

                    <!-- File Manager -->
                    <SidebarItem
                        href="/admin/file-manager"
                        :active="currentUrl.startsWith('/admin/file-manager')"
                        icon="FolderIcon"
                    >
                        File Manager
                    </SidebarItem>
                </template>

                <!-- PETUGAS UMUM NAVIGATION -->
                <template v-if="isPetugas() && !isAdmin() && !isSuperAdmin()">
                    <!-- Petugas Dashboard -->
                    <SidebarItem
                        href="/petugas/dashboard"
                        :active="currentUrl === '/petugas/dashboard'"
                        icon="HomeIcon"
                    >
                        Dashboard
                    </SidebarItem>

                    <!-- Limited Access -->
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-green-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            Operational Tasks
                        </span>
                    </div>

                    <!-- News (can create/edit) -->
                    <SidebarItem
                        href="/petugas/news"
                        :active="currentUrl.startsWith('/petugas/news')"
                        icon="NewspaperIcon"
                    >
                        Kelola News
                    </SidebarItem>

                    <!-- Contact Messages (can reply) -->
                    <SidebarItem
                        href="/petugas/contact-messages"
                        :active="
                            currentUrl.startsWith('/petugas/contact-messages')
                        "
                        icon="EnvelopeIcon"
                        :badge="unreadCount"
                    >
                        Balas Pesan
                    </SidebarItem>

                    <!-- Jadwal (can edit) -->
                    <SidebarItem
                        href="/petugas/jadwal-kuliah"
                        :active="
                            currentUrl.startsWith('/petugas/jadwal-kuliah')
                        "
                        icon="CalendarIcon"
                    >
                        Update Jadwal
                    </SidebarItem>

                    <!-- Read-only Access -->
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            View Only
                        </span>
                    </div>

                    <SidebarItem
                        href="/admin/program-studi"
                        :active="currentUrl.startsWith('/admin/program-studi')"
                        icon="AcademicCapIcon"
                    >
                        Program Studi
                    </SidebarItem>

                    <SidebarItem
                        href="/admin/team"
                        :active="currentUrl.startsWith('/admin/team')"
                        icon="UsersIcon"
                    >
                        Data Tim
                    </SidebarItem>
                </template>

                <!-- PARENT NAVIGATION -->
                <template v-if="isParent() && !isAdmin() && !isSuperAdmin()">
                    <!-- Parent Dashboard -->
                    <SidebarItem
                        href="/parent/dashboard"
                        :active="currentUrl === '/parent/dashboard'"
                        icon="HomeIcon"
                    >
                        Dashboard
                    </SidebarItem>

                    <!-- Parent Features -->
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-yellow-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            Monitoring Anak
                        </span>
                    </div>

                    <!-- Future KHS feature -->
                    <div class="px-3 py-2">
                        <div
                            class="bg-yellow-50 border border-yellow-200 rounded-lg p-3"
                        >
                            <p class="text-xs text-yellow-700 font-medium">
                                🚧 Under Development
                            </p>
                            <p class="text-xs text-yellow-600 mt-1">
                                • Lihat KHS Anak<br />
                                • Monitoring Nilai<br />
                                • Pengumuman Khusus
                            </p>
                        </div>
                    </div>
                </template>

                <!-- Role Switch (Super Admin only) -->
                <template v-if="isSuperAdmin()">
                    <div class="py-2">
                        <div class="border-t border-gray-200"></div>
                        <span
                            class="text-xs font-semibold text-red-400 uppercase tracking-wider px-3 py-2 block"
                        >
                            Quick Access
                        </span>
                    </div>

                    <div class="px-3 py-2">
                        <div
                            class="bg-red-50 border border-red-200 rounded-lg p-3"
                        >
                            <p class="text-xs text-red-700 font-medium mb-2">
                                🔑 Super Admin Access
                            </p>
                            <div class="space-y-1">
                                <a
                                    href="/admin/dashboard"
                                    class="block text-xs text-red-600 hover:text-red-800"
                                >
                                    → Admin Panel
                                </a>
                                <a
                                    href="/petugas/dashboard"
                                    class="block text-xs text-red-600 hover:text-red-800"
                                >
                                    → Petugas Panel
                                </a>
                                <a
                                    href="/parent/dashboard"
                                    class="block text-xs text-red-600 hover:text-red-800"
                                >
                                    → Parent Portal
                                </a>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Fallback if no roles detected -->
                <template
                    v-if="
                        !isSuperAdmin() &&
                        !isAdmin() &&
                        !isPetugas() &&
                        !isParent()
                    "
                >
                    <div class="px-3 py-2">
                        <div
                            class="bg-red-50 border border-red-200 rounded-lg p-3"
                        >
                            <p class="text-xs text-red-700 font-medium">
                                ⚠️ No valid role detected
                            </p>
                            <p class="text-xs text-red-600 mt-1">
                                Please contact administrator
                            </p>
                        </div>
                    </div>
                </template>
            </div>
        </nav>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import SidebarItem from "./SidebarItem.vue";
import SidebarDropdown from "./SidebarDropdown.vue";
import SidebarSubItem from "./SidebarSubItem.vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";

defineProps({
    sidebarOpen: Boolean,
});

defineEmits(["close"]);

const page = usePage();

// Safe computed properties with null checks
const user = computed(() => {
    try {
        return page.props?.auth?.user || null;
    } catch (error) {
        console.warn("Error accessing user data:", error);
        return null;
    }
});

const userRoles = computed(() => {
    try {
        return page.props?.auth?.roles || [];
    } catch (error) {
        console.warn("Error accessing user roles:", error);
        return [];
    }
});

// RENAMED: authFlags -> authBooleans untuk menghindari konflik
const authBooleans = computed(() => {
    try {
        return {
            is_super_admin: page.props?.auth?.is_super_admin || false,
            is_admin: page.props?.auth?.is_admin || false,
            is_petugas: page.props?.auth?.is_petugas || false,
            is_parent: page.props?.auth?.is_parent || false,
        };
    } catch (error) {
        console.warn("Error accessing auth flags:", error);
        return {
            is_super_admin: false,
            is_admin: false,
            is_petugas: false,
            is_parent: false,
        };
    }
});

const currentUrl = computed(() => {
    try {
        return page.url || window.location.pathname || "";
    } catch (error) {
        console.warn("Error accessing current URL:", error);
        return "";
    }
});

const unreadCount = computed(() => {
    try {
        return (
            page.props?.unreadMessagesCount ||
            page.props?.unread_count ||
            page.props?.data?.unreadMessagesCount ||
            0
        );
    } catch (error) {
        console.warn("Error accessing unread count:", error);
        return 0;
    }
});

// Safe role checking functions - UPDATED to use authBooleans instead of authFlags
const isSuperAdmin = () => {
    try {
        return (
            authBooleans.value.is_super_admin ||
            userRoles.value.includes("super_admin")
        );
    } catch (error) {
        console.warn("Error checking super admin role:", error);
        return false;
    }
};

const isAdmin = () => {
    try {
        return authBooleans.value.is_admin || userRoles.value.includes("admin");
    } catch (error) {
        console.warn("Error checking admin role:", error);
        return false;
    }
};

const isPetugas = () => {
    try {
        return (
            authBooleans.value.is_petugas ||
            userRoles.value.includes("petugas_umum")
        );
    } catch (error) {
        console.warn("Error checking petugas role:", error);
        return false;
    }
};

const isParent = () => {
    try {
        return (
            authBooleans.value.is_parent ||
            userRoles.value.includes("orang_tua")
        );
    } catch (error) {
        console.warn("Error checking parent role:", error);
        return false;
    }
};

const getPanelTitle = () => {
    try {
        if (isSuperAdmin()) return "Super Admin";
        if (isAdmin()) return "FTPP Admin";
        if (isPetugas()) return "Petugas Panel";
        if (isParent()) return "Parent Portal";
        return "FTPP Admin";
    } catch (error) {
        console.warn("Error getting panel title:", error);
        return "FTPP Admin";
    }
};

const getRoleDisplay = () => {
    try {
        if (isSuperAdmin()) return "Super Administrator";
        if (isAdmin()) return "Administrator";
        if (isPetugas()) return "Petugas Umum";
        if (isParent()) return "Orang Tua";
        return "User";
    } catch (error) {
        console.warn("Error getting role display:", error);
        return "User";
    }
};
</script>
