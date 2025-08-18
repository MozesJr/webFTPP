<!-- resources/js/Layouts/ParentLayout.vue (Breeze Compatible) -->
<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <AcademicCapIcon class="h-8 w-8 text-indigo-600" />
                            <div class="ml-3">
                                <h1 class="text-lg font-semibold text-gray-900">
                                    Portal Orang Tua
                                </h1>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div
                            class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                        >
                            <NavLink
                                :href="route('parent.dashboard')"
                                :active="route().current('parent.dashboard')"
                            >
                                Dashboard
                            </NavLink>
                            <NavLink
                                :href="route('parent.khs.index')"
                                :active="route().current('parent.khs.*')"
                            >
                                Daftar KHS
                            </NavLink>
                        </div>
                    </div>

                    <!-- Student Info (Desktop) -->
                    <div
                        class="hidden md:flex items-center text-sm text-gray-700"
                    >
                        <UserIcon class="h-4 w-4 mr-2 text-gray-400" />
                        <span class="font-medium">{{
                            $page.props.auth.student?.name
                        }}</span>
                        <span class="mx-2 text-gray-400">•</span>
                        <span class="text-gray-500">{{
                            $page.props.auth.student?.nim
                        }}</span>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        >
                                            {{ $page.props.auth.parent?.name }}
                                            <svg
                                                class="ms-2 -me-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink
                                        :href="route('parent.profile')"
                                        >Profil</DropdownLink
                                    >
                                    <DropdownLink
                                        :href="route('parent.access-history')"
                                        >Riwayat Akses</DropdownLink
                                    >
                                    <DropdownLink
                                        :href="route('parent.change-password')"
                                        >Ubah Password</DropdownLink
                                    >
                                    <DropdownLink
                                        :href="route('parent.logout')"
                                        method="post"
                                        as="button"
                                    >
                                        Keluar
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="sm:hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink
                        :href="route('parent.dashboard')"
                        :active="route().current('parent.dashboard')"
                    >
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('parent.khs.index')"
                        :active="route().current('parent.khs.*')"
                    >
                        Daftar KHS
                    </ResponsiveNavLink>
                </div>

                <!-- Student Info Mobile -->
                <div class="pt-2 pb-3 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">
                            {{ $page.props.auth.student?.name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">
                            {{ $page.props.auth.student?.nim }}
                        </div>
                    </div>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">
                            {{ $page.props.auth.parent?.name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">
                            {{ $page.props.auth.parent?.relation_label }}
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('parent.profile')"
                            >Profil</ResponsiveNavLink
                        >
                        <ResponsiveNavLink
                            :href="route('parent.access-history')"
                            >Riwayat Akses</ResponsiveNavLink
                        >
                        <ResponsiveNavLink
                            :href="route('parent.change-password')"
                            >Ubah Password</ResponsiveNavLink
                        >
                        <ResponsiveNavLink
                            :href="route('parent.logout')"
                            method="post"
                            as="button"
                        >
                            Keluar
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <!-- Flash Messages -->
            <div
                v-if="$page.props.flash?.message"
                class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8"
            >
                <div
                    :class="[
                        'rounded-md p-4',
                        $page.props.flash.type === 'success' &&
                            'bg-green-50 border border-green-200',
                        $page.props.flash.type === 'error' &&
                            'bg-red-50 border border-red-200',
                        $page.props.flash.type === 'warning' &&
                            'bg-yellow-50 border border-yellow-200',
                        $page.props.flash.type === 'info' &&
                            'bg-blue-50 border border-blue-200',
                    ]"
                >
                    <div class="flex items-center">
                        <CheckCircleIcon
                            v-if="$page.props.flash.type === 'success'"
                            class="h-5 w-5 text-green-600 mr-3"
                        />
                        <ExclamationCircleIcon
                            v-else-if="$page.props.flash.type === 'error'"
                            class="h-5 w-5 text-red-600 mr-3"
                        />
                        <ExclamationTriangleIcon
                            v-else-if="$page.props.flash.type === 'warning'"
                            class="h-5 w-5 text-yellow-600 mr-3"
                        />
                        <InformationCircleIcon
                            v-else
                            class="h-5 w-5 text-blue-600 mr-3"
                        />
                        <p
                            :class="[
                                'text-sm font-medium',
                                $page.props.flash.type === 'success' &&
                                    'text-green-800',
                                $page.props.flash.type === 'error' &&
                                    'text-red-800',
                                $page.props.flash.type === 'warning' &&
                                    'text-yellow-800',
                                $page.props.flash.type === 'info' &&
                                    'text-blue-800',
                            ]"
                        >
                            {{ $page.props.flash.message }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <slot />
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import {
    AcademicCapIcon,
    UserIcon,
    CheckCircleIcon,
    ExclamationCircleIcon,
    ExclamationTriangleIcon,
    InformationCircleIcon,
} from "@heroicons/vue/24/outline";

const showingNavigationDropdown = ref(false);
</script>
