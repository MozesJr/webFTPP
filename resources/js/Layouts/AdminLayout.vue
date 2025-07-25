<template>
    <div class="min-h-screen bg-gray-100">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <AdminSidebar
                :sidebarOpen="sidebarOpen"
                @close="sidebarOpen = false"
            />

            <!-- Main content -->
            <div class="flex flex-col flex-1 overflow-hidden">
                <!-- Top navigation -->
                <AdminNavbar @toggle-sidebar="sidebarOpen = !sidebarOpen" />

                <!-- Page content -->
                <main
                    class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100"
                >
                    <div class="container mx-auto px-6 py-8">
                        <slot />
                    </div>
                </main>
            </div>
        </div>

        <!-- Toast notifications -->
        <Toasts />
    </div>
</template>

<script setup>
import { ref } from "vue";
import AdminSidebar from "@/Components/Admin/AdminSidebar.vue";
import AdminNavbar from "@/Components/Admin/AdminNavbar.vue";
import Toasts from "@/Components/UI/Toasts.vue";

const sidebarOpen = ref(false);
</script>
