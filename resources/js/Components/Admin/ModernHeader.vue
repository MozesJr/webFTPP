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

                <div class="hidden md:block">
                    <div class="text-right">
                        <span
                            class="flex items-center justify-end text-black font-semibold text-lg"
                        >
                            <CalendarDateRangeIcon class="w-5 h-5 mr-2" />
                            {{ currentDate }}
                        </span>
                        <span
                            class="flex items-center justify-end text-primary font-semibold text-lg"
                        >
                            <ClockIcon class="w-5 h-5 mr-2" />
                            {{ currentTime }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">
                <!-- Quick Actions -->
                <!-- <div class="hidden lg:flex items-center space-x-2">
                    <button
                        @click="$inertia.visit('/admin/news/create')"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <PlusIcon class="w-4 h-4 mr-1" />
                        Berita
                    </button>
                </div> -->

                <!-- Settings Toggle -->
                <button
                    @click="toggleRightSidebar"
                    class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg p-1"
                >
                    <Cog6ToothIcon class="w-5 h-5" />
                </button>

                <!-- User Menu -->
                <div class="relative">
                    <button
                        @click="userMenuOpen = !userMenuOpen"
                        class="flex items-center space-x-3 text-sm rounded-lg p-1 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <img
                            src="/storage/assets/img/avatar.jpg"
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
import { ref, computed, onMounted, onUnmounted } from "vue";
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
    ClockIcon,
    CalendarDateRangeIcon,
} from "@heroicons/vue/24/outline";

defineEmits(["toggle-sidebar"]);

const searchQuery = ref("");
const userMenuOpen = ref(false);
const notificationOpen = ref(false);
const page = usePage();

const currentTime = ref("");
const currentDate = ref("");
let timer = null;

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

const updateTime = () => {
    const now = new Date();

    // Format tanggal untuk Indonesia
    // Output: Senin, 17 Agustus 2025
    currentDate.value = new Intl.DateTimeFormat("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
    }).format(now);

    // Format waktu
    // Output: 14:45:30
    const hours = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");
    const seconds = String(now.getSeconds()).padStart(2, "0");
    currentTime.value = `${hours}:${minutes}:${seconds}`;
};

onMounted(() => {
    updateTime();
    timer = setInterval(updateTime, 1000);
});

onUnmounted(() => {
    clearInterval(timer);
});

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
