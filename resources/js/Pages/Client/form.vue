<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <AcademicCapIcon class="h-8 w-8 text-indigo-600" />
                            <div class="ml-3">
                                <h1 class="text-xl font-semibold text-gray-900">
                                    {{ questionnaire.title }}
                                </h1>
                                <p class="text-sm text-gray-600">
                                    {{ questionnaire.program_studi?.name }} -
                                    {{ questionnaire.semester }}
                                    {{ questionnaire.academic_year }}
                                </p>
                            </div>
                        </div>
                        <Link
                            href="/evaluation"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <ArrowLeftIcon class="h-4 w-4 mr-2" />
                            Kembali
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Student Validation Form (if not validated) -->
            <div
                v-if="!studentValidated"
                class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8"
            >
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Verifikasi Data Mahasiswa
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Silakan masukkan NIM dan email Anda untuk melanjutkan
                    </p>
                </div>
                <div class="px-6 py-4">
                    <form @submit.prevent="validateStudent" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    NIM *
                                </label>
                                <input
                                    v-model="validationForm.nim"
                                    type="text"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :class="{
                                        'border-red-300': validationErrors.nim,
                                    }"
                                    placeholder="Masukkan NIM Anda"
                                />
                                <p
                                    v-if="validationErrors.nim"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ validationErrors.nim }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Email *
                                </label>
                                <input
                                    v-model="validationForm.email"
                                    type="email"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    :class="{
                                        'border-red-300':
                                            validationErrors.email,
                                    }"
                                    placeholder="Masukkan email Anda"
                                />
                                <p
                                    v-if="validationErrors.email"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ validationErrors.email }}
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button
                                type="submit"
                                :disabled="validationLoading"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span v-if="validationLoading"
                                    >Memverifikasi...</span
                                >
                                <span v-else>Verifikasi & Lanjutkan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Evaluation Form (if student validated) -->
            <div v-if="studentValidated">
                <form @submit.prevent="submitEvaluation" class="space-y-6">
                    <!-- Student Info Display -->
                    <div
                        class="bg-green-50 rounded-lg border border-green-200 p-4"
                    >
                        <div class="flex">
                            <CheckCircleIcon
                                class="h-5 w-5 text-green-400 mt-0.5"
                            />
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">
                                    Data Terverifikasi
                                </h3>
                                <div class="mt-2 text-sm text-green-700">
                                    <p>
                                        NIM: {{ studentData.nim }} | Nama:
                                        {{ studentData.name }}
                                    </p>
                                    <p>
                                        Program Studi:
                                        {{ studentData.prodi_name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Informasi Mata Kuliah
                            </h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Semester yang Anda ambil saat ini *
                                    </label>
                                    <select
                                        v-model="evaluationForm.semester_taken"
                                        required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option value="">Pilih Semester</option>
                                        <option
                                            v-for="n in 13"
                                            :key="n"
                                            :value="n"
                                        >
                                            Semester {{ n }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Jumlah Dosen Pengampu *
                                    </label>
                                    <select
                                        v-model="evaluationForm.lecturer_count"
                                        required
                                        @change="onLecturerCountChange"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option value="">
                                            Pilih Jumlah Dosen
                                        </option>
                                        <option :value="1">1 Dosen</option>
                                        <option :value="2">2 Dosen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lecturer Selection -->
                    <div
                        v-if="evaluationForm.lecturer_count"
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">
                                Pilih Dosen
                            </h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <!-- Lecturer 1 -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Dosen Pengampu 1 *
                                </label>
                                <select
                                    v-model="evaluationForm.lecturer_1_id"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Pilih Dosen</option>
                                    <option
                                        v-for="lecturer in lecturers"
                                        :key="lecturer.id"
                                        :value="lecturer.id"
                                        :disabled="
                                            lecturer.id ==
                                            evaluationForm.lecturer_2_id
                                        "
                                    >
                                        {{ lecturer.name }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Jumlah Kehadiran Dosen 1 *
                                </label>
                                <select
                                    v-model="
                                        evaluationForm.attendance_lecturer_1
                                    "
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">
                                        Pilih Jumlah Kehadiran
                                    </option>
                                    <option value="0">0 kali Pertemuan</option>
                                    <option value="1-4">
                                        1-4 Kali Pertemuan
                                    </option>
                                    <option value="5-8">
                                        5-8 Kali Pertemuan
                                    </option>
                                    <option value=">9">
                                        &gt; 9 Kali Pertemuan
                                    </option>
                                </select>
                            </div>

                            <!-- Lecturer 2 (if applicable) -->
                            <div
                                v-if="evaluationForm.lecturer_count == 2"
                                class="space-y-4 pt-4 border-t border-gray-200"
                            >
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Dosen Pengampu 2 *
                                    </label>
                                    <select
                                        v-model="evaluationForm.lecturer_2_id"
                                        required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option value="">Pilih Dosen</option>
                                        <option
                                            v-for="lecturer in lecturers"
                                            :key="lecturer.id"
                                            :value="lecturer.id"
                                            :disabled="
                                                lecturer.id ==
                                                evaluationForm.lecturer_1_id
                                            "
                                        >
                                            {{ lecturer.name }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Jumlah Kehadiran Dosen 2 *
                                    </label>
                                    <select
                                        v-model="
                                            evaluationForm.attendance_lecturer_2
                                        "
                                        required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                        <option value="">
                                            Pilih Jumlah Kehadiran
                                        </option>
                                        <option value="0">
                                            0 kali Pertemuan
                                        </option>
                                        <option value="1-4">
                                            1-4 Kali Pertemuan
                                        </option>
                                        <option value="5-8">
                                            5-8 Kali Pertemuan
                                        </option>
                                        <option value=">9">
                                            &gt; 9 Kali Pertemuan
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Questions -->
                    <div v-if="evaluationForm.lecturer_1_id" class="space-y-6">
                        <div
                            v-for="category in questionnaire.categories"
                            :key="category.id"
                            class="bg-white rounded-lg shadow-sm border border-gray-200"
                        >
                            <div
                                class="px-6 py-4 border-b border-gray-200 bg-gray-50"
                            >
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ category.name }}
                                </h3>
                                <p
                                    v-if="category.description"
                                    class="text-sm text-gray-600 mt-1"
                                >
                                    {{ category.description }}
                                </p>
                            </div>

                            <div class="px-6 py-4 space-y-6">
                                <div
                                    v-for="question in category.questions"
                                    :key="question.id"
                                    class="border-b border-gray-100 pb-6 last:border-b-0"
                                >
                                    <div class="mb-4">
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            {{ question.question_text }}
                                            <span
                                                v-if="question.is_required"
                                                class="text-red-500"
                                                >*</span
                                            >
                                        </label>
                                    </div>

                                    <!-- Rating Questions (per lecturer) -->
                                    <div
                                        v-if="
                                            question.input_type === 'radio' &&
                                            question.is_for_lecturer
                                        "
                                    >
                                        <!-- Lecturer 1 Rating -->
                                        <div class="mb-4">
                                            <p
                                                class="text-sm font-medium text-gray-600 mb-2"
                                            >
                                                {{
                                                    getLecturerName(
                                                        evaluationForm.lecturer_1_id
                                                    )
                                                }}
                                            </p>
                                            <div
                                                class="grid grid-cols-2 md:grid-cols-4 gap-2"
                                            >
                                                <label
                                                    v-for="option in questionnaire.scale_options"
                                                    :key="`${question.id}-${evaluationForm.lecturer_1_id}-${option.value}`"
                                                    class="relative flex items-center p-3 border rounded-md cursor-pointer hover:bg-gray-50"
                                                    :class="{
                                                        'border-indigo-500 bg-indigo-50':
                                                            isAnswerSelected(
                                                                question.id,
                                                                evaluationForm.lecturer_1_id,
                                                                option.value
                                                            ),
                                                        'border-gray-300':
                                                            !isAnswerSelected(
                                                                question.id,
                                                                evaluationForm.lecturer_1_id,
                                                                option.value
                                                            ),
                                                    }"
                                                >
                                                    <input
                                                        :value="option.value"
                                                        :name="`q_${question.id}_lecturer_${evaluationForm.lecturer_1_id}`"
                                                        type="radio"
                                                        class="sr-only"
                                                        @change="
                                                            setAnswer(
                                                                question.id,
                                                                evaluationForm.lecturer_1_id,
                                                                option.value
                                                            )
                                                        "
                                                    />
                                                    <div
                                                        class="flex flex-col items-center text-center"
                                                    >
                                                        <span
                                                            class="text-lg font-bold text-gray-700"
                                                            >{{
                                                                option.value
                                                            }}</span
                                                        >
                                                        <span
                                                            class="text-xs text-gray-600 mt-1"
                                                            >{{
                                                                option.label
                                                            }}</span
                                                        >
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Lecturer 2 Rating (if applicable) -->
                                        <div
                                            v-if="
                                                evaluationForm.lecturer_count ==
                                                    2 &&
                                                evaluationForm.lecturer_2_id
                                            "
                                        >
                                            <p
                                                class="text-sm font-medium text-gray-600 mb-2"
                                            >
                                                {{
                                                    getLecturerName(
                                                        evaluationForm.lecturer_2_id
                                                    )
                                                }}
                                            </p>
                                            <div
                                                class="grid grid-cols-2 md:grid-cols-4 gap-2"
                                            >
                                                <label
                                                    v-for="option in questionnaire.scale_options"
                                                    :key="`${question.id}-${evaluationForm.lecturer_2_id}-${option.value}`"
                                                    class="relative flex items-center p-3 border rounded-md cursor-pointer hover:bg-gray-50"
                                                    :class="{
                                                        'border-indigo-500 bg-indigo-50':
                                                            isAnswerSelected(
                                                                question.id,
                                                                evaluationForm.lecturer_2_id,
                                                                option.value
                                                            ),
                                                        'border-gray-300':
                                                            !isAnswerSelected(
                                                                question.id,
                                                                evaluationForm.lecturer_2_id,
                                                                option.value
                                                            ),
                                                    }"
                                                >
                                                    <input
                                                        :value="option.value"
                                                        :name="`q_${question.id}_lecturer_${evaluationForm.lecturer_2_id}`"
                                                        type="radio"
                                                        class="sr-only"
                                                        @change="
                                                            setAnswer(
                                                                question.id,
                                                                evaluationForm.lecturer_2_id,
                                                                option.value
                                                            )
                                                        "
                                                    />
                                                    <div
                                                        class="flex flex-col items-center text-center"
                                                    >
                                                        <span
                                                            class="text-lg font-bold text-gray-700"
                                                            >{{
                                                                option.value
                                                            }}</span
                                                        >
                                                        <span
                                                            class="text-xs text-gray-600 mt-1"
                                                            >{{
                                                                option.label
                                                            }}</span
                                                        >
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text Questions (general) -->
                                    <div
                                        v-else-if="
                                            question.input_type === 'textarea'
                                        "
                                    >
                                        <textarea
                                            :value="
                                                getGeneralAnswer(question.id)
                                            "
                                            @input="
                                                setGeneralAnswer(
                                                    question.id,
                                                    $event.target.value
                                                )
                                            "
                                            rows="3"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Masukkan jawaban Anda..."
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Suggestions -->
                    <div
                        v-if="evaluationForm.lecturer_1_id"
                        class="bg-white rounded-lg shadow-sm border border-gray-200"
                    >
                        <div
                            class="px-6 py-4 border-b border-gray-200 bg-gray-50"
                        >
                            <h3 class="text-lg font-medium text-gray-900">
                                Saran dan Masukan
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Berikan saran untuk perbaikan (opsional)
                            </p>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Saran Umum
                                </label>
                                <textarea
                                    v-model="evaluationForm.general_suggestion"
                                    rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Saran untuk perbaikan program studi secara umum..."
                                ></textarea>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Saran untuk
                                    {{
                                        getLecturerName(
                                            evaluationForm.lecturer_1_id
                                        )
                                    }}
                                </label>
                                <textarea
                                    v-model="
                                        evaluationForm.suggestion_lecturer_1
                                    "
                                    rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Saran khusus untuk dosen..."
                                ></textarea>
                            </div>

                            <div
                                v-if="
                                    evaluationForm.lecturer_count == 2 &&
                                    evaluationForm.lecturer_2_id
                                "
                            >
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Saran untuk
                                    {{
                                        getLecturerName(
                                            evaluationForm.lecturer_2_id
                                        )
                                    }}
                                </label>
                                <textarea
                                    v-model="
                                        evaluationForm.suggestion_lecturer_2
                                    "
                                    rows="3"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Saran khusus untuk dosen..."
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3">
                        <Link
                            href="/evaluation"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="submissionLoading || !isFormValid"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="submissionLoading">Mengirim...</span>
                            <span v-else>Kirim Evaluasi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import {
    AcademicCapIcon,
    ArrowLeftIcon,
    CheckCircleIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    questionnaire: {
        type: Object,
        required: true,
    },
    lecturers: {
        type: Array,
        default: () => [],
    },
});

