<template>
    <teleport to="body">
        <div class="fixed top-0 right-0 z-50 p-4 space-y-4 pointer-events-none">
            <transition-group name="toast" tag="div" class="space-y-4">
                <div
                    v-for="toast in toasts"
                    :key="toast.id"
                    class="pointer-events-auto"
                >
                    <ToastNotification
                        :show="toast.show"
                        :type="toast.type"
                        :title="toast.title"
                        :message="toast.message"
                        :auto-close="toast.autoClose"
                        :duration="toast.duration"
                        @close="removeToast(toast.id)"
                    />
                </div>
            </transition-group>
        </div>
    </teleport>
</template>

<script setup>
import { useToast } from "@/Composables/useToast";
import ToastNotification from "@/Components/ToastNotification.vue";

const { toasts, removeToast } = useToast();
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
    transition: all 0.3s ease;
}

.toast-enter-from {
    opacity: 0;
    transform: translateX(100%);
}

.toast-leave-to {
    opacity: 0;
    transform: translateX(100%);
}

.toast-move {
    transition: transform 0.3s ease;
}
</style>
