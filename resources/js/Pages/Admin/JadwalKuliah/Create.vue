<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Jadwal Kuliah
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat jadwal perkuliahan baru
                        </p>
                    </div>
                    <Link
                        href="/admin/jadwal-kuliah"
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
                    Informasi Jadwal Kuliah
                </h2>
            </div>

            <form @submit.prevent="submit" class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Mata Kuliah -->
                        <div>
                            <label
                                for="mata_kuliah_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Mata Kuliah <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="mata_kuliah_id"
                                v-model="form.mata_kuliah_id"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.mata_kuliah_id ||
                                        errors.mata_kuliah_id,
                                }"
                                @change="validateField('mata_kuliah_id')"
                            >
                                <option value="">Pilih Mata Kuliah</option>
                                <option
                                    v-for="matkul in mataKuliahs"
                                    :key="matkul.id"
                                    :value="matkul.id"
                                >
                                    {{ matkul.code }} - {{ matkul.name }}
                                    <span class="text-gray-500"
                                        >({{
                                            matkul.kurikulum?.program_studi
                                                ?.name
                                        }}) - {{ matkul.credits }} SKS</span
                                    >
                                </option>
                            </select>
                            <div
                                v-if="
                                    form.errors.mata_kuliah_id ||
                                    errors.mata_kuliah_id
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.mata_kuliah_id ||
                                    errors.mata_kuliah_id
                                }}
                            </div>
                        </div>

                        <!-- Dosen -->
                        <div>
                            <label
                                for="dosen_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Dosen Pengampu
                                <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="dosen_id"
                                v-model="form.dosen_id"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.dosen_id || errors.dosen_id,
                                }"
                                @change="validateField('dosen_id')"
                            >
                                <option value="">Pilih Dosen</option>
                                <option
                                    v-for="dosen in dosens"
                                    :key="dosen.id"
                                    :value="dosen.id"
                                >
                                    {{ dosen.name }}
                                    <span class="text-gray-500"
                                        >- {{ dosen.email }}</span
                                    >
                                </option>
                            </select>
                            <div
                                v-if="form.errors.dosen_id || errors.dosen_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.dosen_id || errors.dosen_id }}
                            </div>
                        </div>

                        <!-- Academic Year and Semester -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Academic Year -->
                            <div>
                                <label
                                    for="academic_year"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Tahun Akademik
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="academic_year"
                                    v-model="form.academic_year"
                                    type="text"
                                    required
                                    pattern="\d{4}/\d{4}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.academic_year ||
                                            errors.academic_year,
                                    }"
                                    placeholder="2024/2025"
                                    @blur="validateField('academic_year')"
                                />
                                <div
                                    v-if="
                                        form.errors.academic_year ||
                                        errors.academic_year
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.academic_year ||
                                        errors.academic_year
                                    }}
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
                                        'border-red-300':
                                            form.errors.semester ||
                                            errors.semester,
                                    }"
                                    @change="validateField('semester')"
                                >
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                <div
                                    v-if="
                                        form.errors.semester || errors.semester
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.semester || errors.semester
                                    }}
                                </div>
                            </div>
                        </div>

                        <!-- Class Name -->
                        <div>
                            <label
                                for="class_name"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Nama Kelas <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="class_name"
                                v-model="form.class_name"
                                type="text"
                                required
                                maxlength="50"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.class_name ||
                                        errors.class_name,
                                }"
                                placeholder="contoh: A, B, 1, 2, TI-A, dll"
                                @blur="validateField('class_name')"
                            />
                            <div
                                v-if="
                                    form.errors.class_name || errors.class_name
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.class_name || errors.class_name
                                }}
                            </div>
                        </div>

                        <!-- Day and Time -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Day -->
                            <div>
                                <label
                                    for="day"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Hari <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="day"
                                    v-model="form.day"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.day || errors.day,
                                    }"
                                    @change="validateField('day')"
                                >
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                </select>
                                <div
                                    v-if="form.errors.day || errors.day"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.day || errors.day }}
                                </div>
                            </div>

                            <!-- Start Time -->
                            <div>
                                <label
                                    for="start_time"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Waktu Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="start_time"
                                    v-model="form.start_time"
                                    type="time"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.start_time ||
                                            errors.start_time,
                                    }"
                                    @blur="validateField('start_time')"
                                />
                                <div
                                    v-if="
                                        form.errors.start_time ||
                                        errors.start_time
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.start_time ||
                                        errors.start_time
                                    }}
                                </div>
                            </div>

                            <!-- End Time -->
                            <div>
                                <label
                                    for="end_time"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Waktu Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="end_time"
                                    v-model="form.end_time"
                                    type="time"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.end_time ||
                                            errors.end_time,
                                    }"
                                    @blur="validateTime"
                                />
                                <div
                                    v-if="
                                        form.errors.end_time || errors.end_time
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.end_time || errors.end_time
                                    }}
                                </div>
                            </div>
                        </div>

                        <!-- Room -->
                        <div>
                            <label
                                for="room"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Ruangan <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="room"
                                v-model="form.room"
                                type="text"
                                required
                                maxlength="50"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.room || errors.room,
                                }"
                                placeholder="contoh: Lab Komputer 1, Ruang 101, Aula, dll"
                                @blur="validateField('room')"
                            />
                            <div
                                v-if="form.errors.room || errors.room"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.room || errors.room }}
                            </div>
                        </div>

                        <!-- Capacity and Enrolled Students -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Capacity -->
                            <div>
                                <label
                                    for="capacity"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Kapasitas
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="capacity"
                                    v-model="form.capacity"
                                    type="number"
                                    required
                                    min="1"
                                    max="100"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.capacity ||
                                            errors.capacity,
                                    }"
                                    placeholder="30"
                                    @blur="validateField('capacity')"
                                />
                                <div
                                    v-if="
                                        form.errors.capacity || errors.capacity
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.capacity || errors.capacity
                                    }}
                                </div>
                            </div>

                            <!-- Enrolled Students -->
                            <div>
                                <label
                                    for="enrolled_students"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Mahasiswa Terdaftar
                                </label>
                                <input
                                    id="enrolled_students"
                                    v-model="form.enrolled_students"
                                    type="number"
                                    min="0"
                                    :max="form.capacity"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.enrolled_students ||
                                            errors.enrolled_students,
                                    }"
                                    placeholder="0"
                                />
                                <div
                                    v-if="
                                        form.errors.enrolled_students ||
                                        errors.enrolled_students
                                    "
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        form.errors.enrolled_students ||
                                        errors.enrolled_students
                                    }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Kosongkan jika belum ada yang mendaftar
                                </p>
                            </div>
                        </div>

                        <!-- Schedule Summary -->
                        <div
                            v-if="isScheduleComplete"
                            class="bg-blue-50 p-4 rounded-lg"
                        >
                            <h3 class="text-sm font-medium text-blue-900 mb-3">
                                Ringkasan Jadwal
                            </h3>
                            <div class="text-sm text-blue-800 space-y-1">
                                <div>
                                    <span class="font-medium"
                                        >Mata Kuliah:</span
                                    >
                                    {{ selectedMataKuliah?.name }}
                                </div>
                                <div>
                                    <span class="font-medium">Dosen:</span>
                                    {{ selectedDosen?.name }}
                                </div>
                                <div>
                                    <span class="font-medium">Waktu:</span>
                                    {{ form.day }} {{ form.start_time }} -
                                    {{ form.end_time }}
                                </div>
                                <div>
                                    <span class="font-medium">Ruangan:</span>
                                    {{ form.room }}
                                </div>
                                <div>
                                    <span class="font-medium">Kelas:</span>
                                    {{ form.class_name }}
                                </div>
                                <div>
                                    <span class="font-medium">Kapasitas:</span>
                                    {{ form.enrolled_students || 0 }}/{{
                                        form.capacity
                                    }}
                                    mahasiswa
                                </div>
                            </div>
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
                                    Aktifkan jadwal
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Jadwal aktif akan ditampilkan kepada mahasiswa
                            </p>
                        </div>

                        <!-- Time Guidelines -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-green-900 mb-2">
                                Panduan Waktu
                            </h3>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• Kuliah: 07:30 - 17:00</li>
                                <li>• Istirahat siang: 12:00 - 13:00</li>
                                <li>• Durasi standar: 100 menit (2 SKS)</li>
                                <li>• Durasi standar: 150 menit (3 SKS)</li>
                            </ul>
                        </div>

                        <!-- Conflict Warning -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3
                                class="text-sm font-medium text-yellow-900 mb-2"
                            >
                                Perhatian
                            </h3>
                            <ul class="text-sm text-yellow-700 space-y-1">
                                <li>• Sistem akan mengecek konflik ruangan</li>
                                <li>• Sistem akan mengecek konflik dosen</li>
                                <li>
                                    • Waktu selesai harus setelah waktu mulai
                                </li>
                                <li>• Kapasitas harus sesuai dengan ruangan</li>
                            </ul>
                        </div>

                        <!-- Duration Calculation -->
                        <div
                            v-if="scheduleDuration"
                            class="bg-purple-50 p-4 rounded-lg"
                        >
                            <h3
                                class="text-sm font-medium text-purple-900 mb-2"
                            >
                                Durasi Kuliah
                            </h3>
                            <div class="text-sm text-purple-800">
                                <div>
                                    <span class="font-medium">Durasi:</span>
                                    {{ scheduleDuration }} menit
                                </div>
                                <div>
                                    <span class="font-medium"
                                        >SKS mata kuliah:</span
                                    >
                                    {{ selectedMataKuliah?.credits || 0 }} SKS
                                </div>
                                <div
                                    v-if="selectedMataKuliah?.credits"
                                    class="mt-1"
                                >
                                    <span
                                        class="text-xs"
                                        :class="
                                            isDurationAppropriate
                                                ? 'text-green-600'
                                                : 'text-red-600'
                                        "
                                    >
                                        {{
                                            isDurationAppropriate
                                                ? "✓ Durasi sesuai"
                                                : "⚠ Durasi tidak sesuai standar"
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-3 border-t pt-6">
                    <Link
                        href="/admin/jadwal-kuliah"
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
                        <span v-else> Simpan Jadwal </span>
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

// Props
const props = defineProps({
    mataKuliahs: {
        type: Array,
        default: () => [],
    },
    dosens: {
        type: Array,
        default: () => [],
    },
});

// Composables
const page = usePage();
const { success, error } = useSwal();

// Custom validation errors
const errors = reactive({
    mata_kuliah_id: "",
    dosen_id: "",
    academic_year: "",
    semester: "",
    class_name: "",
    day: "",
    start_time: "",
    end_time: "",
    room: "",
    capacity: "",
});

// Form
const form = useForm({
    mata_kuliah_id: "",
    dosen_id: "",
    academic_year: "",
    semester: "",
    class_name: "",
    day: "",
    start_time: "",
    end_time: "",
    room: "",
    capacity: "",
    enrolled_students: "",
    is_active: true,
});

// Computed
const isFormValid = computed(() => {
    return (
        form.mata_kuliah_id !== "" &&
        form.dosen_id !== "" &&
        form.academic_year.trim() !== "" &&
        form.semester !== "" &&
        form.class_name.trim() !== "" &&
        form.day !== "" &&
        form.start_time !== "" &&
        form.end_time !== "" &&
        form.room.trim() !== "" &&
        form.capacity !== "" &&
        !Object.values(errors).some((error) => error !== "")
    );
});

const selectedMataKuliah = computed(() => {
    return props.mataKuliahs.find(
        (matkul) => matkul.id.toString() === form.mata_kuliah_id.toString()
    );
});

const selectedDosen = computed(() => {
    return props.dosens.find(
        (dosen) => dosen.id.toString() === form.dosen_id.toString()
    );
});

const isScheduleComplete = computed(() => {
    return (
        selectedMataKuliah.value &&
        selectedDosen.value &&
        form.day &&
        form.start_time &&
        form.end_time &&
        form.room &&
        form.class_name
    );
});

const scheduleDuration = computed(() => {
    if (!form.start_time || !form.end_time) return null;

    const start = new Date(`2000-01-01 ${form.start_time}`);
    const end = new Date(`2000-01-01 ${form.end_time}`);

    if (end <= start) return null;

    return Math.round((end - start) / (1000 * 60)); // duration in minutes
});

const isDurationAppropriate = computed(() => {
    if (!scheduleDuration.value || !selectedMataKuliah.value?.credits)
        return true;

    const credits = selectedMataKuliah.value.credits;
    const duration = scheduleDuration.value;

    // Standard: 1 SKS = 50 minutes
    const expectedDuration = credits * 50;
    const tolerance = 20; // 20 minutes tolerance

    return Math.abs(duration - expectedDuration) <= tolerance;
});

// Methods
const validateField = (field) => {
    errors[field] = "";

    switch (field) {
        case "mata_kuliah_id":
            if (!form.mata_kuliah_id) {
                errors.mata_kuliah_id = "Mata kuliah wajib dipilih";
            }
            break;

        case "dosen_id":
            if (!form.dosen_id) {
                errors.dosen_id = "Dosen wajib dipilih";
            }
            break;

        case "academic_year":
            if (!form.academic_year.trim()) {
                errors.academic_year = "Tahun akademik wajib diisi";
            } else if (!/^\d{4}\/\d{4}$/.test(form.academic_year)) {
                errors.academic_year = "Format tahun akademik harus YYYY/YYYY";
            }
            break;

        case "semester":
            if (!form.semester) {
                errors.semester = "Semester wajib dipilih";
            }
            break;

        case "class_name":
            if (!form.class_name.trim()) {
                errors.class_name = "Nama kelas wajib diisi";
            }
            break;

        case "day":
            if (!form.day) {
                errors.day = "Hari wajib dipilih";
            }
            break;

        case "start_time":
            if (!form.start_time) {
                errors.start_time = "Waktu mulai wajib diisi";
            }
            break;

        case "room":
            if (!form.room.trim()) {
                errors.room = "Ruangan wajib diisi";
            }
            break;

        case "capacity":
            if (!form.capacity) {
                errors.capacity = "Kapasitas wajib diisi";
            } else if (form.capacity < 1 || form.capacity > 100) {
                errors.capacity = "Kapasitas harus antara 1-100";
            }
            break;
    }
};

const validateTime = () => {
    errors.end_time = "";

    if (!form.end_time) {
        errors.end_time = "Waktu selesai wajib diisi";
        return;
    }

    if (form.start_time && form.end_time) {
        const start = new Date(`2000-01-01 ${form.start_time}`);
        const end = new Date(`2000-01-01 ${form.end_time}`);

        if (end <= start) {
            errors.end_time = "Waktu selesai harus setelah waktu mulai";
        }
    }
};

const submit = () => {
    // Validate all required fields
    validateField("mata_kuliah_id");
    validateField("dosen_id");
    validateField("academic_year");
    validateField("semester");
    validateField("class_name");
    validateField("day");
    validateField("start_time");
    validateField("room");
    validateField("capacity");
    validateTime();

    if (Object.values(errors).some((error) => error !== "")) {
        error("Validasi Error!", "Mohon perbaiki data yang belum valid.");
        return;
    }

    form.post("/admin/jadwal-kuliah", {
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Jadwal kuliah berhasil ditambahkan.");
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
