<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Mata Kuliah
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Perbarui mata kuliah: {{ mataKuliah.name }}
                        </p>
                    </div>
                    <Link
                        href="/admin/mata-kuliah"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">
                    Informasi Mata Kuliah
                </h2>
            </div>

            <form @submit.prevent="submit" class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Kurikulum -->
                        <div>
                            <label
                                for="kurikulum_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Kurikulum <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="kurikulum_id"
                                v-model="form.kurikulum_id"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.kurikulum_id,
                                }"
                            >
                                <option value="">Pilih Kurikulum</option>
                                <option
                                    v-for="kurikulum in kurikulums"
                                    :key="kurikulum.id"
                                    :value="kurikulum.id"
                                >
                                    {{ kurikulum.name }} ({{
                                        kurikulum.program_studi?.name
                                    }})
                                </option>
                            </select>
                            <div
                                v-if="form.errors.kurikulum_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.kurikulum_id }}
                            </div>
                        </div>

                        <!-- Code and Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Code -->
                            <div>
                                <label
                                    for="code"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Kode Mata Kuliah
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="code"
                                    v-model="form.code"
                                    type="text"
                                    required
                                    maxlength="10"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300': form.errors.code,
                                    }"
                                    placeholder="contoh: TIF101"
                                />
                                <div
                                    v-if="form.errors.code"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.code }}
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <label
                                    for="name"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Nama Mata Kuliah
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                                    maxlength="255"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300': form.errors.name,
                                    }"
                                    placeholder="contoh: Pemrograman Dasar"
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>
                        </div>

                        <!-- Credits, Semester, Category -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Credits -->
                            <div>
                                <label
                                    for="credits"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    SKS <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="credits"
                                    v-model="form.credits"
                                    type="number"
                                    required
                                    min="1"
                                    max="6"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300': form.errors.credits,
                                    }"
                                />
                                <div
                                    v-if="form.errors.credits"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.credits }}
                                </div>
                            </div>

                            <!-- Semester -->
                            <div>
                                <label
                                    for="semester"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Semester <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="semester"
                                    v-model="form.semester"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300': form.errors.semester,
                                    }"
                                >
                                    <option value="">Pilih Semester</option>
                                    <option v-for="i in 8" :key="i" :value="i">
                                        Semester {{ i }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.semester"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.semester }}
                                </div>
                            </div>

                            <!-- Category -->
                            <div>
                                <label
                                    for="category"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="category"
                                    v-model="form.category"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300': form.errors.category,
                                    }"
                                >
                                    <option value="">Pilih Kategori</option>
                                    <option value="Wajib">Wajib</option>
                                    <option value="Pilihan">Pilihan</option>
                                    <option value="MKWU">MKWU</option>
                                    <option value="MKK">MKK</option>
                                    <option value="MPB">MPB</option>
                                    <option value="MKB">MKB</option>
                                    <option value="MPK">MPK</option>
                                </select>
                                <div
                                    v-if="form.errors.category"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.category }}
                                </div>
                            </div>
                        </div>

                        <!-- Prerequisite -->
                        <div>
                            <label
                                for="prerequisite"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Mata Kuliah Prasyarat
                            </label>
                            <div class="mt-1">
                                <Multiselect
                                    v-model="selectedPrerequisites"
                                    :options="availableCourses"
                                    :searchable="true"
                                    :multiple="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preserve-search="true"
                                    placeholder="Pilih mata kuliah prasyarat"
                                    label="name"
                                    track-by="code"
                                    :custom-label="customLabel"
                                    class="multiselect-custom"
                                />
                            </div>
                            <div
                                v-if="form.errors.prerequisite"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.prerequisite }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Pilih mata kuliah yang harus diselesaikan
                                terlebih dahulu
                            </p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label
                                for="description"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Deskripsi
                            </label>
                            <textarea
                                id="description"
                                v-model="form.description"
                                rows="4"
                                maxlength="1000"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300': form.errors.description,
                                }"
                                placeholder="Deskripsi mata kuliah"
                            ></textarea>
                            <div
                                v-if="form.errors.description"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.description }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.description.length }}/1000 karakter
                            </p>
                        </div>

                        <!-- Learning Outcomes -->
                        <div>
                            <label
                                for="learning_outcomes"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Capaian Pembelajaran
                            </label>
                            <textarea
                                id="learning_outcomes"
                                v-model="form.learning_outcomes"
                                rows="6"
                                maxlength="2000"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.learning_outcomes,
                                }"
                                placeholder="Capaian pembelajaran mata kuliah"
                            ></textarea>
                            <div
                                v-if="form.errors.learning_outcomes"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.learning_outcomes }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.learning_outcomes.length }}/2000
                                karakter
                            </p>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Status -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">
                                Status
                            </h3>
                            <div class="flex items-center">
                                <input
                                    id="is_active"
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label
                                    for="is_active"
                                    class="ml-2 block text-sm text-gray-900"
                                >
                                    Aktifkan mata kuliah
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Mata kuliah aktif akan tersedia untuk
                                dijadwalkan
                            </p>
                        </div>

                        <!-- Info -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-900 mb-2">
                                Informasi
                            </h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>
                                    • Kode harus unik dan menggunakan huruf
                                    kapital
                                </li>
                                <li>• SKS berkisar antara 1-6</li>
                                <li>• Semester sesuai dengan kurikulum</li>
                                <li>• Prerequisite bersifat opsional</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-3 border-t pt-6">
                    <Link
                        href="/admin/mata-kuliah"
                        class="inline-flex justify-center items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                    >
                        <span v-if="form.processing">
                            <svg
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
                            Menyimpan...
                        </span>
                        <span v-else> Update Mata Kuliah </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";
