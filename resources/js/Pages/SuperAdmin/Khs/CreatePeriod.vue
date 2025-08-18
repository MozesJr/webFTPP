<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('super-admin.khs.periods')"
                        class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-1" />
                        Kembali ke Kelola Period
                    </Link>
                </div>
                <div class="mt-4">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Tambah Period Akademik
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Buat period akademik baru untuk sistem KHS
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="max-w-2xl">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Informasi Period
                    </h2>
                </div>
                <form @submit.prevent="submit" class="px-6 py-4 space-y-6">
                    <!-- Tahun -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">
                            Tahun <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="year"
                            type="number"
                            v-model="form.year"
                            :min="2020"
                            :max="2030"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            :class="{ 'border-red-500': errors.year }"
                            required
                        />
                        <p v-if="errors.year" class="mt-1 text-sm text-red-600">
                            {{ errors.year }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Tahun akademik (contoh: 2024 untuk tahun 2024/2025)
                        </p>
                    </div>

                    <!-- Semester -->
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">
                            Semester <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="semester"
                            v-model="form.semester"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            :class="{ 'border-red-500': errors.semester }"
                            required
                        >
                            <option value="">Pilih Semester</option>
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                        <p v-if="errors.semester" class="mt-1 text-sm text-red-600">
                            {{ errors.semester }}
                        </p>
                    </div>

                    <!-- Preview Academic Year -->
                    <div v-if="form.year && form.semester" class="p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <div class="flex items-center">
                            <InformationCircleIcon class="h-5 w-5 text-blue-600 mr-2" />
                            <div>
                                <p class="text-sm font-medium text-blue-800">
                                    Tahun Akademik: {{ academicYear }}
                                </p>
                                <p class="text-sm text-blue-600">
                                    Nama Period: {{ previewName }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Custom (Opsional) -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Custom (Opsional)
                        </label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            :placeholder="previewName"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            :class="{ 'border-red-500': errors.name }"
                        />
                        <p v-if="errors.name" class="mt-1 text-sm text-red-600">
                            {{ errors.name }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Kosongkan untuk menggunakan nama default
                        </p>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Mulai (Opsional)
                        </label>
                        <input
                            id="start_date"
                            type="date"
                            v-model="form.start_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            :class="{ 'border-red-500': errors.start_date }"
                        />
                        <p v-if="errors.start_date" class="mt-1 text-sm text-red-600">
                            {{ errors.start_date }}
                        </p>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Selesai (Opsional)
                        </label>
                        <input
                            id="end_date"
                            type="date"
                            v-model="form.end_date"
                            :min="form.start_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            :class="{ 'border-red-500': errors.end_date }"
                        />
                        <p v-if="errors.end_date" class="mt-1 text-sm text-red-600">
                            {{ errors.end_date }}
                        </p>
                    </div>

                    <!-- Status Aktif -->
                    <div class="flex items-center">
                        <input
                            id="is_active"
                            type="checkbox"
                            v-model="form.is_active"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        />
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Aktifkan period ini setelah dibuat
                        </label>
                    </div>
                    <p v-if="form.is_active" class="mt-1 text-sm text-yellow-600">
                        <ExclamationTriangleIcon class="h-4 w-4 inline mr-1" />
                        Period lain akan dinonaktifkan secara otomatis
                    </p>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <Link
                            :href="route('super-admin.khs.periods')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="processing || !form.year || !form.semester"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:bg-gray-400 disabled:cursor-not-allowed"
                        >
                            <span v-if="processing" class="mr-2">
                                <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                            {{ processing ? 'Menyimpan...' : 'Simpan Period' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed, reactive, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    InformationCircleIcon,
    ExclamationTriangleIcon,
} from "@heroicons/vue/24/outline";

// Form data
const form = reactive({
    year: new Date().getFullYear(),
    semester: "",
    name: "",
    start_date: "",
    end_date: "",
    is_active: false,
});

const processing = ref(false);
const errors = ref({});

// Computed
const academicYear = computed(() => {
    if (!form.year || !form.semester) return "";

    if (form.semester === "ganjil") {
        return `${form.year}/${form.year + 1}`;
    } else {
        return `${form.year - 1}/${form.year}`;
    }
});

const previewName = computed(() => {
    if (!form.year || !form.semester) return "";

    const semesterLabel = form.semester === "ganjil" ? "Ganjil" : "Genap";
    return `Semester ${semesterLabel} ${academicYear.value}`;
});

// Methods
const submit = () => {
    processing.value = true;
    errors.value = {};

    router.post(route("super-admin.khs.periods.store"), form, {
        onSuccess: () => {
            // Will be redirected to periods index with flash message
        },
        onError: (responseErrors) => {
            errors.value = responseErrors;
        },
        onFinish: () => {
            processing.value = false;
        },
    });
};
