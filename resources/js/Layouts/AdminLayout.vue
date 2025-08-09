<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Pre-loader -->
        <div
            v-if="loading"
            class="pre-loader fixed inset-0 z-50 flex items-center justify-center bg-white"
        >
            <div class="pre-loader-box text-center">
                <div class="loader-logo mb-4">
                    <img
                        src="/storage/assets/img/Logo_Universitas_Papua.png"
                        alt="FTPP Logo"
                        class="w-16 h-16 mx-auto"
                    />
                </div>
                <div
                    class="loader-progress bg-gray-200 rounded-full h-2 w-48 mx-auto mb-2"
                >
                    <div
                        class="bar bg-blue-500 h-full rounded-full transition-all duration-300"
                        :style="`width: ${loadingProgress}%`"
                    ></div>
                </div>
                <div class="percent text-blue-600 font-semibold">
                    {{ loadingProgress }}%
                </div>
                <div class="loading-text text-gray-600 mt-2">Loading...</div>
            </div>
        </div>

        <div class="flex h-screen overflow-hidden">
            <!-- Mobile sidebar backdrop -->
            <div
                v-if="sidebarOpen"
                class="fixed inset-0 z-40 lg:hidden"
                @click="sidebarOpen = false"
            >
                <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
            </div>

            <!-- Sidebar -->
            <ModernSidebar
                :sidebarOpen="sidebarOpen"
                @close="sidebarOpen = false"
            />

            <!-- Main content -->
            <div class="flex flex-col flex-1 overflow-hidden">
                <!-- Top navigation -->
                <ModernHeader @toggle-sidebar="sidebarOpen = !sidebarOpen" />

                <!-- Page content -->
                <main
                    class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50"
                >
                    <div class="px-6 py-8">
                        <slot />
                    </div>
                </main>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-600">
                            FTPP Admin Panel - Fakultas Teknik Pertambangan dan
                            Perminyakan
                        </p>
                        <p class="text-sm text-gray-500">
                            © {{ new Date().getFullYear() }} All rights reserved
                        </p>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Right Sidebar (Settings) -->
        <RightSidebar
            v-if="rightSidebarOpen"
            @close="rightSidebarOpen = false"
        />

        <!-- Toast notifications -->
        <Toasts />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import ModernSidebar from "@/Components/Admin/ModernSidebar.vue";
import ModernHeader from "@/Components/Admin/ModernHeader.vue";
import RightSidebar from "@/Components/Admin/RightSidebar.vue";
import Toasts from "@/Components/UI/Toasts.vue";

const sidebarOpen = ref(false);
const rightSidebarOpen = ref(false);
const loading = ref(true);
const loadingProgress = ref(0);

onMounted(() => {
    // Simulate loading
    const interval = setInterval(() => {
        loadingProgress.value += 10;
        if (loadingProgress.value >= 100) {
            clearInterval(interval);
            setTimeout(() => {
                loading.value = false;
            }, 500);
        }
    }, 100);
});

// Global method to toggle right sidebar
window.toggleRightSidebar = () => {
    rightSidebarOpen.value = !rightSidebarOpen.value;
};
</script>

<style scoped>
.pre-loader {
    animation: fadeOut 0.5s ease-in-out 2s forwards;
}

@keyframes fadeOut {
    to {
        opacity: 0;
        visibility: hidden;
    }
}
</style>
