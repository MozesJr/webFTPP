// resources/js/Composables/useSwal.js
import Swal from "sweetalert2";

export function useSwal() {
    // Success notification
    const success = (title, text = "", options = {}) => {
        return Swal.fire({
            icon: "success",
            title: title,
            text: text,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
            ...options,
        });
    };

    // Error notification
    const error = (title, text = "", options = {}) => {
        return Swal.fire({
            icon: "error",
            title: title,
            text: text,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
            ...options,
        });
    };

    // Warning notification
    const warning = (title, text = "", options = {}) => {
        return Swal.fire({
            icon: "warning",
            title: title,
            text: text,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
            ...options,
        });
    };

    // Info notification
    const info = (title, text = "", options = {}) => {
        return Swal.fire({
            icon: "info",
            title: title,
            text: text,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
            ...options,
        });
    };

    // Confirmation dialog
    const confirm = (title, text = "", options = {}) => {
        return Swal.fire({
            title: title,
            text: text,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            reverseButtons: true,
            ...options,
        });
    };

    // Delete confirmation
    const confirmDelete = (
        title = "Hapus Data?",
        text = "Data yang dihapus tidak dapat dikembalikan!",
        options = {}
    ) => {
        return Swal.fire({
            title: title,
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
            reverseButtons: true,
            ...options,
        });
    };

    // Loading
    const loading = (title = "Loading...", text = "Mohon tunggu sebentar") => {
        return Swal.fire({
            title: title,
            text: text,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    };

    // Close any open SweetAlert
    const close = () => {
        Swal.close();
    };

    // Custom SweetAlert
    const fire = (options) => {
        return Swal.fire(options);
    };

    return {
        success,
        error,
        warning,
        info,
        confirm,
        confirmDelete,
        loading,
        close,
        fire,
    };
}
