<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Portal Orang Tua
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola akun orang tua dan data siswa
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="route('super-admin.parents.import')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <DocumentArrowUpIcon class="w-4 h-4 mr-2" />
                            Import Data
                        </Link>
                        <Link
                            :href="route('super-admin.parents.create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PlusIcon class="w-4 h-4 mr-2" />
                            Tambah Manual
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Pencarian
                        </label>
                        <input
                            type="text"
                            v-model="searchForm.search"
                            @input="debounceSearch"
                            placeholder="Cari nama orang tua, siswa, NIM..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Hubungan
                        </label>
                        <select
                            v-model="searchForm.relation"
                            @change="handleFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">Semua Hubungan</option>
                            <option value="ayah">Ayah</option>
                            <option value="ibu">Ibu</option>
                            <option value="wali">Wali</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Status
                        </label>
                        <select
                            v-model="searchForm.is_active"
                            @change="handleFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">Semua Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button
                            @click="clearFilters"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Orang Tua & Siswa'"
            :headers="tableHeaders"
            :items="parents.data"
            :filters="filters"
            :pagination="parents"
            :route-name="'super-admin.parents.index'"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <UserGroupIcon
                            class="mx-auto h-12 w-12 text-gray-400"
                        />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada data orang tua
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan mengimpor data atau menambah manual.
                        </p>
                        <div class="mt-6 flex justify-center space-x-3">
                            <Link
                                :href="route('super-admin.parents.import')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <DocumentArrowUpIcon class="w-4 h-4 mr-2" />
                                Import Data
                            </Link>
                            <Link
                                :href="route('super-admin.parents.create')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Manual
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="parent in items"
                    :key="parent.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div
                                    class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center"
                                >
                                    <UserIcon class="h-5 w-5 text-indigo-600" />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ parent.name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ parent.email || "Tidak ada email" }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ parent.student?.name || "-" }}
                        </div>
                        <div class="text-sm text-gray-500">
                            NIM: {{ parent.student?.nim || "-" }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                parent.relation_badge,
                            ]"
                        >
                            {{ parent.relation_label }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ parent.username }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ parent.phone || "Tidak ada telepon" }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                parent.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{ parent.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{
                                formatDate(parent.last_login_at) ||
                                "Belum login"
                            }}
                        </div>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="
                                    route('super-admin.parents.show', parent.id)
                                "
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            >
                                <EyeIcon class="h-4 w-4 mr-1" />
                                Lihat
                            </Link>

                            <Link
                                :href="
                                    route('super-admin.parents.edit', parent.id)
                                "
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="resetPassword(parent)"
                                type="button"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                            >
                                <KeyIcon class="h-4 w-4 mr-1" />
                                Reset
                            </button>

                            <button
                                @click="toggleStatus(parent)"
                                type="button"
                                :class="[
                                    'inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2',
                                    parent.is_active
                                        ? 'bg-orange-600 hover:bg-orange-700 focus:ring-orange-500'
                                        : 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
                                ]"
                            >
                                <component
                                    :is="
                                        parent.is_active
                                            ? XCircleIcon
                                            : CheckCircleIcon
                                    "
                                    class="h-4 w-4 mr-1"
                                />
                                {{ parent.is_active ? "Nonaktif" : "Aktifkan" }}
                            </button>

                            <button
                                @click="handleDelete(parent)"
                                type="button"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                <TrashIcon class="h-4 w-4 mr-1" />
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import { onMounted, ref, reactive } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    DocumentArrowUpIcon,
    UserGroupIcon,
    UserIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
    KeyIcon,
    CheckCircleIcon,
    XCircleIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";
import { debounce } from "lodash";

// Props
const props = defineProps({
    parents: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({
            search: "",
            relation: "",
            is_active: "",
        }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "parent_name", label: "Orang Tua", align: "left" },
    { key: "student_name", label: "Siswa", align: "left" },
    { key: "relation", label: "Hubungan", align: "left" },
    { key: "username", label: "Username/Kontak", align: "left" },
    { key: "status", label: "Status", align: "left" },
    { key: "last_login", label: "Terakhir Login", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Reactive search form
const searchForm = reactive({
    search: props.filters.search || "",
    relation: props.filters.relation || "",
    is_active: props.filters.is_active || "",
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Debounced search
const debounceSearch = debounce(() => {
    handleFilter();
}, 500);

// Methods
const handleFilter = () => {
    const params = {};

    if (searchForm.search) params.search = searchForm.search;
    if (searchForm.relation) params.relation = searchForm.relation;
    if (searchForm.is_active !== "") params.is_active = searchForm.is_active;

    router.get(route("super-admin.parents.index"), params, {
        preserveState: true,
        replace: true,
    });
};

const clearFilters = () => {
    searchForm.search = "";
    searchForm.relation = "";
    searchForm.is_active = "";
    router.get(
        route("super-admin.parents.index"),
        {},
        {
            preserveState: true,
            replace: true,
        }
    );
};

const resetPassword = async (parent) => {
    const result = await confirmDelete(
        "Reset Password?",
        `Password untuk "${parent.name}" akan direset ke default (${parent.username}123)`
    );

    if (result.isConfirmed) {
        try {
            const response = await fetch(
                route("super-admin.parents.reset-password", parent.id),
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                }
            );

            const data = await response.json();

            if (data.success) {
                success("Berhasil!", data.message);
            } else {
                error("Error!", data.message);
            }
        } catch (e) {
            error("Error!", "Terjadi kesalahan saat reset password.");
        }
    }
};

const toggleStatus = async (parent) => {
    const action = parent.is_active ? "nonaktifkan" : "aktifkan";
    const result = await confirmDelete(
        `${action.charAt(0).toUpperCase() + action.slice(1)} Akun?`,
        `Akun "${parent.name}" akan di${action}.`
    );

    if (result.isConfirmed) {
        try {
            const response = await fetch(
                route("super-admin.parents.toggle-status", parent.id),
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                }
            );

            const data = await response.json();

            if (data.success) {
                parent.is_active = data.is_active;
                success("Berhasil!", data.message);
            } else {
                error("Error!", data.message);
            }
        } catch (e) {
            error("Error!", "Terjadi kesalahan saat mengubah status.");
        }
    }
};

const handleDelete = async (parent) => {
    const result = await confirmDelete(
        "Hapus Akun Orang Tua?",
        `Akun "${parent.name}" dan data terkait akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(route("super-admin.parents.destroy", parent.id), {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Akun orang tua berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus data.");
            },
        });
    }
};

const formatDate = (date) => {
    if (!date) return null;
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const handleFlashMessages = () => {
    try {
        const flash = page.props.value?.flash;
        if (flash?.message) {
            if (flash.type === "success") {
                success("Berhasil!", flash.message);
            } else if (flash.type === "error") {
                error("Error!", flash.message);
            }
        }
    } catch (e) {
        console.log("Flash message error:", e);
    }
};

// Lifecycle
onMounted(() => {
    handleFlashMessages();
});
</script>