// Reactive data
const studentValidated = ref(false);
const validationLoading = ref(false);
const submissionLoading = ref(false);
const validationErrors = ref({});
const submissionErrors = ref({});

const validationForm = reactive({
    nim: "",
    email: "",
});

const studentData = ref({});

const evaluationForm = reactive({
    student_nim: "",
    student_email: "",
    semester_taken: "",
    lecturer_count: "",
    lecturer_1_id: "",
    lecturer_2_id: "",
    attendance_lecturer_1: "",
    attendance_lecturer_2: "",
    answers: {},
    general_suggestion: "",
    suggestion_lecturer_1: "",
    suggestion_lecturer_2: "",
});

// Computed
const isFormValid = computed(() => {
    if (!studentValidated.value) return false;
    if (!evaluationForm.semester_taken) return false;
    if (!evaluationForm.lecturer_count) return false;
    if (!evaluationForm.lecturer_1_id) return false;
    if (!evaluationForm.attendance_lecturer_1) return false;

    if (evaluationForm.lecturer_count == 2) {
        if (!evaluationForm.lecturer_2_id) return false;
        if (!evaluationForm.attendance_lecturer_2) return false;
    }

    // Check if all required questions are answered
    const requiredQuestions = props.questionnaire.categories
        .flatMap((cat) => cat.questions)
        .filter((q) => q.is_required);

    for (const question of requiredQuestions) {
        if (question.is_for_lecturer) {
            // Check lecturer 1
            if (
                !evaluationForm.answers[question.id] ||
                !evaluationForm.answers[question.id][
                    evaluationForm.lecturer_1_id
                ]
            ) {
                return false;
            }
            // Check lecturer 2 if applicable
            if (
                evaluationForm.lecturer_count == 2 &&
                evaluationForm.lecturer_2_id
            ) {
                if (
                    !evaluationForm.answers[question.id] ||
                    !evaluationForm.answers[question.id][
                        evaluationForm.lecturer_2_id
                    ]
                ) {
                    return false;
                }
            }
        } else {
            // General question
            if (!evaluationForm.answers[question.id]) {
                return false;
            }
        }
    }

    return true;
});

