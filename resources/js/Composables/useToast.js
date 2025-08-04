// resources/js/Composables/useToast.js
import { ref, reactive } from "vue";

const toasts = ref([]);

export function useToast() {
    const addToast = (toast) => {
        const id = Date.now() + Math.random();
        const newToast = {
            id,
            show: true,
            type: "success",
            autoClose: true,
            duration: 5000,
            ...toast,
        };

        toasts.value.push(newToast);

        return id;
    };

    const removeToast = (id) => {
        const index = toasts.value.findIndex((toast) => toast.id === id);
        if (index > -1) {
            toasts.value.splice(index, 1);
        }
    };

    const success = (title, message = "", options = {}) => {
        return addToast({
            type: "success",
            title,
            message,
            ...options,
        });
    };

    const error = (title, message = "", options = {}) => {
        return addToast({
            type: "error",
            title,
            message,
            autoClose: false, // Error messages should be manually closed
            ...options,
        });
    };

    const warning = (title, message = "", options = {}) => {
        return addToast({
            type: "warning",
            title,
            message,
            ...options,
        });
    };

    const info = (title, message = "", options = {}) => {
        return addToast({
            type: "info",
            title,
            message,
            ...options,
        });
    };

    const clear = () => {
        toasts.value = [];
    };

    return {
        toasts,
        addToast,
        removeToast,
        success,
        error,
        warning,
        info,
        clear,
    };
}
