<template>
    <Teleport to="body">
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Backdrop -->
                <div
                    class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                    @click="$emit('close')"
                ></div>

                <!-- Modal Content -->
                <div
                    class="relative bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto"
                >
                    <div class="p-6">
                        <!-- Close Button -->
                        <button
                            @click="$emit('close')"
                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
                        >
                            <XMarkIcon class="w-6 h-6" />
                        </button>

                        <!-- Content -->
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { XMarkIcon } from "@heroicons/vue/24/outline";

defineEmits(["close"]);
</script>
