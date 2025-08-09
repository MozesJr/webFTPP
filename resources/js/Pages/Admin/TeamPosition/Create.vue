<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Posisi Tim
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Tambah posisi jabatan baru dalam tim
                        </p>
                    </div>
                    <Link
                        href="/admin/team-position"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="p-6">
                <div class="max-w-3xl mx-auto space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Informasi Posisi
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Nama Posisi *
                                </label>
                                <input
                                    type="text"
                                    v-model="form.name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    :class="{ 'border-red-300': errors.name }"
                                    placeholder="Contoh: Dekan, Wakil Dekan, Kepala Program Studi"
                                    required
                                />
                                <div
                                    v-if="errors.name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ errors.name }}
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Level *
                                </label>
                                <select
                                    v-model="form.level"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    :class="{ 'border-red-300': errors.level }"
                                    required
                                >
                                    <option value="">Pilih Level</option>
                                    <option
                                        v-for="level in levelOptions"
                                        :key="level.value"
                                        :value="level.value"
                                    >
                                        Level {{ level.value }} -
                                        {{ level.label }}
                                    </option>
                                </select>
                                <div
                                    v-if="errors.level"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ errors.level }}
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    Level menentukan hierarki dalam organisasi.
                                    Level 1 = tertinggi (Dekan), Level 10 =
                                    terendah.
                                </p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Deskripsi
                                </label>
                                <textarea
                                    v-model="form.description"
                                    rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    :class="{
                                        'border-red-300': errors.description,
                                    }"
                                    placeholder="Jelaskan tugas dan tanggung jawab posisi ini..."
                                ></textarea>
                                <div
                                    v-if="errors.description"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ errors.description }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level Guide -->
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h4 class="text-lg font-medium text-blue-900 mb-3">
                            Panduan Level Posisi
                        </h4>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm"
                        >
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 1:</span
                                    >
                                    <span class="text-blue-700">Dekan</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 2:</span
                                    >
                                    <span class="text-blue-700"
                                        >Wakil Dekan</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 3:</span
                                    >
                                    <span class="text-blue-700"
                                        >Kepala Program Studi</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 4:</span
                                    >
                                    <span class="text-blue-700"
                                        >Sekretaris Program Studi</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 5:</span
                                    >
                                    <span class="text-blue-700"
                                        >Kepala Laboratorium</span
                                    >
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 6:</span
                                    >
                                    <span class="text-blue-700"
                                        >Dosen Senior</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 7:</span
                                    >
                                    <span class="text-blue-700">Dosen</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 8:</span
                                    >
                                    <span class="text-blue-700"
                                        >Asisten Dosen</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 9:</span
                                    >
                                    <span class="text-blue-700"
                                        >Staff Administrasi</span
                                    >
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium text-blue-800"
                                        >Level 10:</span
                                    >
                                    <span class="text-blue-700"
                                        >Staff Pendukung</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <Link
                            href="/admin/team-position"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="processing"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            :class="{
                                'opacity-50 cursor-not-allowed': processing,
                            }"
                        >
                            <svg
                                v-if="processing"
                                class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            {{ processing ? "Menyimpan..." : "Simpan" }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    errors: {
        type: Object,
        default: () => ({}),
    },
});

// Level options
const levelOptions = ref([
    { value: 1, label: "Tertinggi (Dekan)" },
    { value: 2, label: "Wakil Dekan" },
    { value: 3, label: "Kepala Program Studi" },
    { value: 4, label: "Sekretaris Program Studi" },
    { value: 5, label: "Kepala Laboratorium" },
    { value: 6, label: "Dosen Senior" },
    { value: 7, label: "Dosen" },
    { value: 8, label: "Asisten Dosen" },
    { value: 9, label: "Staff Administrasi" },
    { value: 10, label: "Staff Pendukung" },
]);

// Form
const form = useForm({
    name: "",
    level: "",
    description: "",
});

// Methods
const submit = () => {
    form.post("/admin/team-position", {
        preserveScroll: true,
    });
};
</script>
