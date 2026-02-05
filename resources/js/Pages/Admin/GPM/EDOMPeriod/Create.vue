<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const form = useForm({
    name: "",
    semester: "",
    academic_year: "",
    start_date: "",
    end_date: "",
    description: "",
    is_active: false,
});

// Generate academic year options
const currentYear = new Date().getFullYear();
const academicYears = ref([]);
for (let i = -1; i <= 2; i++) {
    const startYear = currentYear + i;
    const endYear = startYear + 1;
    academicYears.value.push(`${startYear}/${endYear}`);
}

// Auto-generate name
const autoGenerateName = () => {
    if (form.semester && form.academic_year) {
        const semesterLabel = form.semester === "ganjil" ? "Ganjil" : "Genap";
        form.name = `EDOM ${semesterLabel} ${form.academic_year}`;
    }
};

const submit = () => {
    form.post(route("admin.gpm.edom-period.store"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <a
                        :href="route('admin.gpm.edom-period.index')"
                        class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4"
                    >
                        <svg
                            class="w-4 h-4 mr-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Kembali
                    </a>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Buat Periode EDOM Baru
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Buat periode baru untuk Evaluasi Dosen Oleh Mahasiswa
                    </p>
                </div>

                <!-- Form -->
                <form
                    @submit.prevent="submit"
                    class="bg-white shadow rounded-lg p-6"
                >
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Semester -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Semester <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.semester"
                                    @change="autoGenerateName"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{
                                        'border-red-500': form.errors.semester,
                                    }"
                                >
                                    <option value="">Pilih Semester</option>
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                                <p
                                    v-if="form.errors.semester"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.semester }}
                                </p>
                            </div>

                            <!-- Academic Year -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tahun Ajaran
                                    <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.academic_year"
                                    @change="autoGenerateName"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{
                                        'border-red-500':
                                            form.errors.academic_year,
                                    }"
                                >
                                    <option value="">Pilih Tahun Ajaran</option>
                                    <option
                                        v-for="year in academicYears"
                                        :key="year"
                                        :value="year"
                                    >
                                        {{ year }}
                                    </option>
                                </select>
                                <p
                                    v-if="form.errors.academic_year"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.academic_year }}
                                </p>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Nama Periode <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="EDOM Ganjil 2024/2025"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :class="{ 'border-red-500': form.errors.name }"
                            />
                            <p
                                v-if="form.errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                Nama akan dibuat otomatis saat memilih semester
                                dan tahun ajaran
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Start Date -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="form.start_date"
                                    type="date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{
                                        'border-red-500':
                                            form.errors.start_date,
                                    }"
                                />
                                <p
                                    v-if="form.errors.start_date"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.start_date }}
                                </p>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="form.end_date"
                                    type="date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{
                                        'border-red-500': form.errors.end_date,
                                    }"
                                />
                                <p
                                    v-if="form.errors.end_date"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.end_date }}
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Deskripsi</label
                            >
                            <textarea
                                v-model="form.description"
                                rows="4"
                                placeholder="Deskripsi periode EDOM..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            ></textarea>
                        </div>

                        <!-- Is Active -->
                        <div>
                            <label class="flex items-center">
                                <input
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                />
                                <span class="ml-2 text-sm text-gray-700"
                                    >Aktifkan periode</span
                                >
                            </label>
                            <p class="mt-1 text-xs text-gray-500">
                                Periode yang aktif dapat diakses oleh mahasiswa
                                untuk mengisi evaluasi
                            </p>
                        </div>

                        <!-- Info Box -->
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
                                        Informasi
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul
                                            class="list-disc list-inside space-y-1"
                                        >
                                            <li>
                                                Periode EDOM digunakan untuk
                                                mengumpulkan evaluasi mahasiswa
                                                terhadap dosen
                                            </li>
                                            <li>
                                                Hanya satu periode yang dapat
                                                aktif dalam satu waktu
                                            </li>
                                            <li>
                                                Setelah periode selesai, hasil
                                                dapat dipublish untuk dilihat
                                                dosen
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex items-center justify-end gap-3">
                        <a
                            :href="route('admin.gpm.edom-period.index')"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Batal
                        </a>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                        >
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Buat Periode</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
