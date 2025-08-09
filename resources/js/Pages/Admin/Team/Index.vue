<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Tim</h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola anggota tim fakultas
                        </p>
                    </div>
                    <Link
                        href="/admin/team/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Anggota Tim
                    </Link>
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
                            placeholder="Cari nama, email, atau posisi..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Posisi
                        </label>
                        <select
                            v-model="searchForm.position_id"
                            @change="handleFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">Semua Posisi</option>
                            <option
                                v-for="position in positions"
                                :key="position.id"
                                :value="position.id"
                            >
                                {{ position.name }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Program Studi
                        </label>
                        <select
                            v-model="searchForm.prodi_id"
                            @change="handleFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">Semua Program Studi</option>
                            <option
                                v-for="prodi in programStudis"
                                :key="prodi.id"
                                :value="prodi.id"
                            >
                                {{ prodi.name }}
                            </option>
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
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Anggota Tim'"
            :headers="tableHeaders"
            :items="teams.data"
            :filters="filters"
            :pagination="teams"
            :route-name="'admin.team.index'"
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
                            Belum ada anggota tim
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan anggota tim pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/team/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Anggota Tim
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="team in items"
                    :key="team.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <img
                                    v-if="team.photo_url"
                                    :src="team.photo_url"
                                    :alt="team.name"
                                    class="h-12 w-12 rounded-full object-cover"
                                />
                                <div
                                    v-else
                                    class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center"
                                >
                                    <UserIcon class="h-6 w-6 text-gray-400" />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ team.name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ team.email || "-" }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                        >
                            {{ team.position?.name || "-" }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ team.program_studi?.name || "-" }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ team.phone || "-" }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            :class="[
                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                team.is_active
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{ team.is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ team.order_index || "-" }}
                        </div>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/team/${team.id}`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            >
                                <EyeIcon class="h-4 w-4 mr-1" />
                                Lihat
                            </Link>

                            <Link
                                :href="`/admin/team/${team.id}/edit`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(team)"
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
    UserGroupIcon,
    UserIcon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";
import { debounce } from "lodash";

// Props
const props = defineProps({
    teams: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    filters: {
        type: Object,
        default: () => ({
            search: "",
            position_id: "",
            prodi_id: "",
            is_active: "",
        }),
    },
    positions: {
        type: Array,
        default: () => [],
    },
    programStudis: {
        type: Array,
        default: () => [],
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "name", label: "Nama", align: "left" },
    { key: "position", label: "Posisi", align: "left" },
    { key: "program_studi", label: "Program Studi", align: "left" },
    { key: "phone", label: "Telepon", align: "left" },
    { key: "is_active", label: "Status", align: "left" },
    { key: "order_index", label: "Urutan", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Reactive search form
const searchForm = reactive({
    search: props.filters.search || "",
    position_id: props.filters.position_id || "",
    prodi_id: props.filters.prodi_id || "",
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
    if (searchForm.position_id) params.position_id = searchForm.position_id;
    if (searchForm.prodi_id) params.prodi_id = searchForm.prodi_id;
    if (searchForm.is_active !== "") params.is_active = searchForm.is_active;

    router.get(route("admin.team.index"), params, {
        preserveState: true,
        replace: true,
    });
};

const handleDelete = async (team) => {
    const result = await confirmDelete(
        "Hapus Anggota Tim?",
        `Anggota tim "${team.name}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/team/${team.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Anggota tim berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus data.");
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

// Lifecycle
onMounted(() => {
    handleFlashMessages();
});
</script>
