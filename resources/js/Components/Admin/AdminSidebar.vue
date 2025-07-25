<template>
    <!-- Mobile sidebar backdrop -->
    <div
        v-if="sidebarOpen"
        class="fixed inset-0 z-40 lg:hidden"
        @click="$emit('close')"
    >
        <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
    </div>

    <!-- Sidebar -->
    <div
        class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
        :class="{ '-translate-x-full': !sidebarOpen }"
    >
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 bg-gray-900">
            <h1 class="text-white text-xl font-bold">Admin Panel</h1>
        </div>

        <!-- Navigation -->
        <nav class="mt-8">
            <div class="px-4 space-y-2">
                <!-- Dashboard -->
                <SidebarLink
                    href="/admin/dashboard"
                    :active="$page.url === '/admin/dashboard'"
                >
                    <HomeIcon class="w-5 h-5 mr-3" />
                    Dashboard
                </SidebarLink>

                <!-- Program Studi -->
                <SidebarLink
                    href="/admin/program-studi"
                    :active="$page.url.startsWith('/admin/program-studi')"
                >
                    <AcademicCapIcon class="w-5 h-5 mr-3" />
                    Program Studi
                </SidebarLink>

                <!-- News -->
                <SidebarLink
                    href="/admin/news"
                    :active="$page.url.startsWith('/admin/news')"
                >
                    <NewspaperIcon class="w-5 h-5 mr-3" />
                    Berita
                </SidebarLink>

                <!-- Team -->
                <SidebarLink
                    href="/admin/teams"
                    :active="$page.url.startsWith('/admin/teams')"
                >
                    <UsersIcon class="w-5 h-5 mr-3" />
                    Tim
                </SidebarLink>

                <!-- Events -->
                <SidebarLink
                    href="/admin/events"
                    :active="$page.url.startsWith('/admin/events')"
                >
                    <CalendarIcon class="w-5 h-5 mr-3" />
                    Events
                </SidebarLink>

                <!-- Gallery -->
                <SidebarLink
                    href="/admin/galleries"
                    :active="$page.url.startsWith('/admin/galleries')"
                >
                    <PhotoIcon class="w-5 h-5 mr-3" />
                    Gallery
                </SidebarLink>

                <!-- Contact Messages -->
                <SidebarLink
                    href="/admin/contact-messages"
                    :active="$page.url.startsWith('/admin/contact-messages')"
                >
                    <EnvelopeIcon class="w-5 h-5 mr-3" />
                    Pesan
                    <span
                        v-if="unreadCount > 0"
                        class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1"
                    >
                        {{ unreadCount }}
                    </span>
                </SidebarLink>

                <!-- Settings -->
                <SidebarLink
                    href="/admin/settings"
                    :active="$page.url.startsWith('/admin/settings')"
                >
                    <CogIcon class="w-5 h-5 mr-3" />
                    Pengaturan
                </SidebarLink>
            </div>
        </nav>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import SidebarLink from "./SidebarLink.vue";
import {
    HomeIcon,
    AcademicCapIcon,
    NewspaperIcon,
    UsersIcon,
    CalendarIcon,
    PhotoIcon,
    EnvelopeIcon,
    CogIcon,
} from "@heroicons/vue/24/outline";

defineProps({
    sidebarOpen: Boolean,
});

defineEmits(["close"]);

const page = usePage();
const unreadCount = computed(() => page.props.unreadMessagesCount || 0);
</script>
