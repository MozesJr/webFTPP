<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    programStudi: {
        type: Object,
        required: true,
    },
});

// Composables
const page = usePage();
const { success, error } = useSwal();

// State
const imageInput = ref(null);
const imagePreview = ref(null);

// Computed
const currentImageUrl = computed(() => {
    return props.programStudi?.image_url
        ? `/${props.programStudi.image_url}`
        : null;
});

// Form dengan _method untuk method spoofing
const form = useForm({
    _method: "PUT", // Method spoofing untuk Laravel
    name: props.programStudi?.name || "",
    code: props.programStudi?.code || "",
    degree_level: props.programStudi?.degree_level || "",
    description: props.programStudi?.description || "",
    overview: props.programStudi?.overview || "",
    image_url: null,
    accreditation: props.programStudi?.accreditation || "",
    accreditation_date: props.programStudi?.accreditation_date || "",
    accreditation_expire: props.programStudi?.accreditation_expire || "",
    head_of_program: props.programStudi?.head_of_program || "",
    established_year: props.programStudi?.established_year || "",
    is_active: props.programStudi?.is_active ?? true,
});

// Methods
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image_url = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    // Gunakan POST dengan method spoofing
    form.post(`/admin/program-studi/${props.programStudi.id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Program Studi berhasil diperbarui.");
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
});
</script>

<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Program Studi
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Perbarui informasi program studi:
                            {{ programStudi.name }}
                        </p>
                    </div>
                    <Link
                        href="/admin/program-studi"
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
                    Informasi Program Studi
                </h2>
            </div>

            <form
                @submit.prevent="submit"
                class="p-6"
                enctype="multipart/form-data"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Nama Program Studi
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-red-300': form.errors.name }"
                            placeholder="contoh: Teknik Informatika"
                        />
                        <div
                            v-if="form.errors.name"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <!-- Code -->
                    <div>
                        <label
                            for="code"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Kode Program Studi
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="code"
                            v-model="form.code"
                            type="text"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-red-300': form.errors.code }"
                            placeholder="contoh: TI"
                        />
                        <div
                            v-if="form.errors.code"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.code }}
                        </div>
                    </div>

                    <!-- Degree Level -->
                    <div>
                        <label
                            for="degree_level"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Jenjang <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="degree_level"
                            v-model="form.degree_level"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300': form.errors.degree_level,
                            }"
                        >
                            <option value="">Pilih Jenjang</option>
                            <option value="D3">D3 (Diploma 3)</option>
                            <option value="S1">S1 (Sarjana)</option>
                            <option value="S2">S2 (Magister)</option>
                            <option value="S3">S3 (Doktor)</option>
                        </select>
                        <div
                            v-if="form.errors.degree_level"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.degree_level }}
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300': form.errors.description,
                            }"
                            placeholder="Deskripsi singkat program studi"
                        ></textarea>
                        <div
                            v-if="form.errors.description"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <!-- Overview -->
                    <div class="md:col-span-2">
                        <label
                            for="overview"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Overview
                        </label>
                        <textarea
                            id="overview"
                            v-model="form.overview"
                            rows="6"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{ 'border-red-300': form.errors.overview }"
                            placeholder="Overview lengkap tentang program studi"
                        ></textarea>
                        <div
                            v-if="form.errors.overview"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.overview }}
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Anda dapat menggunakan HTML untuk formatting
                        </p>
                    </div>

                    <!-- Current Image & Upload -->
                    <div class="md:col-span-2">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Gambar Program Studi
                        </label>

                        <!-- Current Image -->
                        <div v-if="currentImageUrl" class="mb-3">
                            <img
                                :src="currentImageUrl"
                                alt="Current Image"
                                class="w-32 h-32 object-cover rounded-lg"
                            />
                            <p class="text-xs text-gray-500 mt-1">
                                Gambar saat ini
                            </p>
                        </div>

                        <!-- File Input -->
                        <input
                            id="image_url"
                            ref="imageInput"
                            type="file"
                            accept="image/*"
                            @change="handleImageChange"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        />
                        <div
                            v-if="form.errors.image_url"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.image_url }}
                        </div>

                        <!-- New Image Preview -->
                        <div v-if="imagePreview" class="mt-3">
                            <img
                                :src="imagePreview"
                                alt="Preview"
                                class="w-32 h-32 object-cover rounded-lg"
                            />
                            <p class="text-xs text-gray-500 mt-1">
                                Preview gambar baru
                            </p>
                        </div>

                        <p class="mt-1 text-sm text-gray-500">
                            Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika
                            tidak ingin mengganti gambar.
                        </p>
                    </div>

                    <!-- Accreditation -->
                    <div>
                        <label
                            for="accreditation"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Akreditasi
                        </label>
                        <select
                            id="accreditation"
                            v-model="form.accreditation"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300': form.errors.accreditation,
                            }"
                        >
                            <option value="">Pilih Akreditasi</option>
                            <option value="Unggul">Unggul</option>
                            <option value="Baik Sekali">Baik Sekali</option>
                            <option value="Baik">Baik</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                        <div
                            v-if="form.errors.accreditation"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.accreditation }}
                        </div>
                    </div>

                    <!-- Accreditation Date -->
                    <div>
                        <label
                            for="accreditation_date"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Tanggal Akreditasi
                        </label>
                        <input
                            id="accreditation_date"
                            v-model="form.accreditation_date"
                            type="date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.accreditation_date,
                            }"
                        />
                        <div
                            v-if="form.errors.accreditation_date"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.accreditation_date }}
                        </div>
                    </div>

                    <!-- Accreditation Expire -->
                    <div>
                        <label
                            for="accreditation_expire"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Tanggal Kadaluarsa
                        </label>
                        <input
                            id="accreditation_expire"
                            v-model="form.accreditation_expire"
                            type="date"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.accreditation_expire,
                            }"
                        />
                        <div
                            v-if="form.errors.accreditation_expire"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.accreditation_expire }}
                        </div>
                    </div>

                    <!-- Head of Program -->
                    <div>
                        <label
                            for="head_of_program"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Kepala Program Studi
                        </label>
                        <input
                            id="head_of_program"
                            v-model="form.head_of_program"
                            type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300': form.errors.head_of_program,
                            }"
                            placeholder="Nama kepala program studi"
                        />
                        <div
                            v-if="form.errors.head_of_program"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.head_of_program }}
                        </div>
                    </div>

                    <!-- Established Year -->
                    <div>
                        <label
                            for="established_year"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Tahun Berdiri
                        </label>
                        <input
                            id="established_year"
                            v-model="form.established_year"
                            type="number"
                            min="1900"
                            :max="new Date().getFullYear()"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300': form.errors.established_year,
                            }"
                            placeholder="2000"
                        />
                        <div
                            v-if="form.errors.established_year"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.established_year }}
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
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
                                Aktifkan program studi
                            </label>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Jika diaktifkan, program studi akan ditampilkan di
                            website
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end space-x-3">
                    <Link
                        href="/admin/program-studi"
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
                            Processing...
                        </span>
                        <span v-else> Update Program Studi </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