// Methods
const validateStudent = async () => {
    validationLoading.value = true;
    validationErrors.value = {};

    try {
        const response = await fetch("/evaluation/check-student", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                nim: validationForm.nim,
                email: validationForm.email,
            }),
        });

        const data = await response.json();

        if (data.valid) {
            studentValidated.value = true;
            studentData.value = data.student;
            evaluationForm.student_nim = data.student.nim;
            evaluationForm.student_email = data.student.email;
        } else {
            validationErrors.value = { nim: data.message };
        }
    } catch (error) {
        console.error("Validation error:", error);
        validationErrors.value = {
            nim: "Terjadi kesalahan saat memverifikasi data.",
        };
    } finally {
        validationLoading.value = false;
    }
};

const onLecturerCountChange = () => {
    evaluationForm.lecturer_2_id = "";
    evaluationForm.attendance_lecturer_2 = "";
    evaluationForm.suggestion_lecturer_2 = "";

    // Clear answers for lecturer 2 if switching from 2 to 1
    if (evaluationForm.lecturer_count == 1) {
        Object.keys(evaluationForm.answers).forEach((questionId) => {
            if (
                evaluationForm.answers[questionId] &&
                typeof evaluationForm.answers[questionId] === "object"
            ) {
                // Remove lecturer 2 answers
                Object.keys(evaluationForm.answers[questionId]).forEach(
                    (lecturerId) => {
                        if (lecturerId != evaluationForm.lecturer_1_id) {
                            delete evaluationForm.answers[questionId][
                                lecturerId
                            ];
                        }
                    }
                );
            }
        });
    }
};

