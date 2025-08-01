<template>
    <!-- Backdrop -->
    <div
        class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 transition-opacity"
        @click="$emit('close')"
    ></div>

    <!-- Right Sidebar -->
    <div
        class="fixed inset-y-0 right-0 z-50 w-80 bg-white shadow-xl transform transition-transform duration-300 ease-in-out"
    >
        <!-- Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-200"
        >
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Settings</h3>
                <p class="text-sm text-gray-600">Customize your interface</p>
            </div>
            <button
                @click="$emit('close')"
                class="text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg p-1"
            >
                <XMarkIcon class="w-6 h-6" />
            </button>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Theme Settings -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3">Theme</h4>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input
                            type="radio"
                            name="theme"
                            value="light"
                            class="text-blue-600 focus:ring-blue-500"
                            checked
                        />
                        <span class="ml-3 text-sm text-gray-700">Light</span>
                    </label>
                    <label class="flex items-center">
                        <input
                            type="radio"
                            name="theme"
                            value="dark"
                            class="text-blue-600 focus:ring-blue-500"
                        />
                        <span class="ml-3 text-sm text-gray-700">Dark</span>
                    </label>
                    <label class="flex items-center">
                        <input
                            type="radio"
                            name="theme"
                            value="auto"
                            class="text-blue-600 focus:ring-blue-500"
                        />
                        <span class="ml-3 text-sm text-gray-700">Auto</span>
                    </label>
                </div>
            </div>

            <!-- Sidebar Style -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3">
                    Sidebar Style
                </h4>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input
                            type="radio"
                            name="sidebar"
                            value="light"
                            class="text-blue-600 focus:ring-blue-500"
                            checked
                        />
                        <span class="ml-3 text-sm text-gray-700">Light</span>
                    </label>
                    <label class="flex items-center">
                        <input
                            type="radio"
                            name="sidebar"
                            value="dark"
                            class="text-blue-600 focus:ring-blue-500"
                        />
                        <span class="ml-3 text-sm text-gray-700">Dark</span>
                    </label>
                </div>
            </div>

            <!-- Accent Color -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3">
                    Accent Color
                </h4>
                <div class="grid grid-cols-4 gap-2">
                    <button
                        class="w-8 h-8 bg-blue-500 rounded-lg ring-2 ring-blue-200"
                    ></button>
                    <button
                        class="w-8 h-8 bg-green-500 rounded-lg hover:ring-2 hover:ring-green-200"
                    ></button>
                    <button
                        class="w-8 h-8 bg-purple-500 rounded-lg hover:ring-2 hover:ring-purple-200"
                    ></button>
                    <button
                        class="w-8 h-8 bg-red-500 rounded-lg hover:ring-2 hover:ring-red-200"
                    ></button>
                    <button
                        class="w-8 h-8 bg-yellow-500 rounded-lg hover:ring-2 hover:ring-yellow-200"
                    ></button>
                    <button
                        class="w-8 h-8 bg-pink-500 rounded-lg hover:ring-2 hover:ring-pink-200"
                    ></button>
                    <button
                        class="w-8 h-8 bg-indigo-500 rounded-lg hover:ring-2 hover:ring-indigo-200"
                    ></button>
                    <button
                        class="w-8 h-8 bg-gray-500 rounded-lg hover:ring-2 hover:ring-gray-200"
                    ></button>
                </div>
            </div>

            <!-- Layout Options -->
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-3">Layout</h4>
                <div class="space-y-2">
                    <label class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Compact Mode</span>
                        <input
                            type="checkbox"
                            class="text-blue-600 focus:ring-blue-500 rounded"
                        />
                    </label>
                    <label class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Fixed Header</span>
                        <input
                            type="checkbox"
                            class="text-blue-600 focus:ring-blue-500 rounded"
                            checked
                        />
                    </label>
                    <label class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Fixed Sidebar</span>
                        <input
                            type="checkbox"
                            class="text-blue-600 focus:ring-blue-500 rounded"
                            checked
                        />
                    </label>
                </div>
            </div>

            <!-- Reset Button -->
            <div class="pt-4 border-t border-gray-200">
                <button
                    class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
                >
                    Reset Settings
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { XMarkIcon } from "@heroicons/vue/24/outline";

defineEmits(["close"]);
</script>
