<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Role</h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola role dan hak akses sistem
                        </p>
                    </div>
                    <Link
                        :href="route('super-admin.roles.create')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Role
                    </Link>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            placeholder="Cari nama role..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        />
                    </div>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Role'"
            :headers="tableHeaders"
            :items="roles.data"
            :filters="filters"
            :pagination="roles"
            :route-name="'super-admin.roles.index'"
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
                            Belum ada role
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan role pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                :href="route('super-admin.roles.create')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Role
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="role in items"
                    :key="role.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ role.name }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ role.users_count || 0 }} pengguna
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ formatDate(role.created_at) }}
                        </div>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="route('super-admin.roles.show', role.id)"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            >
                                <EyeIcon class="h-4 w-4 mr-1" />
                                Lihat
                            </Link>

                            <Link
                                :href="route('super-admin.roles.edit', role.id)"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(role)"
                                type="button"
                                :disabled="role.name === 'super_admin'"
                                :class="[
                                    'inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2',
                                    role.name === 'super_admin'
                                        ? 'bg-gray-400 cursor-not-allowed'
                                        : 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
                                ]"
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
    UserGroupIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";
import { debounce } from "lodash";

// Props
const props = defineProps({
    roles: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({
            search: "",
        }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "name", label: "Nama Role", align: "left" },
    { key: "users_count", label: "Jumlah Pengguna", align: "left" },
    { key: "created_at", label: "Tanggal Dibuat", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Reactive search form
const searchForm = reactive({
    search: props.filters.search || "",
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

    router.get(route("super-admin.roles.index"), params, {
        preserveState: true,
        replace: true,
    });
};

const handleDelete = async (role) => {
    if (role.name === "super_admin") {
        error("Error!", "Role Super Admin tidak dapat dihapus.");
        return;
    }

    const result = await confirmDelete(
        "Hapus Role?",
        `Role "${role.name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(route("super-admin.roles.destroy", role.id), {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Role berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus data.");
            },
        });
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
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