const getLecturerName = (lecturerId) => {
    const lecturer = props.lecturers.find((l) => l.id == lecturerId);
    return lecturer ? lecturer.name : "";
};

const isAnswerSelected = (questionId, lecturerId, value) => {
    return (
        evaluationForm.answers[questionId] &&
        evaluationForm.answers[questionId][lecturerId] == value
    );
};

const setAnswer = (questionId, lecturerId, value) => {
    if (!evaluationForm.answers[questionId]) {
        evaluationForm.answers[questionId] = {};
    }
    evaluationForm.answers[questionId][lecturerId] = value;
};

const getGeneralAnswer = (questionId) => {
    return evaluationForm.answers[questionId] || "";
};

const setGeneralAnswer = (questionId, value) => {
    evaluationForm.answers[questionId] = value;
};

const submitEvaluation = async () => {
    if (!isFormValid.value) {
        alert("Mohon lengkapi semua field yang wajib diisi.");
        return;
    }

    submissionLoading.value = true;
    submissionErrors.value = {};

    try {
        router.post(`/evaluation/${props.questionnaire.id}`, evaluationForm, {
            onSuccess: () => {
                submissionLoading.value = false;
            },
            onError: (errors) => {
                submissionLoading.value = false;
                submissionErrors.value = errors;
                console.error("Submission errors:", errors);
                alert(
                    "Terjadi kesalahan saat mengirim evaluasi. Silakan coba lagi."
                );
            },
        });
    } catch (error) {
        submissionLoading.value = false;
        console.error("Submission error:", error);
        alert("Terjadi kesalahan saat mengirim evaluasi. Silakan coba lagi.");
    }
};

// Initialize form
onMounted(() => {
    // Initialize answers object
    evaluationForm.answers = {};
});
</script>
