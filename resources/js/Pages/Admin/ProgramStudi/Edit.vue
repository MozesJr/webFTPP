<!-- resources/js/Pages/Admin/ProgramStudi/Edit.vue -->
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
    _method: "PUT",
    name: props.programStudi?.name || "",
    code: props.programStudi?.code || "",
    degree_level: props.programStudi?.degree_level || "",
    description: props.programStudi?.description || "",
    overview: props.programStudi?.overview || "",
    vision: props.programStudi?.vision || "", // ✅ TAMBAHKAN
    mission: props.programStudi?.mission || "", // ✅ TAMBAHKAN
    questionnaire_link: props.programStudi?.questionnaire_link || "", // ✅ TAMBAHKAN
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
                            maxlength="1000"
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
                            {{ form.overview.length }}/5000 karakter. Anda dapat
                            menggunakan HTML untuk formatting
                        </p>
                    </div>

                    <!-- ✅ SECTION DIVIDER - VMTS -->
                    <div class="md:col-span-2">
                        <div class="border-t border-gray-200 pt-6 mt-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-1">
                                Visi, Misi & Kuesioner VMTS
                            </h3>
                            <p class="text-sm text-gray-500">
                                Informasi visi, misi, dan link kuesioner
                                pemahaman VMTS untuk mahasiswa/dosen
                            </p>
                        </div>
                    </div>

                    <!-- ✅ Vision -->
                    <div class="md:col-span-2">
                        <label
                            for="vision"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Visi Program Studi
                        </label>
                        <textarea
                            id="vision"
                            v-model="form.vision"
                            rows="4"
                            maxlength="2000"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300': form.errors.vision,
                            }"
                            placeholder="Tuliskan visi program studi..."
                        ></textarea>
                        <div
                            v-if="form.errors.vision"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.vision }}
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ form.vision.length }}/2000 karakter
                        </p>
                    </div>

                    <!-- ✅ Mission -->
                    <div class="md:col-span-2">
                        <label
                            for="mission"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Misi Program Studi
                        </label>
                        <textarea
                            id="mission"
                            v-model="form.mission"
                            rows="8"
                            maxlength="5000"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300': form.errors.mission,
                            }"
                            placeholder="Tuliskan misi program studi (pisahkan dengan enter untuk multiple points)..."
                        ></textarea>
                        <div
                            v-if="form.errors.mission"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.mission }}
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ form.mission.length }}/5000 karakter. Gunakan
                            enter untuk memisahkan setiap poin misi.
                        </p>
                    </div>

                    <!-- ✅ Questionnaire Link -->
                    <div class="md:col-span-2">
                        <label
                            for="questionnaire_link"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Link Kuesioner Pemahaman VMTS
                        </label>
                        <input
                            id="questionnaire_link"
                            v-model="form.questionnaire_link"
                            type="url"
                            maxlength="500"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            :class="{
                                'border-red-300':
                                    form.errors.questionnaire_link,
                            }"
                            placeholder="https://forms.google.com/..."
                        />
                        <div
                            v-if="form.errors.questionnaire_link"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.questionnaire_link }}
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Link ke kuesioner pemahaman Visi, Misi, Tujuan &
                            Strategi (VMTS). Mahasiswa/dosen dapat mengakses
                            kuesioner melalui link ini.
                        </p>
                    </div>

                    <!-- ✅ Info Box untuk VMTS -->
                    <div class="md:col-span-2">
                        <div
                            class="bg-blue-50 border border-blue-200 rounded-lg p-4"
                        >
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-5 w-5 text-blue-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3
                                        class="text-sm font-medium text-blue-900"
                                    >
                                        Tentang Visi, Misi & Kuesioner VMTS
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul
                                            class="list-disc list-inside space-y-1"
                                        >
                                            <li>
                                                Visi dan Misi akan ditampilkan
                                                di halaman detail program studi
                                            </li>
                                            <li>
                                                Link kuesioner VMTS akan muncul
                                                sebagai tombol untuk
                                                mahasiswa/dosen mengisi survey
                                                pemahaman
                                            </li>
                                            <li>
                                                Pastikan link kuesioner sudah
                                                aktif dan dapat diakses publik
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ SECTION DIVIDER - Media & Info Lainnya -->
                    <div class="md:col-span-2">
                        <div class="border-t border-gray-200 pt-6 mt-2">
                            <h3 class="text-lg font-medium text-gray-900">
                                Media & Informasi Lainnya
                            </h3>
                        </div>
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
                            maxlength="255"
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
                            Memproses...
                        </span>
                        <span v-else> Update Program Studi </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
