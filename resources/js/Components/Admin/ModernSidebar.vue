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
                    src="/storage/assets/img/Logo_Universitas_Papua.png"
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

                <SidebarDropdown
                    title="Akademik"
                    icon="UsersIcon"
                    :active="
                        $page.url.startsWith('/admin/kurikulum') ||
                        $page.url.startsWith('/admin/mata-kuliah') ||
                        $page.url.startsWith('/admin/rps') ||
                        $page.url.startsWith('/admin/jadwal-kuliah') ||
                        $page.url.startsWith('/admin/dosen-mata-kuliah')
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
                    :active="$page.url.startsWith('/admin/penjaminan-mutu')"
                    icon="NewspaperIcon"
                >
                    Penjaminan Mutu
                </SidebarItem>
                <SidebarItem
                    href="/admin/stats"
                    :active="$page.url.startsWith('/admin/stats')"
                    icon="NewspaperIcon"
                >
                    Stats
                </SidebarItem>

                <!-- Team -->
                <SidebarDropdown
                    title="Tim & Dosen"
                    icon="UsersIcon"
                    :active="
                        $page.url.startsWith('/admin/team') ||
                        $page.url.startsWith('/admin/team-position')
                    "
                >
                    <SidebarSubItem href="/admin/team">
                        Semua Tim
                    </SidebarSubItem>
                    <SidebarSubItem href="/admin/team-position">
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
                <SidebarItem
                    href="/admin/site-settings"
                    :active="$page.url.startsWith('/admin/site-settings')"
                    icon="CogIcon"
                >
                    Site Setting
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
