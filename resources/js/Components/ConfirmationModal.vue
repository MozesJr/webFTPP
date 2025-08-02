<template>
    <teleport to="body">
        <transition name="modal" appear>
            <div
                v-if="show"
                class="fixed inset-0 z-50 overflow-y-auto"
                aria-labelledby="modal-title"
                role="dialog"
                aria-modal="true"
            >
                <!-- Background overlay -->
                <div
                    class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
                >
                    <transition
                        name="modal-overlay"
                        appear
                        enter-active-class="transition-opacity ease-out duration-300"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="transition-opacity ease-in duration-200"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <div
                            v-if="show"
                            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                            @click="$emit('close')"
                        ></div>
                    </transition>

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span
                        class="hidden sm:inline-block sm:align-middle sm:h-screen"
                        aria-hidden="true"
                        >&#8203;</span
                    >

                    <!-- Modal panel -->
                    <transition
                        name="modal-panel"
                        appear
                        enter-active-class="transition-all ease-out duration-300"
                        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="transition-all ease-in duration-200"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <div
                            v-if="show"
                            class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg"
                        >
                            <!-- Icon -->
                            <div
                                class="flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full"
                                :class="iconClasses"
                            >
                                <component
                                    :is="iconComponent"
                                    class="w-6 h-6"
                                />
                            </div>

                            <!-- Title -->
                            <div class="text-center">
                                <h3
                                    class="text-lg font-medium leading-6 text-gray-900 mb-2"
                                    id="modal-title"
                                >
                                    {{ title }}
                                </h3>

                                <!-- Message -->
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        {{ message }}
                                    </p>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div
                                class="mt-6 flex flex-col sm:flex-row gap-3 sm:gap-3"
                            >
                                <button
                                    type="button"
                                    @click="$emit('close')"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors"
                                >
                                    {{ cancelText }}
                                </button>

                                <button
                                    type="button"
                                    @click="handleConfirm"
                                    :disabled="processing"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors"
                                    :class="confirmButtonClasses"
                                >
                                    <span v-if="processing">
                                        <svg
                                            class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                        >
                                            <circle
                                                class="opacity-25"
                                                cx="12"
                                                cy="12"
                                                r="10"
                                                stroke="currentColor"
                                                stroke-width="4"
                                            ></circle>
                                            <path
                                                class="opacity-75"
                                                fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                            ></path>
                                        </svg>
                                        Processing...
                                    </span>
                                    <span v-else>
                                        {{ confirmText }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </transition>
    </teleport>
</template>

<script setup>
import { computed, ref } from "vue";
import {
    ExclamationTriangleIcon,
    TrashIcon,
    QuestionMarkCircleIcon,
    ExclamationCircleIcon,
    CheckCircleIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: "Konfirmasi",
    },
    message: {
        type: String,
        default: "Apakah Anda yakin ingin melanjutkan?",
    },
    confirmText: {
        type: String,
        default: "Konfirmasi",
    },
    cancelText: {
        type: String,
        default: "Batal",
    },
    confirmColor: {
        type: String,
        default: "primary", // primary, danger, warning, success
        validator: (value) =>
            ["primary", "danger", "warning", "success"].includes(value),
    },
    type: {
        type: String,
        default: "warning", // warning, danger, question, info, success
        validator: (value) =>
            ["warning", "danger", "question", "info", "success"].includes(
                value
            ),
    },
});

const emit = defineEmits(["close", "confirm"]);

const processing = ref(false);

const iconComponent = computed(() => {
    const icons = {
        warning: ExclamationTriangleIcon,
        danger: TrashIcon,
        question: QuestionMarkCircleIcon,
        info: ExclamationCircleIcon,
        success: CheckCircleIcon,
    };
    return icons[props.type] || ExclamationTriangleIcon;
});

const iconClasses = computed(() => {
    const classes = {
        warning: "bg-yellow-100 text-yellow-600",
        danger: "bg-red-100 text-red-600",
        question: "bg-blue-100 text-blue-600",
        info: "bg-blue-100 text-blue-600",
        success: "bg-green-100 text-green-600",
    };
    return classes[props.type] || classes.warning;
});

const confirmButtonClasses = computed(() => {
    const classes = {
        primary:
            "bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 disabled:bg-blue-400",
        danger: "bg-red-600 hover:bg-red-700 focus:ring-red-500 disabled:bg-red-400",
        warning:
            "bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500 disabled:bg-yellow-400",
        success:
            "bg-green-600 hover:bg-green-700 focus:ring-green-500 disabled:bg-green-400",
    };
    return classes[props.confirmColor] || classes.primary;
});

async function handleConfirm() {
    processing.value = true;

    try {
        await emit("confirm");
    } finally {
        processing.value = false;
    }
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>
