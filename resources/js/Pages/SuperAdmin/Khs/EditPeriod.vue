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
                        Edit Period Akademik
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Edit informasi period: {{ period.name }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="max-w-2xl">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Edit Informasi Period
                    </h2>
                </div>
                <form @submit.prevent="submit" class="px-6 py-4 space-y-6">
                    <!-- Current Info Display -->
                    <div
                        class="p-4 bg-gray-50 border border-gray-200 rounded-md"
                    >
                        <h3 class="text-sm font-medium text-gray-700 mb-2">
                            Informasi Saat Ini:
                        </h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Tahun:</span>
                                <span class="ml-2 font-medium">{{
                                    period.year
                                }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Semester:</span>
                                <span class="ml-2 font-medium capitalize">{{
                                    period.semester
                                }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500"
                                    >Tahun Akademik:</span
                                >
                                <span class="ml-2 font-medium">{{
                                    period.academic_year
                                }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <span
                                    :class="[
                                        'ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium',
                                        period.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-gray-100 text-gray-800',
                                    ]"
                                >
                                    {{
                                        period.is_active
                                            ? "Aktif"
                                            : "Tidak Aktif"
                                    }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Period -->
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Nama Period <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            :class="{ 'border-red-500': errors.name }"
                            required
                        />
                        <p v-if="errors.name" class="mt-1 text-sm text-red-600">
                            {{ errors.name }}
                        </p>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label
                            for="start_date"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Tanggal Mulai
                        </label>
                        <input
                            id="start_date"
                            type="date"
                            v-model="form.start_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            :class="{ 'border-red-500': errors.start_date }"
                        />
                        <p
                            v-if="errors.start_date"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.start_date }}
                        </p>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label
                            for="end_date"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Tanggal Selesai
                        </label>
                        <input
                            id="end_date"
                            type="date"
                            v-model="form.end_date"
                            :min="form.start_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            :class="{ 'border-red-500': errors.end_date }"
                        />
                        <p
                            v-if="errors.end_date"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.end_date }}
                        </p>
                    </div>

                    <!-- Status Aktif -->
                    <div>
                        <div class="flex items-center">
                            <input
                                id="is_active"
                                type="checkbox"
                                v-model="form.is_active"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            />
                            <label
                                for="is_active"
                                class="ml-2 block text-sm text-gray-900"
                            >
                                Period ini aktif
                            </label>
                        </div>
                        <p
                            v-if="form.is_active && !period.is_active"
                            class="mt-1 text-sm text-yellow-600"
                        >
                            <ExclamationTriangleIcon
                                class="h-4 w-4 inline mr-1"
                            />
                            Period lain akan dinonaktifkan secara otomatis
                        </p>
                    </div>

                    <!-- Warning if has KHS files -->
                    <div
                        v-if="period.khs_files_count > 0"
                        class="p-4 bg-yellow-50 border border-yellow-200 rounded-md"
                    >
                        <div class="flex">
                            <ExclamationTriangleIcon
                                class="h-5 w-5 text-yellow-400"
                            />
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Perhatian
                                </h3>
                                <p class="mt-2 text-sm text-yellow-700">
                                    Period ini memiliki
                                    {{ period.khs_files_count }} file KHS.
                                    Perubahan pada period dapat mempengaruhi
                                    akses file KHS yang sudah ada.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div
                        class="flex justify-end space-x-3 pt-6 border-t border-gray-200"
                    >
                        <Link
                            :href="route('super-admin.khs.periods')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="processing"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:bg-gray-400 disabled:cursor-not-allowed"
                        >
                            <span v-if="processing" class="mr-2">
                                <svg
                                    class="animate-spin h-4 w-4"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                        fill="none"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                            </span>
                            {{ processing ? "Menyimpan..." : "Update Period" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    ExclamationTriangleIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    period: {
        type: Object,
        required: true,
    },
});

// Form data
const form = reactive({
    name: "",
    start_date: "",
    end_date: "",
    is_active: false,
});

const processing = ref(false);
const errors = ref({});

// Methods
const formatDateForInput = (date) => {
    if (!date) return "";
    return new Date(date).toISOString().split("T")[0];
};

const submit = () => {
    processing.value = true;
    errors.value = {};

    router.put(route("super-admin.khs.periods.update", props.period.id), form, {
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

// Initialize form with period data
onMounted(() => {
    form.name = props.period.name || "";
    form.start_date = formatDateForInput(props.period.start_date);
    form.end_date = formatDateForInput(props.period.end_date);
    form.is_active = props.period.is_active || false;
});
</script>
