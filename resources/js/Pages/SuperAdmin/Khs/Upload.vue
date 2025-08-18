<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Upload KHS
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Upload file KHS untuk mahasiswa individual
                        </p>
                    </div>
                    <Link
                        :href="route('super-admin.khs.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upload Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Form Upload KHS
                    </h2>
                </div>
                <form @submit.prevent="handleSubmit" class="p-6">
                    <!-- Academic Period -->
                    <div class="mb-6">
                        <label
                            for="academic_period_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Period Akademik <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="academic_period_id"
                            v-model="form.academic_period_id"
                            @change="onPeriodChange"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.academic_period_id
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            required
                        >
                            <option value="">Pilih Period Akademik...</option>
                            <option
                                v-for="period in props.periods"
                                :key="period.id"
                                :value="period.id"
                            >
                                {{
                                    period.display_name ??
                                    period.name ??
                                    period.semester + " " + period.academic_year
                                }}
                            </option>
                        </select>
                        <p
                            v-if="errors.academic_period_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.academic_period_id }}
                        </p>
                    </div>

                    <!-- Student Selection -->
                    <div class="mb-6">
                        <label
                            for="student_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Mahasiswa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                v-model="studentSearch"
                                @input="searchStudents"
                                @focus="showStudentDropdown = true"
                                placeholder="Cari berdasarkan NIM atau nama..."
                                :class="[
                                    'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                    errors.student_id
                                        ? 'border-red-300'
                                        : 'border-gray-300',
                                ]"
                                required
                            />

                            <!-- Student Dropdown -->
                            <div
                                v-if="
                                    showStudentDropdown &&
                                    filteredStudents.length > 0
                                "
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto"
                            >
                                <div
                                    v-for="student in filteredStudents"
                                    :key="student.id"
                                    @click="selectStudent(student)"
                                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0"
                                >
                                    <div class="font-medium text-gray-900">
                                        {{ student.name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        NIM: {{ student.nim }} |
                                        {{ student.program_studi }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Selected Student Display -->
                        <div
                            v-if="selectedStudent"
                            class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md"
                        >
                            <div class="flex items-center">
                                <AcademicCapIcon
                                    class="h-5 w-5 text-blue-600 mr-2"
                                />
                                <div>
                                    <div class="font-medium text-blue-900">
                                        {{ selectedStudent.name }}
                                    </div>
                                    <div class="text-sm text-blue-700">
                                        NIM: {{ selectedStudent.nim }} |
                                        {{ selectedStudent.program_studi }}
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    @click="clearStudent"
                                    class="ml-auto text-blue-400 hover:text-blue-600"
                                >
                                    <XMarkIcon class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <p
                            v-if="errors.student_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.student_id }}
                        </p>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-6">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            File KHS (PDF) <span class="text-red-500">*</span>
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors"
                        >
                            <div class="space-y-1 text-center">
                                <DocumentArrowUpIcon
                                    class="mx-auto h-12 w-12 text-gray-400"
                                />
                                <div class="flex text-sm text-gray-600">
                                    <label
                                        for="file-upload"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                    >
                                        <span>Upload file</span>
                                        <input
                                            id="file-upload"
                                            name="file"
                                            type="file"
                                            class="sr-only"
                                            accept=".pdf"
                                            @change="handleFileChange"
                                            ref="fileInput"
                                        />
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PDF hingga 10MB
                                </p>
                            </div>
                        </div>

                        <!-- Selected File Display -->
                        <div
                            v-if="selectedFile"
                            class="mt-3 flex items-center justify-between bg-gray-50 px-3 py-2 rounded-md"
                        >
                            <div class="flex items-center">
                                <DocumentTextIcon
                                    class="h-5 w-5 text-gray-400 mr-2"
                                />
                                <span class="text-sm text-gray-900">{{
                                    selectedFile.name
                                }}</span>
                                <span class="text-xs text-gray-500 ml-2"
                                    >({{
                                        formatFileSize(selectedFile.size)
                                    }})</span
                                >
                            </div>
                            <button
                                type="button"
                                @click="removeFile"
                                class="text-red-500 hover:text-red-700"
                            >
                                <XMarkIcon class="h-4 w-4" />
                            </button>
                        </div>

                        <p v-if="errors.file" class="mt-1 text-sm text-red-600">
                            {{ errors.file }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3">
                        <Link
                            :href="route('super-admin.khs.index')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="!canSubmit || processing"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="processing" class="flex items-center">
                                <svg
                                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                                Mengupload...
                            </span>
                            <span v-else>
                                <DocumentArrowUpIcon class="w-4 h-4 mr-2" />
                                Upload KHS
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Upload Guidelines -->
            <div class="space-y-6">
                <!-- File Requirements -->
                <div
                    class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200"
                >
                    <div class="px-6 py-4 border-b border-yellow-200">
                        <h2 class="text-lg font-medium text-yellow-900">
                            Persyaratan File
                        </h2>
                    </div>
                    <div class="p-6">
                        <ul class="text-sm text-yellow-800 space-y-2">
                            <li class="flex items-start">
                                <CheckCircleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span>Format file: PDF</span>
                            </li>
                            <li class="flex items-start">
                                <CheckCircleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span>Ukuran maksimal: 10MB</span>
                            </li>
                            <li class="flex items-start">
                                <CheckCircleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span
                                    >Nama file direkomendasikan:
                                    NIM_KHS_Semester_Tahun.pdf</span
                                >
                            </li>
                            <li class="flex items-start">
                                <CheckCircleIcon
                                    class="h-5 w-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0"
                                />
                                <span
                                    >File harus dapat dibaca dan tidak
                                    terproteksi password</span
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Upload Process -->
                <div
                    class="bg-blue-50 rounded-lg shadow-sm border border-blue-200"
                >
                    <div class="px-6 py-4 border-b border-blue-200">
                        <h2 class="text-lg font-medium text-blue-900">
                            Proses Upload
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-sm text-blue-800 space-y-3">
                            <div class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center mr-3 mt-0.5"
                                    >1</span
                                >
                                <span>File akan diupload ke Google Drive</span>
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center mr-3 mt-0.5"
                                    >2</span
                                >
                                <span
                                    >Sistem akan generate link download
                                    otomatis</span
                                >
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center mr-3 mt-0.5"
                                    >3</span
                                >
                                <span
                                    >Orang tua dapat langsung mengakses melalui
                                    portal</span
                                >
                            </div>
                            <div class="flex items-start">
                                <span
                                    class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center mr-3 mt-0.5"
                                    >4</span
                                >
                                <span
                                    >Aktivitas akses akan tercatat untuk
                                    monitoring</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div
                    class="bg-green-50 rounded-lg shadow-sm border border-green-200"
                >
                    <div class="px-6 py-4 border-b border-green-200">
                        <h2 class="text-lg font-medium text-green-900">
                            Upload Massal
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-green-800 mb-4">
                            Untuk upload banyak file sekaligus, gunakan fitur
                            bulk upload.
                        </p>
                        <Link
                            :href="route('super-admin.khs.bulk-upload')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <DocumentArrowUpIcon class="w-4 h-4 mr-2" />
                            Bulk Upload
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    DocumentArrowUpIcon,
    DocumentTextIcon,
    AcademicCapIcon,
    XMarkIcon,
    CheckCircleIcon,
} from "@heroicons/vue/24/outline";
import { debounce } from "lodash";

// Props
const props = defineProps({
    periods: {
        type: Array,
        default: () => [],
    },
    students: {
        type: Array,
        default: () => [],
    },
});

// Form
const form = useForm({
    academic_period_id: "",
    student_id: "",
    file: null,
});

// Reactive data
const processing = ref(false);
const errors = ref({});
const selectedFile = ref(null);
const selectedStudent = ref(null);
const studentSearch = ref("");
const filteredStudents = ref([]);
const showStudentDropdown = ref(false);
const fileInput = ref(null);

// Computed
const canSubmit = computed(() => {
    return form.academic_period_id && form.student_id && selectedFile.value;
});

// Methods
const searchStudents = debounce(() => {
    if (!studentSearch.value || studentSearch.value.length < 2) {
        filteredStudents.value = [];
        return;
    }

    const search = studentSearch.value.toLowerCase();
    filteredStudents.value = props.students
        .filter(
            (student) =>
                student.nim.toLowerCase().includes(search) ||
                student.name.toLowerCase().includes(search)
        )
        .slice(0, 10);
}, 300);

const selectStudent = (student) => {
    selectedStudent.value = student;
    form.student_id = student.id;
    studentSearch.value = `${student.nim} - ${student.name}`;
    showStudentDropdown.value = false;
    filteredStudents.value = [];
};

const clearStudent = () => {
    selectedStudent.value = null;
    form.student_id = "";
    studentSearch.value = "";
    filteredStudents.value = [];
};

const onPeriodChange = () => {
    // Could fetch students without KHS for this period
    // For now, just continue with all students
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Validate file
        if (file.type !== "application/pdf") {
            errors.value.file = "File harus dalam format PDF";
            return;
        }

        if (file.size > 10 * 1024 * 1024) {
            // 10MB
            errors.value.file = "Ukuran file tidak boleh lebih dari 10MB";
            return;
        }

        selectedFile.value = file;
        form.file = file;
        errors.value.file = null;
    }
};

const removeFile = () => {
    selectedFile.value = null;
    form.file = null;
    fileInput.value.value = "";
};

const formatFileSize = (bytes) => {
    if (bytes === 0) return "0 Bytes";
    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

const handleSubmit = () => {
    processing.value = true;
    errors.value = {};

    form.post(route("super-admin.khs.store-upload"), {
        onSuccess: () => {
            processing.value = false;
        },
        onError: (responseErrors) => {
            processing.value = false;
            errors.value = responseErrors;
        },
    });
};

// Close dropdown when clicking outside
document.addEventListener("click", (event) => {
    if (!event.target.closest(".relative")) {
        showStudentDropdown.value = false;
    }
});
</script>
