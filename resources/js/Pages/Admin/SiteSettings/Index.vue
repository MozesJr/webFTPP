<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Site Settings
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola pengaturan website
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <button
                            @click="showBulkEdit = !showBulkEdit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilSquareIcon class="w-4 h-4 mr-2" />
                            {{
                                showBulkEdit ? "Cancel Bulk Edit" : "Bulk Edit"
                            }}
                        </button>
                        <Link
                            href="/admin/site-settings/create"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PlusIcon class="w-4 h-4 mr-2" />
                            Tambah Setting
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Group
                        </label>
                        <select
                            v-model="filterForm.group"
                            @change="applyFilters"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Semua Group</option>
                            <option
                                v-for="group in groups"
                                :key="group"
                                :value="group"
                            >
                                {{ group }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Type
                        </label>
                        <select
                            v-model="filterForm.type"
                            @change="applyFilters"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">Semua Type</option>
                            <option
                                v-for="type in types"
                                :key="type"
                                :value="type"
                            >
                                {{ type }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Cari
                        </label>
                        <input
                            v-model="filterForm.search"
                            @keyup.enter="applyFilters"
                            type="text"
                            placeholder="Cari setting..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>
                <div class="flex justify-end mt-4 space-x-2">
                    <button
                        @click="applyFilters"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                    >
                        <MagnifyingGlassIcon class="w-4 h-4 mr-2" />
                        Cari
                    </button>
                    <button
                        @click="resetFilters"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                    >
                        <XMarkIcon class="w-4 h-4 mr-2" />
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Bulk Edit Form -->
        <div
            v-if="showBulkEdit"
            class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6"
        >
            <form @submit.prevent="submitBulkUpdate">
                <h3 class="text-lg font-medium text-yellow-800 mb-4">
                    Bulk Edit Mode
                </h3>
                <div class="space-y-4">
                    <div
                        v-for="setting in settings.data"
                        :key="setting.id"
                        class="flex items-center space-x-4"
                    >
                        <div class="w-48">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                {{ setting.key_name }}
                            </label>
                        </div>
                        <div class="flex-1">
                            <input
                                v-if="
                                    setting.type === 'text' ||
                                    setting.type === 'email' ||
                                    setting.type === 'url'
                                "
                                v-model="bulkEditForm[setting.id]"
                                type="text"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <textarea
                                v-else-if="setting.type === 'textarea'"
                                v-model="bulkEditForm[setting.id]"
                                rows="2"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            ></textarea>
                            <input
                                v-else-if="setting.type === 'number'"
                                v-model="bulkEditForm[setting.id]"
                                type="number"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <input
                                v-else-if="setting.type === 'color'"
                                v-model="bulkEditForm[setting.id]"
                                type="color"
                                class="w-full h-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <label
                                v-else-if="setting.type === 'boolean'"
                                class="flex items-center"
                            >
                                <input
                                    v-model="bulkEditForm[setting.id]"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                <span class="ml-2 text-sm text-gray-600"
                                    >Enable</span
                                >
                            </label>
                            <span v-else class="text-sm text-gray-500">
                                File type - edit individually
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-6 space-x-3">
                    <button
                        type="button"
                        @click="showBulkEdit = false"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="bulkUpdateProcessing"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 disabled:opacity-50"
                    >
                        Save All Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Settings Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Setting
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Value
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Type
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Group
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-if="settings.data.length === 0">
                            <td colspan="5" class="px-6 py-12 text-center">
                                <CogIcon
                                    class="mx-auto h-12 w-12 text-gray-400"
                                />
                                <h3
                                    class="mt-4 text-lg font-medium text-gray-900"
                                >
                                    Belum ada pengaturan
                                </h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    Mulai dengan menambahkan pengaturan pertama.
                                </p>
                                <div class="mt-6">
                                    <Link
                                        href="/admin/site-settings/create"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                                    >
                                        <PlusIcon class="w-4 h-4 mr-2" />
                                        Tambah Setting
                                    </Link>
                                </div>
                            </td>
                        </tr>
                        <tr
                            v-for="setting in settings.data"
                            :key="setting.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center"
                                        >
                                            <CogIcon
                                                class="h-5 w-5 text-indigo-600"
                                            />
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ setting.key_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ setting.description || "-" }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <span v-if="setting.type === 'boolean'">
                                        <span
                                            :class="
                                                setting.value
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'
                                            "
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        >
                                            {{ setting.value ? "Yes" : "No" }}
                                        </span>
                                    </span>
                                    <span
                                        v-else-if="
                                            setting.type === 'file' &&
                                            setting.value
                                        "
                                    >
                                        <a
                                            :href="setting.value"
                                            target="_blank"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            {{ getFileName(setting.value) }}
                                        </a>
                                    </span>
                                    <span
                                        v-else-if="
                                            setting.type === 'color' &&
                                            setting.value
                                        "
                                    >
                                        <div
                                            class="flex items-center space-x-2"
                                        >
                                            <div
                                                :style="{
                                                    backgroundColor:
                                                        setting.value,
                                                }"
                                                class="w-6 h-6 rounded border border-gray-300"
                                            ></div>
                                            <span>{{ setting.value }}</span>
                                        </div>
                                    </span>
                                    <span
                                        v-else-if="
                                            setting.type === 'url' &&
                                            setting.value
                                        "
                                    >
                                        <a
                                            :href="setting.value"
                                            target="_blank"
                                            class="text-indigo-600 hover:text-indigo-900 truncate max-w-xs block"
                                        >
                                            {{ setting.value }}
                                        </a>
                                    </span>
                                    <span
                                        v-else-if="setting.type === 'textarea'"
                                    >
                                        <div
                                            class="max-w-xs truncate"
                                            :title="setting.value"
                                        >
                                            {{ setting.value || "-" }}
                                        </div>
                                    </span>
                                    <span v-else>
                                        {{ setting.value || "-" }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="getTypeClass(setting.type)"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                >
                                    {{ setting.type }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    {{ setting.group }}
                                </span>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <div
                                    class="flex items-center justify-end space-x-2"
                                >
                                    <Link
                                        :href="`/admin/site-settings/${setting.id}`"
                                        class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        <EyeIcon class="h-4 w-4 mr-1" />
                                        View
                                    </Link>

                                    <Link
                                        :href="`/admin/site-settings/${setting.id}/edit`"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"
                                    >
                                        <PencilIcon class="h-4 w-4 mr-1" />
                                        Edit
                                    </Link>

                                    <button
                                        @click="handleDelete(setting)"
                                        type="button"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700"
                                    >
                                        <TrashIcon class="h-4 w-4 mr-1" />
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                v-if="settings.links"
                class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6"
            >
                <div class="flex items-center justify-between">
                    <div class="flex justify-between flex-1 sm:hidden">
                        <Link
                            v-if="settings.prev_page_url"
                            :href="settings.prev_page_url"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Previous
                        </Link>
                        <Link
                            v-if="settings.next_page_url"
                            :href="settings.next_page_url"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Next
                        </Link>
                    </div>
                    <div
                        class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing {{ settings.from }} to
                                {{ settings.to }} of
                                {{ settings.total }} results
                            </p>
                        </div>
                        <div>
                            <nav
                                class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            >
                                <template
                                    v-for="link in settings.links"
                                    :key="link.label"
                                >
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        v-html="link.label"
                                        :class="[
                                            'relative inline-flex items-center px-2 py-2 border text-sm font-medium',
                                            link.active
                                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                        ]"
                                    />
                                    <span
                                        v-else
                                        v-html="link.label"
                                        :class="[
                                            'relative inline-flex items-center px-2 py-2 border text-sm font-medium',
                                            link.active
                                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                                : 'bg-white border-gray-300 text-gray-500',
                                            'cursor-not-allowed opacity-50',
                                        ]"
                                    />
                                </template>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { onMounted, ref, reactive, watch } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    CogIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
    MagnifyingGlassIcon,
    XMarkIcon,
    PencilSquareIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    settings: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({ search: "", group: "", type: "" }),
    },
    groups: {
        type: Array,
        default: () => [],
    },
    types: {
        type: Array,
        default: () => [],
    },
});

