<script setup>
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { useSwal } from "@/Composables/useSwal";

const props = defineProps({
    strukturOrganisasi: Object, // Laravel pagination object
    filters: Object,
});

const { success, error, confirmDelete } = useSwal();
const page = usePage();

// Additional filters (status & jabatan)
const statusFilter = ref(props.filters?.status || "");
const jabatanFilter = ref(props.filters?.jabatan || "");

// Table headers - sesuai format DataTable component
const headers = [
    { key: "photo", label: "Foto", align: "left" },
    { key: "nama", label: "Nama", align: "left" },
    { key: "nip", label: "NIP", align: "left" },
    { key: "jabatan", label: "Jabatan", align: "left" },
    { key: "email", label: "Email", align: "left" },
    { key: "order", label: "Urutan", align: "center" },
    { key: "is_active", label: "Status", align: "center" },
    { key: "actions", label: "Aksi", align: "center" },
];

// Apply additional filters
const applyFilters = () => {
    router.get(
        route("admin.gpm.struktur-organisasi.index"),
        {
            search: props.filters?.search || "",
            status: statusFilter.value,
            jabatan: jabatanFilter.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

// Reset all filters
const resetFilters = () => {
    statusFilter.value = "";
    jabatanFilter.value = "";
    router.get(
        route("admin.gpm.struktur-organisasi.index"),
        {},
        {
            preserveState: true,
        },
    );
};

// Delete member
const deleteMember = async (member) => {
    const confirmed = await confirmDelete(
        "Hapus Anggota GPM",
        `Yakin ingin menghapus ${member.nama}?`,
    );

    if (confirmed) {
        router.delete(
            route("admin.gpm.struktur-organisasi.destroy", member.id),
            {
                // Ganti showSuccess jadi success
                onSuccess: () => {
                    const status = member.is_active
                        ? "dinonaktifkan"
                        : "diaktifkan";
                    success("Berhasil!", `Anggota berhasil ${status}.`);
                },
                onError: () => {
                    showError(
                        "Gagal!",
                        "Terjadi kesalahan saat menghapus data.",
                    );
                },
            },
        );
    }
};

// Toggle active status
const toggleActive = (member) => {
    router.post(
        route("admin.gpm.struktur-organisasi.toggle-active", member.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                const status = member.is_active
                    ? "dinonaktifkan"
                    : "diaktifkan";
                showSuccess("Berhasil!", `Anggota berhasil ${status}.`);
            },
        },
    );
};

// Ganti showSuccess jadi success
if (page.props.flash?.success) {
    success("Berhasil!", page.props.flash.success);
}
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="md:flex md:items-center md:justify-between mb-6">
                    <div class="flex-1 min-w-0">
                        <h2
                            class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"
                        >
                            Struktur Organisasi GPM
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Kelola data personil Gugus Penjaminan Mutu FTPP
                        </p>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <a
                            :href="
                                route('admin.gpm.struktur-organisasi.create')
                            "
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <svg
                                class="-ml-1 mr-2 h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Tambah Anggota
                        </a>
                    </div>
                </div>

                <!-- Additional Filters -->
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Status</label
                            >
                            <select
                                v-model="statusFilter"
                                @change="applyFilters"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                                <option value="">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Jabatan</label
                            >
                            <input
                                v-model="jabatanFilter"
                                type="text"
                                placeholder="Filter jabatan..."
                                @keyup.enter="applyFilters"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            />
                        </div>
                        <div class="flex items-end gap-2">
                            <button
                                @click="applyFilters"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700"
                            >
                                Terapkan Filter
                            </button>
                            <button
                                @click="resetFilters"
                                class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200"
                            >
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- DataTable -->
                <DataTable
                    title="Daftar Anggota GPM"
                    :headers="headers"
                    :items="strukturOrganisasi.data"
                    :filters="filters"
                    :pagination="strukturOrganisasi"
                    routeName="admin.gpm.struktur-organisasi.index"
                >
                    <template #body="{ items }">
                        <tr
                            v-for="member in items"
                            :key="member.id"
                            class="hover:bg-gray-50"
                        >
                            <!-- Photo -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img
                                    :src="
                                        member.photo_url ||
                                        '/images/default-avatar.png'
                                    "
                                    :alt="member.nama"
                                    class="h-12 w-12 rounded-full object-cover"
                                />
                            </td>

                            <!-- Nama -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ member.nama }}
                                </div>
                                <div
                                    v-if="member.is_featured"
                                    class="text-xs text-blue-600 font-semibold"
                                >
                                    ⭐ Featured
                                </div>
                            </td>

                            <!-- NIP -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ member.nip || "-" }}
                                </div>
                            </td>

                            <!-- Jabatan -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                >
                                    {{ member.jabatan }}
                                </span>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ member.email || "-" }}
                                </div>
                            </td>

                            <!-- Order -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-900">
                                    {{ member.order }}
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button
                                    @click="toggleActive(member)"
                                    class="inline-flex items-center"
                                >
                                    <span
                                        :class="[
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            member.is_active
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800',
                                        ]"
                                    >
                                        {{
                                            member.is_active
                                                ? "Aktif"
                                                : "Tidak Aktif"
                                        }}
                                    </span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td
                                class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium"
                            >
                                <div
                                    class="flex items-center justify-center gap-2"
                                >
                                    <a
                                        :href="
                                            route(
                                                'admin.gpm.struktur-organisasi.edit',
                                                member.id,
                                            )
                                        "
                                        class="text-blue-600 hover:text-blue-900"
                                        title="Edit"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                            />
                                        </svg>
                                    </a>
                                    <button
                                        @click="deleteMember(member)"
                                        class="text-red-600 hover:text-red-900"
                                        title="Hapus"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </DataTable>
            </div>
        </div>
    </AdminLayout>
</template>
