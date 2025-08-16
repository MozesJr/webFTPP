<!-- resources/js/Pages/SuperAdmin/SystemSettings.vue -->
<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        System Settings
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Konfigurasi sistem tingkat lanjut
                    </p>
                </div>

                <!-- Development Notice -->
                <div
                    class="bg-red-50 border border-red-200 rounded-lg p-6 mb-8"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center"
                            >
                                <span class="text-red-600 text-xl">⚙️</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-900">
                                System Settings
                            </h3>
                            <p class="text-red-700">{{ message }}</p>
                        </div>
                    </div>
                </div>

                <!-- Planned System Settings -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">
                            Database Management
                        </h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• Database backup & restore</li>
                            <li>• Database optimization</li>
                            <li>• Data migration tools</li>
                        </ul>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">
                            System Maintenance
                        </h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• Maintenance mode toggle</li>
                            <li>• Cache management</li>
                            <li>• Log file management</li>
                        </ul>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">
                            Security Settings
                        </h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• SSL certificate management</li>
                            <li>• Security monitoring</li>
                            <li>• Audit log settings</li>
                        </ul>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">
                            Email Configuration
                        </h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li>• SMTP settings</li>
                            <li>• Email templates</li>
                            <li>• Notification preferences</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    message: String,
});
</script>
