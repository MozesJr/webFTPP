<!-- resources/js/Layouts/ParentLayout.vue -->
<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo & Title -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <AcademicCapIcon class="h-8 w-8 text-indigo-600" />
                        </div>
                        <div class="ml-3">
                            <h1 class="text-lg font-semibold text-gray-900">
                                Portal Orang Tua
                            </h1>
                            <p class="text-xs text-gray-500">
                                Sistem Informasi KHS
                            </p>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Student Info -->
                        <div
                            class="hidden md:flex items-center text-sm text-gray-700"
                        >
                            <UserIcon class="h-4 w-4 mr-2 text-gray-400" />
                            <span class="font-medium">{{ student?.name }}</span>
                            <span class="mx-2 text-gray-400">•</span>
                            <span class="text-gray-500">{{
                                student?.nim
                            }}</span>
                        </div>

                        <!-- User Dropdown -->
                        <div class="relative" v-click-outside="closeUserMenu">
                            <button
                                @click="showUserMenu = !showUserMenu"
                                class="flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                <div
                                    class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center"
                                >
                                    <span
                                        class="text-sm font-medium text-indigo-600"
                                    >
                                        {{ parentName.charAt(0).toUpperCase() }}
                                    </span>
                                </div>
                                <ChevronDownIcon class="ml-2 h-4 w-4" />
                            </button>

                            <!-- Dropdown Menu -->
                            <Transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div
                                    v-show="showUserMenu"
                                    class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                >
                                    <div
                                        class="px-4 py-3 border-b border-gray-100"
                                    >
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ parentName }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ parentRelation }}
                                        </p>
                                    </div>
                                    <div class="py-1">
                                        <Link
                                            :href="route('parent.profile')"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            <UserIcon class="mr-3 h-4 w-4" />
                                            Profil Mahasiswa
                                        </Link>
                                        <Link
                                            :href="
                                                route('parent.access-history')
                                            "
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            <ClockIcon class="mr-3 h-4 w-4" />
                                            Riwayat Akses
                                        </Link>
                                        <Link
                                            :href="
                                                route('parent.change-password')
                                            "
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            <KeyIcon class="mr-3 h-4 w-4" />
                                            Ubah Password
                                        </Link>
                                        <div
                                            class="border-t border-gray-100 mt-1"
                                        >
                                            <button
                                                @click="logout"
                                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                            >
                                                <ArrowLeftOnRectangleIcon
                                                    class="mr-3 h-4 w-4"
                                                />
                                                Keluar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Student Info -->
        <div
            class="md:hidden bg-indigo-50 border-b border-indigo-100 px-4 py-3"
        >
            <div class="flex items-center text-sm">
                <UserIcon class="h-4 w-4 mr-2 text-indigo-600" />
                <span class="font-medium text-indigo-900">{{
                    student?.name
                }}</span>
                <span class="mx-2 text-indigo-400">•</span>
                <span class="text-indigo-600">{{ student?.nim }}</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex space-x-8">
                    <Link
                        :href="route('parent.dashboard')"
                        :class="[
                            'inline-flex items-center px-1 pt-1 pb-4 border-b-2 text-sm font-medium',
                            route().current('parent.dashboard') ||
                            route().current('parent.home')
                                ? 'border-indigo-500 text-indigo-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                        ]"
                    >
                        <HomeIcon class="mr-2 h-4 w-4" />
                        Dashboard
                    </Link>
                    <Link
                        :href="route('parent.khs.index')"
                        :class="[
                            'inline-flex items-center px-1 pt-1 pb-4 border-b-2 text-sm font-medium',
                            route().current('parent.khs.*')
                                ? 'border-indigo-500 text-indigo-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                        ]"
                    >
                        <DocumentTextIcon class="mr-2 h-4 w-4" />
                        Daftar KHS
                    </Link>
                </nav>
            </div>
        </div>

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            <div v-if="flash?.message" class="mb-6">
                <div
                    :class="[
                        'rounded-md p-4',
                        flash.type === 'success' &&
                            'bg-green-50 border border-green-200',
                        flash.type === 'error' &&
                            'bg-red-50 border border-red-200',
                        flash.type === 'warning' &&
                            'bg-yellow-50 border border-yellow-200',
                        flash.type === 'info' &&
                            'bg-blue-50 border border-blue-200',
                    ]"
                >
                    <div class="flex items-center">
                        <CheckCircleIcon
                            v-if="flash.type === 'success'"
                            class="h-5 w-5 text-green-600 mr-3"
                        />
                        <ExclamationCircleIcon
                            v-else-if="flash.type === 'error'"
                            class="h-5 w-5 text-red-600 mr-3"
                        />
                        <ExclamationTriangleIcon
                            v-else-if="flash.type === 'warning'"
                            class="h-5 w-5 text-yellow-600 mr-3"
                        />
                        <InformationCircleIcon
                            v-else
                            class="h-5 w-5 text-blue-600 mr-3"
                        />
                        <p
                            :class="[
                                'text-sm font-medium',
                                flash.type === 'success' && 'text-green-800',
                                flash.type === 'error' && 'text-red-800',
                                flash.type === 'warning' && 'text-yellow-800',
                                flash.type === 'info' && 'text-blue-800',
                            ]"
                        >
                            {{ flash.message }}
                        </p>
                    </div>
                </div>
            </div>

            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-500">
                    <p>
                        &copy; {{ new Date().getFullYear() }} Portal Orang Tua -
                        Sistem Informasi KHS
                    </p>
                    <p class="mt-1">
                        Butuh bantuan?
                        <a
                            href="mailto:admin@faculty.ac.id"
                            class="text-indigo-600 hover:text-indigo-500"
                        >
                            Hubungi Admin
                        </a>
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import {
    AcademicCapIcon,
    UserIcon,
    ChevronDownIcon,
    HomeIcon,
    DocumentTextIcon,
    ClockIcon,
    KeyIcon,
    ArrowLeftOnRectangleIcon,
    CheckCircleIcon,
    ExclamationCircleIcon,
    ExclamationTriangleIcon,
    InformationCircleIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    student: Object,
    parent: Object,
});

// Page data
const page = usePage();
const flash = computed(() => page.props.flash);

// State
const showUserMenu = ref(false);

// Computed
const parentName = computed(() => props.parent?.name || "Parent");
const parentRelation = computed(
    () => props.parent?.relation_label || "Orang Tua"
);

// Methods
const closeUserMenu = () => {
    showUserMenu.value = false;
};

const logout = () => {
    router.post(route("parent.logout"));
};

// Click outside directive
const vClickOutside = {
    beforeMount(el, binding) {
        el.clickOutsideEvent = function (event) {
            if (!(el === event.target || el.contains(event.target))) {
                binding.value();
            }
        };
        document.addEventListener("click", el.clickOutsideEvent);
    },
    unmounted(el) {
        document.removeEventListener("click", el.clickOutsideEvent);
    },
};
</script>