import Multiselect from "@vueform/multiselect";

// Props
const props = defineProps({
    mataKuliah: {
        type: Object,
        required: true,
    },
    kurikulums: {
        type: Array,
        default: () => [],
    },
    availableCourses: {
        type: Array,
        default: () => [],
    },
});

// Composables
const page = usePage();
const { success, error } = useSwal();

// State
const selectedPrerequisites = ref([]);

// Form dengan _method untuk method spoofing
const form = useForm({
    _method: "PUT",
    kurikulum_id: props.mataKuliah?.kurikulum_id || "",
    code: props.mataKuliah?.code || "",
    name: props.mataKuliah?.name || "",
    credits: props.mataKuliah?.credits || "",
    semester: props.mataKuliah?.semester || "",
    category: props.mataKuliah?.category || "",
    prerequisite: props.mataKuliah?.prerequisite || [],
    description: props.mataKuliah?.description || "",
    learning_outcomes: props.mataKuliah?.learning_outcomes || "",
    is_active: props.mataKuliah?.is_active ?? true,
});

// Methods
const customLabel = ({ code, name }) => `${code} - ${name}`;

const initializePrerequisites = () => {
    if (
        props.mataKuliah?.prerequisite &&
        Array.isArray(props.mataKuliah.prerequisite)
    ) {
        selectedPrerequisites.value = props.availableCourses.filter((course) =>
            props.mataKuliah.prerequisite.includes(course.code)
        );
    }
};

// Watch for changes in selectedPrerequisites
watch(
    selectedPrerequisites,
    (newVal) => {
        form.prerequisite = newVal.map((course) => course.code);
    },
    { deep: true }
);

const submit = () => {
    // Convert prerequisite objects to array of codes
    const prerequisiteCodes = selectedPrerequisites.value.map(
        (course) => course.code
    );

    form.prerequisite = prerequisiteCodes;

    // Gunakan POST dengan method spoofing
    form.post(`/admin/mata-kuliah/${props.mataKuliah.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Mata kuliah berhasil diperbarui.");
        },
        onError: (errors) => {
            console.log("Update errors:", errors);
            error("Error!", "Terjadi kesalahan saat memperbarui data.");
        },
    });
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
    initializePrerequisites();
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
<style>
.multiselect-custom {
    --ms-border-color: rgb(209 213 219);
    --ms-border-width: 1px;
    --ms-radius: 0.375rem;
    --ms-py: 0.5rem;
    --ms-px: 0.75rem;
}
</style>
