<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Program Studi
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat program studi baru untuk fakultas
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

            <form @submit.prevent="submit" class="p-6">
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
                            maxlength="255"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.name || errors.name,
                            }"
                            placeholder="contoh: Teknik Informatika"
                            @blur="validateField('name')"
                        />
                        <div
                            v-if="form.errors.name || errors.name"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.name || errors.name }}
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
                            maxlength="10"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.code || errors.code,
                            }"
                            placeholder="contoh: TI"
                            @blur="validateField('code')"
                        />
                        <div
                            v-if="form.errors.code || errors.code"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.code || errors.code }}
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
                                'border-red-300':
                                    form.errors.degree_level ||
                                    errors.degree_level,
                            }"
                            @change="validateField('degree_level')"
                        >
                            <option value="">Pilih Jenjang</option>
                            <option value="D3">D3 (Diploma 3)</option>
                            <option value="S1">S1 (Sarjana)</option>
                            <option value="S2">S2 (Magister)</option>
                            <option value="S3">S3 (Doktor)</option>
                        </select>
                        <div
                            v-if="
                                form.errors.degree_level || errors.degree_level
                            "
                            class="mt-1 text-sm text-red-600"
                        >
                            {{
                                form.errors.degree_level || errors.degree_level
                            }}
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
                            maxlength="1000"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.description ||
                                    errors.description,
                            }"
                            placeholder="Deskripsi singkat program studi"
                            @blur="validateField('description')"
                        ></textarea>
                        <div
                            v-if="form.errors.description || errors.description"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.description || errors.description }}
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ form.description.length }}/1000 karakter
                        </p>
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
                            maxlength="5000"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.overview || errors.overview,
                            }"
                            placeholder="Overview lengkap tentang program studi"
                        ></textarea>
                        <div
                            v-if="form.errors.overview || errors.overview"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.overview || errors.overview }}
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ form.overview.length }}/5000 karakter. Anda dapat
                            menggunakan HTML untuk formatting
                        </p>
                    </div>

                    <!-- Image Upload -->
                    <div class="md:col-span-2">
                        <label
                            for="image_url"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Gambar Program Studi
                        </label>
                        <input
                            id="image_url"
                            ref="imageInput"
                            type="file"
                            accept="image/jpeg,image/png,image/jpg,image/gif"
                            @change="handleImageChange"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        />
                        <div
                            v-if="form.errors.image_url || errors.image_url"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.image_url || errors.image_url }}
                        </div>

                        <!-- Image Preview -->
                        <div v-if="imagePreview" class="mt-3">
                            <img
                                :src="imagePreview"
                                alt="Preview"
                                class="w-32 h-32 object-cover rounded-lg"
                            />
                            <p class="text-xs text-gray-500 mt-1">
                                Preview gambar
                            </p>
                            <button
                                type="button"
                                @click="removeImage"
                                class="mt-1 text-xs text-red-600 hover:text-red-800"
                            >
                                Hapus gambar
                            </button>
                        </div>

                        <p class="mt-1 text-sm text-gray-500">
                            Format: JPG, PNG, GIF. Maksimal 2MB
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
                                'border-red-300':
                                    form.errors.accreditation ||
                                    errors.accreditation,
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
                            v-if="
                                form.errors.accreditation ||
                                errors.accreditation
                            "
                            class="mt-1 text-sm text-red-600"
                        >
                            {{
                                form.errors.accreditation ||
                                errors.accreditation
                            }}
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
                                    form.errors.accreditation_date ||
                                    errors.accreditation_date,
                            }"
                            @change="validateAccreditationDates"
                        />
                        <div
                            v-if="
                                form.errors.accreditation_date ||
                                errors.accreditation_date
                            "
                            class="mt-1 text-sm text-red-600"
                        >
                            {{
                                form.errors.accreditation_date ||
                                errors.accreditation_date
                            }}
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
                                    form.errors.accreditation_expire ||
                                    errors.accreditation_expire,
                            }"
                            @change="validateAccreditationDates"
                        />
                        <div
                            v-if="
                                form.errors.accreditation_expire ||
                                errors.accreditation_expire
                            "
                            class="mt-1 text-sm text-red-600"
                        >
                            {{
                                form.errors.accreditation_expire ||
                                errors.accreditation_expire
                            }}
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
                            maxlength="255"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.head_of_program ||
                                    errors.head_of_program,
                            }"
                            placeholder="Nama kepala program studi"
                        />
                        <div
                            v-if="
                                form.errors.head_of_program ||
                                errors.head_of_program
                            "
                            class="mt-1 text-sm text-red-600"
                        >
                            {{
                                form.errors.head_of_program ||
                                errors.head_of_program
                            }}
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
                            :max="currentYear"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.established_year ||
                                    errors.established_year,
                            }"
                            placeholder="2000"
                            @blur="validateField('established_year')"
                        />
                        <div
                            v-if="
                                form.errors.established_year ||
                                errors.established_year
                            "
                            class="mt-1 text-sm text-red-600"
                        >
                            {{
                                form.errors.established_year ||
                                errors.established_year
                            }}
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
                        :disabled="form.processing || !isFormValid"
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
                        <span v-else> Simpan Program Studi </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted, reactive } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Composables
