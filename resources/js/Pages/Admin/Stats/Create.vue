<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Data Statistik
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Tambahkan data statistik untuk tahun tertentu
                        </p>
                    </div>
                    <Link
                        href="/admin/stats"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form @submit.prevent="submit">
                <div class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Year -->
                        <div>
                            <label
                                for="year"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="year"
                                v-model="form.year"
                                type="number"
                                :min="1900"
                                :max="new Date().getFullYear() + 10"
                                :placeholder="`Contoh: ${suggestedYear}`"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{ 'border-red-500': form.errors.year }"
                            />
                            <p class="mt-1 text-xs text-gray-500">
                                Tahun data statistik (disarankan:
                                {{ suggestedYear }})
                            </p>
                            <div
                                v-if="form.errors.year"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.year }}
                            </div>
                        </div>

                        <!-- Is Current -->
                        <div class="flex items-center mt-8">
                            <input
                                id="is_current"
                                v-model="form.is_current"
                                type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <label
                                for="is_current"
                                class="ml-2 text-sm text-gray-700"
                            >
                                Set sebagai data terkini
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Total Students -->
                        <div>
                            <label
                                for="total_students"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Total Mahasiswa
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <UsersIcon
                                    class="absolute left-3 top-3 h-5 w-5 text-gray-400"
                                />
                                <input
                                    id="total_students"
                                    v-model="form.total_students"
                                    type="number"
                                    min="0"
                                    placeholder="Contoh: 2547"
                                    class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{
                                        'border-red-500':
                                            form.errors.total_students,
                                    }"
                                />
                            </div>
                            <div
                                v-if="form.errors.total_students"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.total_students }}
                            </div>
                        </div>

                        <!-- Total Partnerships -->
                        <div>
                            <label
                                for="total_partnerships"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Total Kemitraan
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <BuildingOfficeIcon
                                    class="absolute left-3 top-3 h-5 w-5 text-gray-400"
                                />
                                <input
                                    id="total_partnerships"
                                    v-model="form.total_partnerships"
                                    type="number"
                                    min="0"
                                    placeholder="Contoh: 85"
                                    class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{
                                        'border-red-500':
                                            form.errors.total_partnerships,
                                    }"
                                />
                            </div>
                            <div
                                v-if="form.errors.total_partnerships"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.total_partnerships }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Total Alumni -->
                        <div>
                            <label
                                for="total_alumni"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Total Alumni <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <AcademicCapIcon
                                    class="absolute left-3 top-3 h-5 w-5 text-gray-400"
                                />
                                <input
                                    id="total_alumni"
                                    v-model="form.total_alumni"
                                    type="number"
                                    min="0"
                                    placeholder="Contoh: 12350"
                                    class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{
                                        'border-red-500':
                                            form.errors.total_alumni,
                                    }"
                                />
                            </div>
                            <div
                                v-if="form.errors.total_alumni"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.total_alumni }}
                            </div>
                        </div>

                        <!-- Total Lecturers -->
                        <div>
                            <label
                                for="total_lecturers"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Total Dosen <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <UserGroupIcon
                                    class="absolute left-3 top-3 h-5 w-5 text-gray-400"
                                />
                                <input
                                    id="total_lecturers"
                                    v-model="form.total_lecturers"
                                    type="number"
                                    min="0"
                                    placeholder="Contoh: 65"
                                    class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    :class="{
                                        'border-red-500':
                                            form.errors.total_lecturers,
                                    }"
                                />
                            </div>
                            <div
                                v-if="form.errors.total_lecturers"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.total_lecturers }}
                            </div>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div
                        v-if="hasAnyValue"
                        class="bg-gray-50 rounded-lg p-6 border border-gray-200"
                    >
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Preview Data
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ formatNumber(form.total_students) }}
                                </p>
                                <p class="text-sm text-gray-600">Mahasiswa</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-green-600">
                                    {{ formatNumber(form.total_partnerships) }}
                                </p>
                                <p class="text-sm text-gray-600">Kemitraan</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-purple-600">
                                    {{ formatNumber(form.total_alumni) }}
                                </p>
                                <p class="text-sm text-gray-600">Alumni</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-orange-600">
                                    {{ formatNumber(form.total_lecturers) }}
                                </p>
                                <p class="text-sm text-gray-600">Dosen</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3"
                >
                    <Link
                        href="/admin/stats"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                    >
                        <span v-if="form.processing">
                            <svg
                                class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                            Menyimpan...
                        </span>
                        <span v-else>
                            <PlusIcon class="w-4 h-4 mr-2" />
                            Simpan Data
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    PlusIcon,
    UsersIcon,
    BuildingOfficeIcon,
    AcademicCapIcon,
    UserGroupIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    suggestedYear: {
        type: Number,
        default: () => new Date().getFullYear(),
    },
});

// Form
const form = useForm({
    total_students: "",
    total_partnerships: "",
    total_alumni: "",
    total_lecturers: "",
    year: props.suggestedYear,
    is_current: false,
});

// Computed
const hasAnyValue = computed(() => {
    return (
        form.total_students ||
        form.total_partnerships ||
        form.total_alumni ||
        form.total_lecturers
    );
});

// Methods
const formatNumber = (number) => {
    if (!number || number === "") return "0";
    return new Intl.NumberFormat("id-ID").format(parseInt(number));
};

// Submit form
const submit = () => {
    form.post(route("admin.stats.store"), {
        onSuccess: () => {
            // Handle success (redirect will be handled by controller)
        },
        onError: (errors) => {
            console.log("Form errors:", errors);
        },
    });
};
</script>
