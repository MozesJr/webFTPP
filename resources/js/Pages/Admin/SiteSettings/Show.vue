<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Site Setting
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi lengkap pengaturan website
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            href="/admin/site-settings"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                        <Link
                            :href="`/admin/site-settings/${setting.id}/edit`"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Setting Info -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Informasi Setting
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Key Name
                                </label>
                                <p
                                    class="mt-1 text-sm text-gray-900 font-mono bg-gray-50 px-2 py-1 rounded"
                                >
                                    {{ setting.key_name }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Type
                                </label>
                                <span
                                    :class="getTypeClass(setting.type)"
                                    class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                >
                                    {{ setting.type }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Group
                                </label>
                                <span
                                    class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    {{ setting.group }}
                                </span>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Last Updated
                                </label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ formatDateTime(setting.updated_at) }}
                                </p>
                            </div>
                        </div>

                        <div v-if="setting.description">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Description
                            </label>
                            <p
                                class="mt-1 text-sm text-gray-900 whitespace-pre-wrap"
                            >
                                {{ setting.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Value Display -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Current Value
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <!-- Boolean Value -->
                        <div
                            v-if="setting.type === 'boolean'"
                            class="flex items-center space-x-3"
                        >
                            <div
                                :class="
                                    setting.value
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800'
                                "
                                class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium"
                            >
                                <component
                                    :is="
                                        setting.value
                                            ? CheckCircleIcon
                                            : XCircleIcon
                                    "
                                    class="w-5 h-5 mr-2"
                                />
                                {{ setting.value ? "Enabled" : "Disabled" }}
                            </div>
                        </div>

                        <!-- File Value -->
                        <div
                            v-else-if="setting.type === 'file' && setting.value"
                            class="space-y-4"
                        >
                            <div
                                class="flex items-center p-4 bg-gray-50 rounded-lg border"
                            >
                                <DocumentTextIcon
                                    class="h-10 w-10 text-blue-600 mr-4"
                                />
                                <div class="flex-1">
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ getFileName(setting.value) }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Click download untuk melihat file
                                    </p>
                                </div>
                                <a
                                    :href="setting.value"
                                    target="_blank"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                                    Download
                                </a>
                            </div>

                            <!-- Image Preview -->
                            <div v-if="isImageFile(setting.value)" class="mt-4">
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Preview
                                </label>
                                <img
                                    :src="setting.value"
                                    :alt="setting.key_name"
                                    class="max-w-md h-auto rounded-lg border border-gray-300"
                                />
                            </div>
                        </div>

                        <!-- Color Value -->
                        <div
                            v-else-if="
                                setting.type === 'color' && setting.value
                            "
                            class="flex items-center space-x-4"
                        >
                            <div
                                :style="{ backgroundColor: setting.value }"
                                class="w-16 h-16 rounded-lg border-2 border-gray-300 shadow-sm"
                            ></div>
                            <div>
                                <p
                                    class="text-lg font-mono font-medium text-gray-900"
                                >
                                    {{ setting.value }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Color code value
                                </p>
                            </div>
                        </div>

                        <!-- URL Value -->
                        <div
                            v-else-if="setting.type === 'url' && setting.value"
                        >
                            <a
                                :href="setting.value"
                                target="_blank"
                                class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium"
                            >
                                <LinkIcon class="w-4 h-4 mr-2" />
                                {{ setting.value }}
                            </a>
                            <p class="mt-1 text-sm text-gray-500">
                                Click to open in new tab
                            </p>
                        </div>

                        <!-- Email Value -->
                        <div
                            v-else-if="
                                setting.type === 'email' && setting.value
                            "
                        >
                            <a
                                :href="`mailto:${setting.value}`"
                                class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium"
                            >
                                <AtSymbolIcon class="w-4 h-4 mr-2" />
                                {{ setting.value }}
                            </a>
                            <p class="mt-1 text-sm text-gray-500">
                                Click to send email
                            </p>
                        </div>

                        <!-- Textarea Value -->
                        <div v-else-if="setting.type === 'textarea'">
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <pre
                                    class="whitespace-pre-wrap text-sm text-gray-900 font-sans"
                                    >{{ setting.value || "No value set" }}</pre
                                >
                            </div>
                        </div>

                        <!-- Default Text/Number Value -->
                        <div v-else>
                            <div class="bg-gray-50 p-4 rounded-lg border">
                                <p class="text-sm text-gray-900 font-mono">
                                    {{ setting.value || "No value set" }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Quick Actions
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <Link
                            :href="`/admin/site-settings/${setting.id}/edit`"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <PencilIcon class="h-4 w-4 mr-2" />
                            Edit Setting
                        </Link>

                        <button
                            v-if="setting.type === 'file' && setting.value"
                            @click="downloadFile"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-green-300 shadow-sm text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                            Download File
                        </button>

                        <button
                            @click="handleDelete"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            <TrashIcon class="h-4 w-4 mr-2" />
                            Delete Setting
                        </button>
                    </div>
                </div>

                <!-- Related Settings -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Related Settings
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <Link
                            :href="`/admin/site-settings?group=${setting.group}`"
                            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900"
                        >
                            <FolderIcon class="w-4 h-4 mr-2" />
                            View all in "{{ setting.group }}" group
                        </Link>
                    </div>
                </div>

                <!-- Metadata -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Metadata
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Created At
                            </label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ formatDateTime(setting.created_at) }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Last Updated
                            </label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ formatDateTime(setting.updated_at) }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Setting ID
                            </label>
                            <p class="mt-1 text-sm text-gray-500 font-mono">
                                #{{ setting.id }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    ArrowLeftIcon,
    PencilIcon,
    DocumentTextIcon,
    ArrowDownTrayIcon,
    TrashIcon,
    CheckCircleIcon,
    XCircleIcon,
    LinkIcon,
    AtSymbolIcon,
    FolderIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    setting: {
        type: Object,
        required: true,
    },
});

// Composables
const { success, error, confirmDelete } = useSwal();

// Methods
const getTypeClass = (type) => {
    const classes = {
        text: "bg-blue-100 text-blue-800",
        textarea: "bg-blue-100 text-blue-800",
        email: "bg-green-100 text-green-800",
        url: "bg-purple-100 text-purple-800",
        file: "bg-yellow-100 text-yellow-800",
        number: "bg-indigo-100 text-indigo-800",
        boolean: "bg-pink-100 text-pink-800",
        color: "bg-red-100 text-red-800",
    };
    return classes[type] || "bg-gray-100 text-gray-800";
};

const getFileName = (url) => {
    if (!url) return "";
    return url.split("/").pop();
};

const isImageFile = (url) => {
    if (!url) return false;
    const imageExtensions = [".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg"];
    return imageExtensions.some((ext) => url.toLowerCase().includes(ext));
};

const formatDateTime = (dateString) => {
    if (!dateString) return "-";
    return new Date(dateString).toLocaleString("id-ID");
};

const downloadFile = () => {
    if (props.setting.value) {
        window.open(props.setting.value, "_blank");
    }
};

const handleDelete = async () => {
    const result = await confirmDelete(
        "Hapus Setting?",
        `Setting "${props.setting.key_name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/site-settings/${props.setting.id}`, {
            onSuccess: () => {
                success("Berhasil!", "Setting berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus setting.");
            },
        });
    }
};
</script>