const page = usePage();
const { success, error } = useSwal();

// State
const imageInput = ref(null);
const imagePreview = ref(null);
const currentYear = new Date().getFullYear();

// Custom validation errors
const errors = reactive({
    name: "",
    code: "",
    degree_level: "",
    description: "",
    overview: "",
    image_url: "",
    accreditation_date: "",
    accreditation_expire: "",
    head_of_program: "",
    established_year: "",
});

// Form
const form = useForm({
    name: "",
    code: "",
    degree_level: "",
    description: "",
    overview: "",
    image_url: null,
    accreditation: "",
    accreditation_date: "",
    accreditation_expire: "",
    head_of_program: "",
    established_year: "",
    is_active: true,
});

// Computed
const isFormValid = computed(() => {
    return (
        form.name.trim() !== "" &&
        form.code.trim() !== "" &&
        form.degree_level !== "" &&
        form.description.trim() !== "" &&
        !Object.values(errors).some((error) => error !== "")
    );
});

// Methods
const validateField = (field) => {
    // Clear previous error
    errors[field] = "";

    switch (field) {
        case "name":
            if (!form.name.trim()) {
                errors.name = "Nama program studi wajib diisi";
            } else if (form.name.length < 3) {
                errors.name = "Nama program studi minimal 3 karakter";
            } else if (form.name.length > 255) {
                errors.name = "Nama program studi maksimal 255 karakter";
            }
            break;

        case "code":
            if (!form.code.trim()) {
                errors.code = "Kode program studi wajib diisi";
            } else if (form.code.length < 2) {
                errors.code = "Kode program studi minimal 2 karakter";
            } else if (form.code.length > 10) {
                errors.code = "Kode program studi maksimal 10 karakter";
            } else if (!/^[A-Z0-9]+$/.test(form.code)) {
                errors.code = "Kode harus berupa huruf kapital dan angka";
            }
            break;

        case "degree_level":
            if (!form.degree_level) {
                errors.degree_level = "Jenjang wajib dipilih";
            }
            break;

        case "description":
            if (!form.description.trim()) {
                errors.description = "Deskripsi wajib diisi";
            } else if (form.description.length < 10) {
                errors.description = "Deskripsi minimal 10 karakter";
            } else if (form.description.length > 1000) {
                errors.description = "Deskripsi maksimal 1000 karakter";
            }
            break;

        case "established_year":
            if (form.established_year) {
                const year = parseInt(form.established_year);
                if (year < 1900 || year > currentYear) {
                    errors.established_year = `Tahun harus antara 1900 dan ${currentYear}`;
                }
            }
            break;
    }
};

const validateAccreditationDates = () => {
    errors.accreditation_date = "";
    errors.accreditation_expire = "";

    if (form.accreditation_date && form.accreditation_expire) {
        const startDate = new Date(form.accreditation_date);
        const endDate = new Date(form.accreditation_expire);

        if (endDate <= startDate) {
            errors.accreditation_expire =
                "Tanggal kadaluarsa harus setelah tanggal akreditasi";
        }
    }
};

const validateImage = (file) => {
    errors.image_url = "";

    if (!file) return true;

    // Check file type
    const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
    if (!allowedTypes.includes(file.type)) {
        errors.image_url = "Format gambar harus JPG, PNG, atau GIF";
        return false;
    }

    // Check file size (2MB)
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    if (file.size > maxSize) {
        errors.image_url = "Ukuran gambar maksimal 2MB";
        return false;
    }

    return true;
};

const handleImageChange = (event) => {
    const file = event.target.files[0];

    if (file) {
        if (!validateImage(file)) {
            // Reset input if validation fails
            event.target.value = "";
            imagePreview.value = null;
            form.image_url = null;
            return;
        }

        form.image_url = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    imagePreview.value = null;
    form.image_url = null;
    if (imageInput.value) {
        imageInput.value.value = "";
    }
};

const submit = () => {
    // Validate all required fields before submit
    validateField("name");
    validateField("code");
    validateField("degree_level");
    validateField("description");
    validateField("established_year");
    validateAccreditationDates();

    // Check if there are any validation errors
    if (Object.values(errors).some((error) => error !== "")) {
        error("Validasi Error!", "Mohon perbaiki data yang belum valid.");
        return;
    }

    form.post("/admin/program-studi", {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Program Studi berhasil ditambahkan.");
        },
        onError: (formErrors) => {
            console.log("Form errors:", formErrors);
            error("Error!", "Terjadi kesalahan saat menyimpan data.");
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
