<template>
    <AdminLayout>
        <div class="space-y-6">
            <!-- Page Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">
                        Program Studi
                    </h1>
                    <p class="text-gray-600">Kelola program studi fakultas</p>
                </div>
                <Link
                    href="/admin/program-studi/create"
                    class="btn btn-primary"
                >
                    <PlusIcon class="w-4 h-4 mr-2" />
                    Tambah Program Studi
                </Link>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <Input
                        v-model="filters.search"
                        placeholder="Cari program studi..."
                        @input="applyFilters"
                    />
                    <Select
                        v-model="filters.degree_level"
                        placeholder="Semua Jenjang"
                        :options="degreeOptions"
                        @change="applyFilters"
                    />
                    <div class="flex space-x-2">
                        <Button
                            @click="resetFilters"
                            variant="secondary"
                            class="flex-1"
                        >
                            Reset
                        </Button>
                        <Button @click="applyFilters" class="flex-1">
                            Filter
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <DataTable
                title="Daftar Program Studi"
                :data="programStudis.data"
                :columns="columns"
                :pagination="programStudis"
                :actions="true"
            >
                <template #cell-image_url="{ value }">
                    <img
                        :src="value"
                        alt="Program Image"
                        class="w-12 h-12 object-cover rounded"
                    />
                </template>

                <template #cell-degree_level="{ value }">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                    >
                        {{ value }}
                    </span>
                </template>

                <template #cell-is_active="{ value }">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                        :class="
                            value
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-800'
                        "
                    >
                        {{ value ? "Aktif" : "Tidak Aktif" }}
                    </span>
                </template>

                <template #actions="{ item }">
                    <div class="flex space-x-2">
                        <Link
                            :href="`/admin/program-studi/${item.id}`"
                            class="text-blue-600 hover:text-blue-800"
                        >
                            Lihat
                        </Link>
                        <Link
                            :href="`/admin/program-studi/${item.id}/edit`"
                            class="text-green-600 hover:text-green-800"
                        >
                            Edit
                        </Link>
                        <button
                            @click="deleteItem(item)"
                            class="text-red-600 hover:text-red-800"
                        >
                            Hapus
                        </button>
                    </div>
                </template>
            </DataTable>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/Components/UI/DataTable.vue";
import Input from "@/Components/UI/Input.vue";
import Select from "@/Components/UI/Select.vue";
import Button from "@/Components/UI/Button.vue";
import { PlusIcon } from "@heroicons/vue/24/outline";

defineProps({
    programStudis: Object,
    filters: Object,
});

const filters = reactive({
    search: "",
    degree_level: "",
});

const columns = [
    { key: "image_url", label: "Gambar" },
    { key: "name", label: "Nama" },
    { key: "code", label: "Kode" },
    { key: "degree_level", label: "Jenjang" },
    { key: "accreditation", label: "Akreditasi" },
    { key: "is_active", label: "Status" },
];

const degreeOptions = [
    { value: "D3", label: "D3" },
    { value: "S1", label: "S1" },
    { value: "S2", label: "S2" },
    { value: "S3", label: "S3" },
];

function applyFilters() {
    router.get("/admin/program-studi", filters, {
        preserveState: true,
        preserveScroll: true,
    });
}

function resetFilters() {
    filters.search = "";
    filters.degree_level = "";
    applyFilters();
}

function deleteItem(item) {
    if (confirm(`Apakah Anda yakin ingin menghapus "${item.name}"?`)) {
        router.delete(`/admin/program-studi/${item.id}`);
    }
}
</script>
