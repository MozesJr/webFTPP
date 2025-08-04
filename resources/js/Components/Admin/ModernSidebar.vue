<template>
    <!-- Sidebar -->
    <div
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 border-r border-gray-200"
        :class="{ '-translate-x-full': !sidebarOpen }"
    >
        <!-- Logo -->
        <div
            class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-blue-600 to-blue-700"
        >
            <div class="flex items-center">
                <img
                    src="/storage/assets/img/logo.png"
                    alt="FTPP"
                    class="w-8 h-8"
                />
                <span class="ml-3 text-white font-bold text-lg"
                    >FTPP Admin</span
                >
            </div>
            <button
                @click="$emit('close')"
                class="lg:hidden text-white hover:text-gray-200"
            >
                <XMarkIcon class="w-6 h-6" />
            </button>
        </div>

        <!-- Search -->
        <div class="p-4 border-b border-gray-200">
            <div class="relative">
                <MagnifyingGlassIcon
                    class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"
                />
                <input
                    type="text"
                    placeholder="Search menu..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    v-model="searchQuery"
                />
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-4 space-y-1">
                <!-- Dashboard -->
                <SidebarItem
                    href="/admin/dashboard"
                    :active="$page.url === '/admin/dashboard'"
                    icon="HomeIcon"
                >
                    Dashboard
                </SidebarItem>

                <!-- Divider -->
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
                    :active="$page.url === '/admin/about'"
                    icon="HomeIcon"
                >
                    About
                </SidebarItem>

                <!-- Program Studi -->
                <SidebarItem
                    href="/admin/program-studi"
                    :active="$page.url.startsWith('/admin/program-studi')"
                    icon="AcademicCapIcon"
                >
                    Program Studi
                </SidebarItem>

                <!-- News -->

                <SidebarItem
                    href="/admin/news"
                    :active="$page.url.startsWith('/admin/news')"
                    icon="NewspaperIcon"
                >
                    News
                </SidebarItem>

                <!-- Team -->
                <SidebarDropdown
                    title="Tim & Dosen"
                    icon="UsersIcon"
                    :active="$page.url.startsWith('/admin/teams')"
                >
                    <SidebarSubItem href="/admin/teams">
                        Semua Tim
                    </SidebarSubItem>
                    <SidebarSubItem href="/admin/teams/create">
                        Tambah Anggota
                    </SidebarSubItem>
                    <SidebarSubItem href="/admin/team-positions">
                        Posisi/Jabatan
                    </SidebarSubItem>
                </SidebarDropdown>

                <!-- Events -->
                <SidebarItem
                    href="/admin/events"
                    :active="$page.url.startsWith('/admin/events')"
                    icon="CalendarIcon"
                >
                    Events
                </SidebarItem>

                <!-- Gallery -->
                <SidebarItem
                    href="/admin/galleries"
                    :active="$page.url.startsWith('/admin/galleries')"
                    icon="PhotoIcon"
                >
                    Gallery
                </SidebarItem>

                <!-- Divider -->
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
                    :active="$page.url.startsWith('/admin/contact-messages')"
                    icon="EnvelopeIcon"
                    :badge="unreadCount"
                >
                    Pesan Kontak
                </SidebarItem>

                <!-- Divider -->
                <div class="py-2">
                    <div class="border-t border-gray-200"></div>
                    <span
                        class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2 block"
                    >
                        System
                    </span>
                </div>

                <!-- Settings -->
                <SidebarItem
                    href="/admin/settings"
                    :active="$page.url.startsWith('/admin/settings')"
                    icon="CogIcon"
                >
                    Pengaturan
                </SidebarItem>

                <!-- File Manager -->
                <SidebarItem
                    href="/admin/file-manager"
                    :active="$page.url.startsWith('/admin/file-manager')"
                    icon="FolderIcon"
                >
                    File Manager
                </SidebarItem>
            </div>
        </nav>

        <!-- User Info at Bottom -->
        <div class="border-t border-gray-200 p-4">
            <div class="flex items-center">
                <img
                    src="/storage/assets/img/team/default-avatar.jpg"
                    alt="User"
                    class="w-10 h-10 rounded-full"
                />
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Admin User</p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import SidebarItem from "./SidebarItem.vue";
import SidebarDropdown from "./SidebarDropdown.vue";
import SidebarSubItem from "./SidebarSubItem.vue";
import { XMarkIcon, MagnifyingGlassIcon } from "@heroicons/vue/24/outline";

defineProps({
    sidebarOpen: Boolean,
});

defineEmits(["close"]);

const searchQuery = ref("");
const page = usePage();
const unreadCount = computed(() => page.props.unreadMessagesCount || 0);
</script>
