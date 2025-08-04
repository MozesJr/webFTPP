<template>
    <teleport to="body">
        <transition
            enter-active-class="transform ease-out duration-300 transition"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="show" class="fixed top-4 right-4 z-50 w-full max-w-sm">
                <div
                    class="bg-white rounded-lg shadow-lg border-l-4 overflow-hidden"
                    :class="borderColorClass"
                >
                    <!-- Progress bar -->
                    <div
                        v-if="autoClose && duration > 0"
                        class="h-1 bg-gray-200"
                    >
                        <div
                            class="h-full transition-all ease-linear"
                            :class="progressColorClass"
                            :style="{ width: `${progress}%` }"
                        ></div>
                    </div>

                    <div class="p-4">
                        <div class="flex items-start">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <component
                                    :is="iconComponent"
                                    class="h-6 w-6"
                                    :class="iconColorClass"
                                />
                            </div>

                            <!-- Content -->
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ title }}
                                </p>
                                <p
                                    v-if="message"
                                    class="mt-1 text-sm text-gray-500"
                                >
                                    {{ message }}
                                </p>
                            </div>

                            <!-- Close button -->
                            <div class="ml-4 flex-shrink-0 flex">
                                <button
                                    @click="close"
                                    class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                                >
                                    <XMarkIcon class="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>

<script setup>
import { ref, computed, watch, onUnmounted } from "vue";
import {
    CheckCircleIcon,
    ExclamationCircleIcon,
    ExclamationTriangleIcon,
    InformationCircleIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    type: {
        type: String,
        default: "success", // success, error, warning, info
        validator: (value) =>
            ["success", "error", "warning", "info"].includes(value),
    },
    title: {
        type: String,
        required: true,
    },
    message: {
        type: String,
        default: "",
    },
    autoClose: {
        type: Boolean,
        default: true,
    },
    duration: {
        type: Number,
        default: 4000, // 4 seconds
    },
});

const emit = defineEmits(["close"]);

const progress = ref(100);
let progressInterval = null;

const iconComponent = computed(() => {
    const icons = {
        success: CheckCircleIcon,
        error: ExclamationCircleIcon,
        warning: ExclamationTriangleIcon,
        info: InformationCircleIcon,
    };
    return icons[props.type];
});

const iconColorClass = computed(() => {
    const classes = {
        success: "text-green-500",
        error: "text-red-500",
        warning: "text-yellow-500",
        info: "text-blue-500",
    };
    return classes[props.type];
});

const borderColorClass = computed(() => {
    const classes = {
        success: "border-l-green-500",
        error: "border-l-red-500",
        warning: "border-l-yellow-500",
        info: "border-l-blue-500",
    };
    return classes[props.type];
});

const progressColorClass = computed(() => {
    const classes = {
        success: "bg-green-500",
        error: "bg-red-500",
        warning: "bg-yellow-500",
        info: "bg-blue-500",
    };
    return classes[props.type];
});

function close() {
    clearProgressInterval();
    emit("close");
}

function startProgressTimer() {
    if (!props.autoClose || props.duration <= 0) return;

    progress.value = 100;
    const startTime = Date.now();

    progressInterval = setInterval(() => {
        const elapsed = Date.now() - startTime;
        const remaining = Math.max(0, props.duration - elapsed);
        progress.value = (remaining / props.duration) * 100;

        if (remaining <= 0) {
            close();
        }
    }, 50);
}

function clearProgressInterval() {
    if (progressInterval) {
        clearInterval(progressInterval);
        progressInterval = null;
    }
}

watch(
    () => props.show,
    (newValue) => {
        if (newValue) {
            startProgressTimer();
        } else {
            clearProgressInterval();
        }
    }
);

// Auto close untuk error messages setelah 8 detik
watch(
    () => [props.show, props.type],
    ([show, type]) => {
        if (show && type === "error") {
            setTimeout(() => {
                if (props.show) close();
            }, 8000);
        }
    }
);

onUnmounted(() => {
    clearProgressInterval();
});
</script>
