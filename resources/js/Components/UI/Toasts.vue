<template>
    <div class="fixed top-4 right-4 z-50 space-y-2">
        <div
            v-for="toast in toasts"
            :key="toast.id"
            class="flex items-center p-4 rounded-lg shadow-lg"
            :class="toastClasses(toast.type)"
        >
            <div class="flex-shrink-0">
                <component :is="getIcon(toast.type)" class="w-5 h-5" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ toast.message }}</p>
            </div>
            <button
                @click="removeToast(toast.id)"
                class="ml-4 flex-shrink-0 text-gray-400 hover:text-gray-600"
            >
                <XMarkIcon class="w-4 h-4" />
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
    CheckCircleIcon,
    ExclamationTriangleIcon,
    InformationCircleIcon,
    XCircleIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

const toasts = ref([]);
const page = usePage();

onMounted(() => {
    // Listen for flash messages from Laravel
    if (page.props.flash?.success) {
        addToast(page.props.flash.success, "success");
    }
    if (page.props.flash?.error) {
        addToast(page.props.flash.error, "error");
    }
    if (page.props.flash?.warning) {
        addToast(page.props.flash.warning, "warning");
    }
    if (page.props.flash?.info) {
        addToast(page.props.flash.info, "info");
    }
});

function addToast(message, type = "info") {
    const id = Date.now();
    toasts.value.push({ id, message, type });

    setTimeout(() => {
        removeToast(id);
    }, 5000);
}

function removeToast(id) {
    toasts.value = toasts.value.filter((toast) => toast.id !== id);
}

function toastClasses(type) {
    const classes = {
        success: "bg-green-50 text-green-800 border border-green-200",
        error: "bg-red-50 text-red-800 border border-red-200",
        warning: "bg-yellow-50 text-yellow-800 border border-yellow-200",
        info: "bg-blue-50 text-blue-800 border border-blue-200",
    };
    return classes[type] || classes.info;
}

function getIcon(type) {
    const icons = {
        success: CheckCircleIcon,
        error: XCircleIcon,
        warning: ExclamationTriangleIcon,
        info: InformationCircleIcon,
    };
    return icons[type] || icons.info;
}

// Expose addToast for global use
window.addToast = addToast;
</script>
