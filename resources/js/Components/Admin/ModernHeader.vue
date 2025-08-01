<template>
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-4">
            <!-- Left side -->
            <div class="flex items-center">
                <!-- Mobile menu button -->
                <button
                    @click="$emit('toggle-sidebar')"
                    class="lg:hidden text-gray-500 hover:text-gray-700 mr-4"
                >
                    <Bars3Icon class="w-6 h-6" />
                </button>

                <!-- Search -->
                <div class="hidden md:block">
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                        >
                            <MagnifyingGlassIcon
                                class="h-5 w-5 text-gray-400"
                            />
                        </div>
                        <input
                            type="text"
                            placeholder="Search anything..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            v-model="searchQuery"
                        />
                        <div
                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        >
                            <kbd
                                class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-xs text-gray-400"
                            >
                                ⌘K
                            </kbd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">
                <!-- Quick Actions -->
                <div class="hidden lg:flex items-center space-x-2">
                    <button
                        @click="$inertia.visit('/admin/news/create')"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <PlusIcon class="w-4 h-4 mr-1" />
                        Berita
                    </button>
                </div>

                <!-- Settings Toggle -->
                <button
                    @click="toggleRightSidebar"
                    class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg p-1"
                >
                    <Cog6ToothIcon class="w-5 h-5" />
                </button>

                <!-- Notifications -->
                <div class="relative">
                    <button
                        @click="notificationOpen = !notificationOpen"
                        class="relative text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg p-1"
                    >
                        <BellIcon class="w-6 h-6" />
                        <span
                            v-if="notificationCount > 0"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium"
                        >
                            {{
                                notificationCount > 9 ? "9+" : notificationCount
                            }}
                        </span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div
                        v-if="notificationOpen"
                        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200"
                    >
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900">
                                Notifications
                            </h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <div
                                v-for="notification in notifications"
                                :key="notification.id"
                                class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0"
                            >
                                <div class="flex items-start">
                                    <img
                                        :src="
                                            notification.avatar ||
                                            '/storage/assets/img/team/default-avatar.jpg'
                                        "
                                        :alt="notification.title"
                                        class="w-8 h-8 rounded-full"
                                    />
                                    <div class="ml-3 flex-1">
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ notification.title }}
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ notification.message }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{
                                                formatDate(
                                                    notification.created_at
                                                )
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 border-t border-gray-200">
                            <Link
                                href="/admin/notifications"
                                class="text-sm text-blue-600 hover:text-blue-700"
                            >
                                View all notifications
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative">
                    <button
                        @click="userMenuOpen = !userMenuOpen"
                        class="flex items-center space-x-3 text-sm rounded-lg p-1 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <img
                            src="/storage/assets/img/team/default-avatar.jpg"
                            alt="User"
                            class="w-8 h-8 rounded-full"
                        />
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-gray-900">
                                Admin User
                            </p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <ChevronDownIcon class="w-4 h-4 text-gray-500" />
                    </button>

                    <!-- User Dropdown -->
                    <div
                        v-if="userMenuOpen"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200"
                    >
                        <Link
                            href="/admin/profile"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            <UserIcon class="w-4 h-4 mr-3" />
                            Profile
                        </Link>
                        <Link
                            href="/admin/settings"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            <Cog6ToothIcon class="w-4 h-4 mr-3" />
                            Settings
                        </Link>
                        <Link
                            href="/"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            <EyeIcon class="w-4 h-4 mr-3" />
                            Lihat Website
                        </Link>
                        <hr class="my-1" />
                        <Link
                            href="/logout"
                            method="post"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            <ArrowRightOnRectangleIcon class="w-4 h-4 mr-3" />
                            Logout
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import {
    Bars3Icon,
    MagnifyingGlassIcon,
    BellIcon,
    ChevronDownIcon,
    PlusIcon,
    Cog6ToothIcon,
    UserIcon,
    EyeIcon,
    ArrowRightOnRectangleIcon,
} from "@heroicons/vue/24/outline";

defineEmits(["toggle-sidebar"]);

const searchQuery = ref("");
const userMenuOpen = ref(false);
const notificationOpen = ref(false);
const page = usePage();

const notificationCount = computed(() => {
    return page.props.unreadMessagesCount || 0;
});

// Sample notifications - replace with real data
const notifications = ref([
    {
        id: 1,
        title: "Pesan Baru",
        message: "Ada pesan baru dari kontak form website",
        created_at: new Date(),
        avatar: null,
    },
    {
        id: 2,
        title: "Berita Published",
        message: "Berita 'Seminar Nasional' telah dipublish",
        created_at: new Date(Date.now() - 3600000),
        avatar: null,
    },
]);

function formatDate(date) {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        hour: "2-digit",
        minute: "2-digit",
    });
}

function toggleRightSidebar() {
    if (window.toggleRightSidebar) {
        window.toggleRightSidebar();
    }
}

// Close dropdowns when clicking outside
onMounted(() => {
    document.addEventListener("click", (e) => {
        if (!e.target.closest(".relative")) {
            userMenuOpen.value = false;
            notificationOpen.value = false;
        }
    });
});
</script>
