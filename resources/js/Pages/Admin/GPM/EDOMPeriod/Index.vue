<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    PencilIcon,
    TrashIcon,
    ChartBarIcon,
    EyeIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    periods: Object,
    filters: Object,
});

const { showSuccessToast, confirmDelete } = useSwal();

const columns = [
    { key: "name", label: "Nama Periode" },
    { key: "semester", label: "Semester" },
    { key: "academic_year", label: "Tahun Akademik" },
    { key: "is_active", label: "Status Aktif" },
    { key: "is_published", label: "Hasil" },
    { key: "actions", label: "Aksi" },
];

const deleteItem = async (item) => {
    const result = await confirmDelete(
        "Hapus Periode",
        `Yakin menghapus ${item.name}? Semua data terkait akan hilang.`,
    );
    if (result.isConfirmed) {
        router.delete(route("admin.gpm.edom-period.destroy", item.id), {
            onSuccess: () => showSuccessToast("Periode berhasil dihapus"),
        });
    }
};

const toggleActive = (item) => {
    router.post(
        route("admin.gpm.edom-period.toggle-active", item.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => showSuccessToast("Status periode diperbarui"),
        },
    );
};
</script>

<template>
    <Head title="Periode EDOM" />
    <AdminLayout>
        <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Periode EDOM
                    </h1>
                    <p class="text-sm text-gray-500">
                        Kelola jadwal evaluasi dosen oleh mahasiswa
                    </p>
                </div>
                <Link
                    :href="route('admin.gpm.edom-period.create')"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md flex items-center hover:bg-blue-700"
                >
                    <PlusIcon class="w-5 h-5 mr-1" /> Tambah Periode
                </Link>
            </div>

            <DataTable
                :headers="columns"
                :items="periods.data"
                :pagination="periods"
                :filters="filters"
                route-name="admin.gpm.edom-period.index"
            >
                <template #body="{ items }">
                    <tr
                        v-for="item in items"
                        :key="item.id"
                        class="hover:bg-gray-50 border-b"
                    >
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ item.name }}
                        </td>
                        <td class="px-6 py-4 capitalize">
                            {{ item.semester }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ item.academic_year }}
                        </td>
                        <td class="px-6 py-4">
                            <button
                                @click="toggleActive(item)"
                                :class="
                                    item.is_active
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800'
                                "
                                class="px-2.5 py-0.5 rounded-full text-xs font-medium"
                            >
                                {{ item.is_active ? "Aktif" : "Non-aktif" }}
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                :class="
                                    item.is_published
                                        ? 'text-blue-600'
                                        : 'text-gray-400'
                                "
                                class="text-xs font-semibold"
                            >
                                {{
                                    item.is_published ? "Dipublikasi" : "Privat"
                                }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-3">
                            <Link
                                :href="
                                    route('admin.gpm.edom-period.show', item.id)
                                "
                                class="text-gray-600 hover:text-blue-600"
                                title="Statistik"
                            >
                                <ChartBarIcon class="w-5 h-5" />
                            </Link>
                            <Link
                                :href="
                                    route('admin.gpm.edom-period.edit', item.id)
                                "
                                class="text-indigo-600 hover:text-indigo-800"
                            >
                                <PencilIcon class="w-5 h-5" />
                            </Link>
                            <button
                                @click="deleteItem(item)"
                                class="text-red-600 hover:text-red-800"
                            >
                                <TrashIcon class="w-5 h-5" />
                            </button>
                        </td>
                    </tr>
                </template>
            </DataTable>
        </div>
    </AdminLayout>
</template>