// Reactive data
const showBulkEdit = ref(false);
const bulkUpdateProcessing = ref(false);
const bulkEditForm = reactive({});

// Filter form
const filterForm = reactive({
    search: props.filters.search || "",
    group: props.filters.group || "",
    type: props.filters.type || "",
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Initialize bulk edit form
const initializeBulkEditForm = () => {
    props.settings.data.forEach((setting) => {
        if (setting.type === "boolean") {
            bulkEditForm[setting.id] =
                setting.value === "1" || setting.value === true;
        } else {
            bulkEditForm[setting.id] = setting.value || "";
        }
    });
};

// Methods
const applyFilters = () => {
    router.get(route("admin.site-settings.index"), filterForm, {
        preserveState: true,
        replace: true,
    });
};

const resetFilters = () => {
    Object.keys(filterForm).forEach((key) => {
        filterForm[key] = "";
    });
    applyFilters();
};

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

const submitBulkUpdate = () => {
    bulkUpdateProcessing.value = true;

    const settingsData = Object.keys(bulkEditForm).map((id) => ({
        id: id,
        value: bulkEditForm[id],
    }));

    router.post(
        route("admin.site-settings.bulk-update"),
        {
            settings: settingsData,
        },
        {
            onSuccess: () => {
                showBulkEdit.value = false;
                success(
                    "Berhasil!",
                    "Pengaturan berhasil diperbarui secara bulk."
                );
            },
            onError: (errors) => {
                console.log("Bulk update errors:", errors);
                error(
                    "Error!",
                    "Terjadi kesalahan saat memperbarui pengaturan."
                );
            },
            onFinish: () => {
                bulkUpdateProcessing.value = false;
            },
        }
    );
};

const handleDelete = async (setting) => {
    const result = await confirmDelete(
        "Hapus Setting?",
        `Setting "${setting.key_name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/site-settings/${setting.id}`, {
            preserveScroll: true,
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

const handleFlashMessages = () => {
    try {
        const flash = page.props.value?.flash;
        if (flash?.message) {
            success("Berhasil!", flash.message);
        }
        if (flash?.error) {
            error("Error!", flash.error);
        }
    } catch (e) {
        console.log("Flash message error:", e);
    }
};

// Watch for bulk edit mode changes
const toggleBulkEdit = () => {
    if (showBulkEdit.value) {
        initializeBulkEditForm();
    }
};

// Lifecycle
onMounted(() => {
    handleFlashMessages();
    initializeBulkEditForm();
});

// Watch showBulkEdit
watch(showBulkEdit, toggleBulkEdit);
</script>
