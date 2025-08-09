<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah RPS
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat Rencana Pembelajaran Semester baru
                        </p>
                    </div>
                    <Link
                        href="/admin/rps"
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
                <h2 class="text-lg font-medium text-gray-900">Informasi RPS</h2>
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

                        <!-- Learning Objectives -->
                        <div>
                            <label
                                for="learning_objectives"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Tujuan Pembelajaran
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="learning_objectives"
                                v-model="form.learning_objectives"
                                rows="6"
                                required
                                maxlength="2000"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.learning_objectives ||
                                        errors.learning_objectives,
                                }"
                                placeholder="Jelaskan tujuan pembelajaran yang ingin dicapai dalam mata kuliah ini..."
                                @blur="validateField('learning_objectives')"
                            ></textarea>
                            <div
                                v-if="
                                    form.errors.learning_objectives ||
                                    errors.learning_objectives
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.learning_objectives ||
                                    errors.learning_objectives
                                }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.learning_objectives.length }}/2000
                                karakter
                            </p>
                        </div>

                        <!-- Learning Outcomes -->
                        <div>
                            <label
                                for="learning_outcomes"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Capaian Pembelajaran
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="learning_outcomes"
                                v-model="form.learning_outcomes"
                                rows="6"
                                required
                                maxlength="2000"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.learning_outcomes ||
                                        errors.learning_outcomes,
                                }"
                                placeholder="Jelaskan capaian pembelajaran yang terukur dan dapat diamati..."
                                @blur="validateField('learning_outcomes')"
                            ></textarea>
                            <div
                                v-if="
                                    form.errors.learning_outcomes ||
                                    errors.learning_outcomes
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.learning_outcomes ||
                                    errors.learning_outcomes
                                }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.learning_outcomes.length }}/2000
                                karakter
                            </p>
                        </div>

                        <!-- Assessment Methods -->
                        <div>
                            <label
                                for="assessment_methods"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Metode Penilaian
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="assessment_methods"
                                v-model="form.assessment_methods"
                                rows="4"
                                required
                                maxlength="1000"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.assessment_methods ||
                                        errors.assessment_methods,
                                }"
                                placeholder="Jelaskan metode penilaian yang akan digunakan (UTS, UAS, Tugas, Quiz, dll)..."
                                @blur="validateField('assessment_methods')"
                            ></textarea>
                            <div
                                v-if="
                                    form.errors.assessment_methods ||
                                    errors.assessment_methods
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.assessment_methods ||
                                    errors.assessment_methods
                                }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.assessment_methods.length }}/1000
                                karakter
                            </p>
                        </div>

                        <!-- References -->
                        <div>
                            <label
                                for="references"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Referensi
                            </label>
                            <textarea
                                id="references"
                                v-model="form.references"
                                rows="4"
                                maxlength="2000"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    'border-red-300':
                                        form.errors.references ||
                                        errors.references,
                                }"
                                placeholder="Daftar buku, jurnal, atau sumber referensi yang digunakan..."
                            ></textarea>
                            <div
                                v-if="
                                    form.errors.references || errors.references
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.references || errors.references
                                }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.references.length }}/2000 karakter
                            </p>
                        </div>

                        <!-- Document Upload -->
                        <div>
                            <label
                                for="document_url"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Dokumen RPS
                            </label>
                            <input
                                id="document_url"
                                ref="documentInput"
                                type="file"
                                accept=".pdf,.doc,.docx"
                                @change="handleDocumentChange"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <div
                                v-if="
                                    form.errors.document_url ||
                                    errors.document_url
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    form.errors.document_url ||
                                    errors.document_url
                                }}
                            </div>

                            <!-- Document Preview -->
                            <div v-if="documentPreview" class="mt-3">
                                <div class="flex items-center space-x-2">
                                    <DocumentIcon
                                        class="h-8 w-8 text-blue-500"
                                    />
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ documentPreview.name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{
                                                formatFileSize(
                                                    documentPreview.size
                                                )
                                            }}
                                        </p>
                                    </div>
                                    <button
                                        type="button"
                                        @click="removeDocument"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        <XMarkIcon class="h-5 w-5" />
                                    </button>
                                </div>
                            </div>

                            <p class="mt-1 text-sm text-gray-500">
                                Format: PDF, DOC, DOCX. Maksimal 5MB. Upload
                                dokumen RPS lengkap.
                            </p>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Status -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">
                                Status RPS
                            </h3>
                            <div>
                                <label
                                    for="status"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="status"
                                    v-model="form.status"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300':
                                            form.errors.status || errors.status,
                                    }"
                                    @change="validateField('status')"
                                >
                                    <option value="">Pilih Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                <div
                                    v-if="form.errors.status || errors.status"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.status || errors.status }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Draft dapat diedit, Submitted menunggu
                                    persetujuan
                                </p>
                            </div>
                        </div>

                        <!-- RPS Info -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-900 mb-2">
                                Tentang RPS
                            </h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>
                                    • RPS adalah panduan pelaksanaan
                                    pembelajaran
                                </li>
                                <li>• Berisi tujuan, metode, dan penilaian</li>
                                <li>
                                    • Harus sesuai dengan kurikulum yang berlaku
                                </li>
                                <li>• Perlu persetujuan sebelum digunakan</li>
                            </ul>
                        </div>

                        <!-- Course Information -->
                        <div
                            v-if="selectedMataKuliah"
                            class="bg-green-50 p-4 rounded-lg"
                        >
                            <h3 class="text-sm font-medium text-green-900 mb-2">
                                Informasi Mata Kuliah
                            </h3>
                            <div class="text-sm text-green-800 space-y-1">
                                <div>
                                    <span class="font-medium">Kode:</span>
                                    {{ selectedMataKuliah.code }}
                                </div>
                                <div>
                                    <span class="font-medium">SKS:</span>
                                    {{ selectedMataKuliah.credits }}
                                </div>
                                <div>
                                    <span class="font-medium">Semester:</span>
                                    {{ selectedMataKuliah.semester }}
                                </div>
                                <div>
                                    <span class="font-medium">Kategori:</span>
                                    {{ selectedMataKuliah.category }}
                                </div>
                                <div
                                    v-if="
                                        selectedMataKuliah.prerequisite &&
                                        selectedMataKuliah.prerequisite.length
                                    "
                                >
                                    <span class="font-medium">Prasyarat:</span>
                                    {{
                                        selectedMataKuliah.prerequisite.join(
                                            ", "
                                        )
                                    }}
                                </div>
                            </div>
                        </div>

                        <!-- Lecturer Information -->
                        <div
                            v-if="selectedDosen"
                            class="bg-yellow-50 p-4 rounded-lg"
                        >
                            <h3
                                class="text-sm font-medium text-yellow-900 mb-2"
                            >
                                Informasi Dosen
                            </h3>
                            <div class="text-sm text-yellow-800 space-y-1">
                                <div>
                                    <span class="font-medium">Nama:</span>
                                    {{ selectedDosen.name }}
                                </div>
                                <div>
                                    <span class="font-medium">Email:</span>
                                    {{ selectedDosen.email }}
                                </div>
                                <div v-if="selectedDosen.expertise">
                                    <span class="font-medium">Keahlian:</span>
                                    {{ selectedDosen.expertise }}
                                </div>
                            </div>
                        </div>

                        <!-- Guidelines -->
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3
                                class="text-sm font-medium text-purple-900 mb-2"
                            >
                                Panduan Pengisian
                            </h3>
                            <ul class="text-sm text-purple-700 space-y-1">
                                <li>
                                    • Tujuan pembelajaran harus jelas dan
                                    terukur
                                </li>
                                <li>
                                    • Capaian pembelajaran mengacu pada KKNI
                                </li>
                                <li>• Metode penilaian harus komprehensif</li>
                                <li>• Referensi minimal 5 tahun terakhir</li>
                                <li>• Dokumen dalam format resmi</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-3 border-t pt-6">
                    <Link
                        href="/admin/rps"
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
                        <span v-else> Simpan RPS </span>
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
import {
    ArrowLeftIcon,
    DocumentIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

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

// State
const documentInput = ref(null);
const documentPreview = ref(null);

// Custom validation errors
const errors = reactive({
    mata_kuliah_id: "",
    dosen_id: "",
    academic_year: "",
    semester: "",
    learning_objectives: "",
    learning_outcomes: "",
    assessment_methods: "",
    status: "",
    document_url: "",
});

// Form
const form = useForm({
    mata_kuliah_id: "",
    dosen_id: "",
    academic_year: "",
    semester: "",
    learning_objectives: "",
    learning_outcomes: "",
    assessment_methods: "",
    references: "",
    document_url: null,
    status: "draft",
});

// Computed
const isFormValid = computed(() => {
    return (
        form.mata_kuliah_id !== "" &&
        form.dosen_id !== "" &&
        form.academic_year.trim() !== "" &&
        form.semester !== "" &&
        form.learning_objectives.trim() !== "" &&
        form.learning_outcomes.trim() !== "" &&
        form.assessment_methods.trim() !== "" &&
        form.status !== "" &&
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

        case "learning_objectives":
            if (!form.learning_objectives.trim()) {
                errors.learning_objectives = "Tujuan pembelajaran wajib diisi";
            } else if (form.learning_objectives.length < 50) {
                errors.learning_objectives =
                    "Tujuan pembelajaran minimal 50 karakter";
            }
            break;

        case "learning_outcomes":
            if (!form.learning_outcomes.trim()) {
                errors.learning_outcomes = "Capaian pembelajaran wajib diisi";
            } else if (form.learning_outcomes.length < 50) {
                errors.learning_outcomes =
                    "Capaian pembelajaran minimal 50 karakter";
            }
            break;

        case "assessment_methods":
            if (!form.assessment_methods.trim()) {
                errors.assessment_methods = "Metode penilaian wajib diisi";
            } else if (form.assessment_methods.length < 20) {
                errors.assessment_methods =
                    "Metode penilaian minimal 20 karakter";
            }
            break;

        case "status":
            if (!form.status) {
                errors.status = "Status wajib dipilih";
            }
            break;
    }
};

const validateDocument = (file) => {
    errors.document_url = "";

    if (!file) return true;

    // Check file type
    const allowedTypes = [
        "application/pdf",
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    ];
    if (!allowedTypes.includes(file.type)) {
        errors.document_url = "Format dokumen harus PDF, DOC, atau DOCX";
        return false;
    }

    // Check file size (5MB)
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if (file.size > maxSize) {
        errors.document_url = "Ukuran dokumen maksimal 5MB";
        return false;
    }

    return true;
};

const handleDocumentChange = (event) => {
    const file = event.target.files[0];

    if (file) {
        if (!validateDocument(file)) {
            event.target.value = "";
            documentPreview.value = null;
            form.document_url = null;
            return;
        }

        form.document_url = file;
        documentPreview.value = {
            name: file.name,
            size: file.size,
        };
    }
};

const removeDocument = () => {
    documentPreview.value = null;
    form.document_url = null;
    if (documentInput.value) {
        documentInput.value.value = "";
    }
};

const formatFileSize = (bytes) => {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

const submit = () => {
    // Validate all required fields
    validateField("mata_kuliah_id");
    validateField("dosen_id");
    validateField("academic_year");
    validateField("semester");
    validateField("learning_objectives");
    validateField("learning_outcomes");
    validateField("assessment_methods");
    validateField("status");

    if (Object.values(errors).some((error) => error !== "")) {
        error("Validasi Error!", "Mohon perbaiki data yang belum valid.");
        return;
    }

    form.post("/admin/rps", {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "RPS berhasil ditambahkan.");
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
