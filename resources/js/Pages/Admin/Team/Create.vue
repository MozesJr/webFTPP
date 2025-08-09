<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Anggota Tim
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Tambah anggota tim baru ke dalam sistem
                        </p>
                    </div>
                    <Link
                        href="/admin/team"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>

            <form @submit.prevent="submit" class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi Dasar
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Nama Lengkap *
                                    </label>
                                    <input
                                        type="text"
                                        v-model="form.name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        :class="{
                                            'border-red-300': errors.name,
                                        }"
                                        placeholder="Masukkan nama lengkap"
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
                                        Posisi *
                                    </label>
                                    <select
                                        v-model="form.position_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        :class="{
                                            'border-red-300':
                                                errors.position_id,
                                        }"
                                        required
                                    >
                                        <option value="">Pilih Posisi</option>
                                        <option
                                            v-for="position in positions"
                                            :key="position.id"
                                            :value="position.id"
                                        >
                                            {{ position.name }} (Level
                                            {{ position.level }})
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.position_id"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ errors.position_id }}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Program Studi
                                    </label>
                                    <select
                                        v-model="form.prodi_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        :class="{
                                            'border-red-300': errors.prodi_id,
                                        }"
                                    >
                                        <option value="">
                                            Pilih Program Studi
                                        </option>
                                        <option
                                            v-for="prodi in programStudis"
                                            :key="prodi.id"
                                            :value="prodi.id"
                                        >
                                            {{ prodi.name }}
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.prodi_id"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ errors.prodi_id }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi Kontak
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        v-model="form.email"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        :class="{
                                            'border-red-300': errors.email,
                                        }"
                                        placeholder="email@example.com"
                                    />
                                    <div
                                        v-if="errors.email"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ errors.email }}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Nomor Telepon
                                    </label>
                                    <input
                                        type="text"
                                        v-model="form.phone"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        :class="{
                                            'border-red-300': errors.phone,
                                        }"
                                        placeholder="08xxxxxxxxxx"
                                    />
                                    <div
                                        v-if="errors.phone"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ errors.phone }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Photo Upload -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Foto Profil
                            </h3>

                            <div class="flex flex-col items-center">
                                <div
                                    class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mb-4 overflow-hidden"
                                >
                                    <img
                                        v-if="photoPreview"
                                        :src="photoPreview"
                                        alt="Preview"
                                        class="w-full h-full object-cover"
                                    />
                                    <UserIcon
                                        v-else
                                        class="w-16 h-16 text-gray-400"
                                    />
                                </div>

                                <input
                                    type="file"
                                    ref="photoInput"
                                    @change="handlePhotoChange"
                                    accept="image/*"
                                    class="hidden"
                                />

                                <button
                                    type="button"
                                    @click="$refs.photoInput.click()"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <CameraIcon class="w-4 h-4 mr-2" />
                                    {{
                                        photoPreview
                                            ? "Ganti Foto"
                                            : "Pilih Foto"
                                    }}
                                </button>

                                <p class="text-xs text-gray-500 mt-2">
                                    Format: JPG, PNG. Maksimal 2MB
                                </p>
                            </div>

                            <div
                                v-if="errors.photo"
                                class="mt-2 text-sm text-red-600"
                            >
                                {{ errors.photo }}
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi Tambahan
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Pendidikan
                                    </label>
                                    <textarea
                                        v-model="form.education"
                                        rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        :class="{
                                            'border-red-300': errors.education,
                                        }"
                                        placeholder="Contoh: S1 Teknik Informatika - Universitas ABC (2010), S2 Sistem Informasi - Universitas XYZ (2015)"
                                    ></textarea>
                                    <div
                                        v-if="errors.education"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ errors.education }}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Keahlian
                                    </label>
                                    <textarea
                                        v-model="form.expertise"
                                        rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        :class="{
                                            'border-red-300': errors.expertise,
                                        }"
                                        placeholder="Contoh: Web Development, Machine Learning, Data Analysis"
                                    ></textarea>
                                    <div
                                        v-if="errors.expertise"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ errors.expertise }}
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Urutan Tampil
                                    </label>
                                    <input
                                        type="number"
                                        v-model="form.order_index"
                                        min="0"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        :class="{
                                            'border-red-300':
                                                errors.order_index,
                                        }"
                                        placeholder="Kosongkan untuk otomatis"
                                    />
                                    <div
                                        v-if="errors.order_index"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ errors.order_index }}
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Semakin kecil angka, semakin awal tampil
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biography -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Biografi
                    </h3>

                    <textarea
                        v-model="form.bio"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        :class="{ 'border-red-300': errors.bio }"
                        placeholder="Tuliskan biografi singkat..."
                    ></textarea>
                    <div v-if="errors.bio" class="mt-1 text-sm text-red-600">
                        {{ errors.bio }}
                    </div>
                </div>

                <!-- Status -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Status
                    </h3>

                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="is_active"
                            v-model="form.is_active"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        />
                        <label
                            for="is_active"
                            class="ml-2 text-sm text-gray-700"
                        >
                            Aktif (akan ditampilkan di website)
                        </label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <Link
                        href="/admin/team"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        :disabled="processing"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        :class="{ 'opacity-50 cursor-not-allowed': processing }"
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
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ArrowLeftIcon, UserIcon, CameraIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    positions: {
        type: Array,
        default: () => [],
    },
    programStudis: {
        type: Array,
        default: () => [],
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
});

// Form
const form = useForm({
    name: "",
    position_id: "",
    prodi_id: "",
    email: "",
    phone: "",
    bio: "",
    photo: null,
    education: "",
    expertise: "",
    is_active: true,
    order_index: null,
});

// Photo preview
const photoPreview = ref(null);

// Methods
const handlePhotoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.photo = file;

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post("/admin/team", {
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>
