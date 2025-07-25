<template>
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-4">
            <!-- Left side -->
            <div class="flex items-center">
                <!-- Mobile menu button -->
                <button
                    @click="$emit('toggle-sidebar')"
                    class="lg:hidden text-gray-500 hover:text-gray-700"
                >
                    <Bars3Icon class="w-6 h-6" />
                </button>

                <!-- Breadcrumb -->
                <nav class="ml-4 lg:ml-0">
                    <ol
                        class="flex items-center space-x-2 text-sm text-gray-500"
                    >
                        <li v-for="(crumb, index) in breadcrumbs" :key="index">
                            <div class="flex items-center">
                                <Link
                                    v-if="crumb.href"
                                    :href="crumb.href"
                                    class="hover:text-gray-700"
                                >
                                    {{ crumb.name }}
                                </Link>
                                <span v-else class="text-gray-900 font-medium">
                                    {{ crumb.name }}
                                </span>
                                <ChevronRightIcon
                                    v-if="index < breadcrumbs.length - 1"
                                    class="w-4 h-4 mx-2"
                                />
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative text-gray-500 hover:text-gray-700">
                    <BellIcon class="w-6 h-6" />
                    <span
                        v-if="notificationCount > 0"
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                    >
                        {{ notificationCount }}
                    </span>
                </button>

                <!-- User Menu -->
                <div class="relative">
                    <button
                        @click="userMenuOpen = !userMenuOpen"
                        class="flex items-center space-x-3 text-sm"
                    >
                        <!-- <img
                            :src="$page.props.auth.user.profile_photo_url"
                            :alt="$page.props.auth.user.name"
                            class="w-8 h-8 rounded-full"
                        /> -->
                        <span class="hidden md:block text-gray-700">
                            <!-- {{ $page.props.auth.user.name }} -->
                        </span>
                        <ChevronDownIcon class="w-4 h-4 text-gray-500" />
                    </button>

                    <!-- Dropdown -->
                    <div
                        v-if="userMenuOpen"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10"
                    >
                        <Link
                            href="/profile"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Profile
                        </Link>
                        <Link
                            href="/"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Lihat Website
                        </Link>
                        <hr class="my-1" />
                        <Link
                            href="/logout"
                            method="post"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Logout
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import {
    Bars3Icon,
    BellIcon,
    ChevronRightIcon,
    ChevronDownIcon,
} from "@heroicons/vue/24/outline";

defineEmits(["toggle-sidebar"]);

const userMenuOpen = ref(false);
const page = usePage();

const breadcrumbs = computed(() => {
    const url = page.url;
    const parts = url.split("/").filter(Boolean);
    const crumbs = [{ name: "Dashboard", href: "/admin/dashboard" }];

    if (parts.length > 1) {
        const section = parts[1].replace("-", " ");
        crumbs.push({
            name: section.charAt(0).toUpperCase() + section.slice(1),
            href: null,
        });
    }

    return crumbs;
});

const notificationCount = computed(() => {
    return page.props.unreadMessagesCount || 0;
});
</script>
