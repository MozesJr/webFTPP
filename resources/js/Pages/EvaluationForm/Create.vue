<template>
    <AppLayout>
        <!-- Hero Section -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Form Evaluasi EDOM</h1>
                <p>{{ questionnaire.title }}</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>
                            <Link :href="route('evaluation.index')">EDOM</Link>
                        </li>
                        <li class="current">Evaluasi</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <section class="py-5">
            <div class="container">
                <!-- Form -->
                <form
                    @submit.prevent="submitForm"
                    class="needs-validation"
                    novalidate
                >
                    <!-- Student Information Card -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-person-badge me-2"></i>
                                Informasi Mahasiswa
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >NIM
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        v-model="form.student_nim"
                                        type="text"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.student_nim,
                                        }"
                                        placeholder="Masukkan NIM"
                                        @blur="checkStudent"
                                        required
                                    />
                                    <div
                                        v-if="errors.student_nim"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.student_nim }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Email
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        v-model="form.student_email"
                                        type="email"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': errors.student_email,
                                        }"
                                        placeholder="Masukkan email"
                                        @blur="checkStudent"
                                        required
                                    />
                                    <div
                                        v-if="errors.student_email"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.student_email }}
                                    </div>
                                </div>

                                <!-- Student Verification Status -->
                                <div
                                    v-if="studentVerification.status"
                                    class="col-12"
                                >
                                    <div
                                        :class="[
                                            'alert',
                                            studentVerification.valid
                                                ? 'alert-success'
                                                : 'alert-danger',
                                        ]"
                                    >
                                        <i
                                            :class="[
                                                'bi me-2',
                                                studentVerification.valid
                                                    ? 'bi-check-circle'
                                                    : 'bi-x-circle',
                                            ]"
                                        ></i>
                                        <strong>
                                            {{
                                                studentVerification.valid
                                                    ? "Terverifikasi:"
                                                    : "Error:"
                                            }}
                                        </strong>
                                        {{ studentVerification.message }}
                                        <div
                                            v-if="
                                                studentVerification.valid &&
                                                studentData
                                            "
                                            class="mt-2"
                                        >
                                            <small>
                                                Nama:
                                                <strong>{{
                                                    studentData.name
                                                }}</strong>
                                                | Program Studi:
                                                <strong>{{
                                                    studentData.prodi_name
                                                }}</strong>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Information Card -->
                    <div
                        v-if="studentVerification.valid"
                        class="card mb-4 shadow-sm"
                    >
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-book me-2"></i>
                                Informasi Mata Kuliah
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label"
                                        >Semester yang Diambil
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        v-model="form.semester_taken"
                                        class="form-select"
                                        :class="{
                                            'is-invalid': errors.semester_taken,
                                        }"
                                        :disabled="isStudentSemesterFixed"
                                        required
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
                                    <div
                                        v-if="errors.semester_taken"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.semester_taken }}
                                    </div>
                                    <small
                                        v-if="isStudentSemesterFixed"
                                        class="text-muted"
                                    >
                                        Semester otomatis berdasarkan data
                                        mahasiswa
                                    </small>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label"
                                        >Jumlah Dosen Pengampu
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        v-model="form.lecturer_count"
                                        class="form-select"
                                        :class="{
                                            'is-invalid': errors.lecturer_count,
                                        }"
                                        required
                                    >
                                        <option value="">Pilih Jumlah</option>
                                        <option value="1">1 Dosen</option>
                                        <option value="2">2 Dosen</option>
                                    </select>
                                    <div
                                        v-if="errors.lecturer_count"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.lecturer_count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lecturers Selection Card -->
                    <div
                        v-if="studentVerification.valid"
                        class="card mb-4 shadow-sm"
                    >
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-people me-2"></i>
                                Pilih Dosen Pengampu
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Lecturer 1 -->
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Dosen Pengampu 1
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        v-model="form.lecturer_1_id"
                                        class="form-select"
                                        :class="{
                                            'is-invalid': errors.lecturer_1_id,
                                        }"
                                        required
                                    >
                                        <option value="">Pilih Dosen 1</option>
                                        <option
                                            v-for="lecturer in lecturers"
                                            :key="lecturer.id"
                                            :value="lecturer.id"
                                        >
                                            {{ lecturer.name }}
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.lecturer_1_id"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.lecturer_1_id }}
                                    </div>
                                </div>

                                <!-- Lecturer 2 -->
                                <div
                                    v-if="form.lecturer_count == 2"
                                    class="col-md-6"
                                >
                                    <label class="form-label"
                                        >Dosen Pengampu 2
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        v-model="form.lecturer_2_id"
                                        class="form-select"
                                        :class="{
                                            'is-invalid': errors.lecturer_2_id,
                                        }"
                                        :required="form.lecturer_count == 2"
                                    >
                                        <option value="">Pilih Dosen 2</option>
                                        <option
                                            v-for="lecturer in availableLecturers2"
                                            :key="lecturer.id"
                                            :value="lecturer.id"
                                        >
                                            {{ lecturer.name }}
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.lecturer_2_id"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.lecturer_2_id }}
                                    </div>
                                </div>
                            </div>

                            <!-- Attendance -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Kehadiran Dosen 1
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        v-model="form.attendance_lecturer_1"
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                errors.attendance_lecturer_1,
                                        }"
                                        required
                                    >
                                        <option value="">
                                            Pilih Kehadiran
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
                                            > 9 Kali Pertemuan
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.attendance_lecturer_1"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.attendance_lecturer_1 }}
                                    </div>
                                </div>

                                <div
                                    v-if="form.lecturer_count == 2"
                                    class="col-md-6"
                                >
                                    <label class="form-label"
                                        >Kehadiran Dosen 2
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <select
                                        v-model="form.attendance_lecturer_2"
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                errors.attendance_lecturer_2,
                                        }"
                                        :required="form.lecturer_count == 2"
                                    >
                                        <option value="">
                                            Pilih Kehadiran
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
                                            > 9 Kali Pertemuan
                                        </option>
                                    </select>
                                    <div
                                        v-if="errors.attendance_lecturer_2"
                                        class="invalid-feedback"
                                    >
                                        {{ errors.attendance_lecturer_2 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DYNAMIC QUESTIONS SECTION - This is the key fix -->
                    <div v-if="shouldShowQuestions" class="card mb-4 shadow-sm">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0">
                                <i class="bi bi-question-circle me-2"></i>
                                Evaluasi Pertanyaan
                            </h5>
                            <small class="text-muted"
                                >Berikan penilaian sesuai dengan pengalaman
                                Anda</small
                            >
                        </div>
                        <div class="card-body">
                            <!-- Loop through categories -->
                            <div
                                v-for="(
                                    category, categoryIndex
                                ) in questionnaire.categories"
                                :key="category.id"
                                class="mb-5"
                            >
                                <div class="category-header mb-4">
                                    <h4
                                        class="text-primary fw-bold border-bottom pb-2"
                                    >
                                        {{ category.name }}
                                    </h4>
                                    <p
                                        v-if="category.description"
                                        class="text-muted mb-0"
                                    >
                                        {{ category.description }}
                                    </p>
                                </div>

                                <!-- Loop through questions in this category -->
                                <div
                                    v-for="(
                                        question, questionIndex
                                    ) in category.questions"
                                    :key="question.id"
                                    class="question-block mb-4 p-3 border rounded bg-light"
                                >
                                    <div class="question-header mb-3">
                                        <label
                                            class="form-label fw-medium mb-2"
                                        >
                                            {{ categoryIndex + 1 }}.{{
                                                questionIndex + 1
                                            }}. {{ question.question_text }}
                                            <span
                                                v-if="question.is_required"
                                                class="text-danger"
                                                >*</span
                                            >
                                        </label>
                                    </div>

                                    <!-- For lecturer-specific questions -->
                                    <div
                                        v-if="
                                            question.is_for_lecturer &&
                                            question.input_type === 'radio'
                                        "
                                    >
                                        <!-- Lecturer 1 Rating -->
                                        <div
                                            class="lecturer-evaluation mb-3 p-3 bg-white border rounded"
                                        >
                                            <h6 class="text-success mb-3">
                                                <i
                                                    class="bi bi-person me-2"
                                                ></i>
                                                Evaluasi untuk
                                                {{
                                                    getLecturerName(
                                                        form.lecturer_1_id
                                                    )
                                                }}
                                            </h6>
                                            <div class="row g-2">
                                                <div
                                                    v-for="option in questionnaire.scale_options"
                                                    :key="`${question.id}_${form.lecturer_1_id}_${option.value}`"
                                                    class="col-6 col-sm-3"
                                                >
                                                    <div
                                                        class="form-check text-center"
                                                    >
                                                        <input
                                                            v-model="
                                                                form.answers[
                                                                    question.id
                                                                ][
                                                                    form
                                                                        .lecturer_1_id
                                                                ]
                                                            "
                                                            :value="
                                                                option.value
                                                            "
                                                            :id="`q${question.id}_l1_${option.value}`"
                                                            type="radio"
                                                            class="form-check-input"
                                                            :name="`question_${question.id}_lecturer_${form.lecturer_1_id}`"
                                                        />
                                                        <label
                                                            :for="`q${question.id}_l1_${option.value}`"
                                                            class="form-check-label d-block small"
                                                        >
                                                            <strong>{{
                                                                option.value
                                                            }}</strong
                                                            ><br />
                                                            <span
                                                                class="text-muted"
                                                                >{{
                                                                    option.label
                                                                }}</span
                                                            >
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Lecturer 2 Rating (if applicable) -->
                                        <div
                                            v-if="
                                                form.lecturer_count == 2 &&
                                                form.lecturer_2_id
                                            "
                                            class="lecturer-evaluation p-3 bg-white border rounded"
                                        >
                                            <h6 class="text-info mb-3">
                                                <i
                                                    class="bi bi-person me-2"
                                                ></i>
                                                Evaluasi untuk
                                                {{
                                                    getLecturerName(
                                                        form.lecturer_2_id
                                                    )
                                                }}
                                            </h6>
                                            <div class="row g-2">
                                                <div
                                                    v-for="option in questionnaire.scale_options"
                                                    :key="`${question.id}_${form.lecturer_2_id}_${option.value}`"
                                                    class="col-6 col-sm-3"
                                                >
                                                    <div
                                                        class="form-check text-center"
                                                    >
                                                        <input
                                                            v-model="
                                                                form.answers[
                                                                    question.id
                                                                ][
                                                                    form
                                                                        .lecturer_2_id
                                                                ]
                                                            "
                                                            :value="
                                                                option.value
                                                            "
                                                            :id="`q${question.id}_l2_${option.value}`"
                                                            type="radio"
                                                            class="form-check-input"
                                                            :name="`question_${question.id}_lecturer_${form.lecturer_2_id}`"
                                                        />
                                                        <label
                                                            :for="`q${question.id}_l2_${option.value}`"
                                                            class="form-check-label d-block small"
                                                        >
                                                            <strong>{{
                                                                option.value
                                                            }}</strong
                                                            ><br />
                                                            <span
                                                                class="text-muted"
                                                                >{{
                                                                    option.label
                                                                }}</span
                                                            >
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- For general questions (non-lecturer specific) -->
                                    <div
                                        v-else-if="
                                            !question.is_for_lecturer &&
                                            question.input_type === 'radio'
                                        "
                                    >
                                        <div class="row g-2">
                                            <div
                                                v-for="option in questionnaire.scale_options"
                                                :key="`${question.id}_${option.value}`"
                                                class="col-6 col-sm-3"
                                            >
                                                <div
                                                    class="form-check text-center"
                                                >
                                                    <input
                                                        v-model="
                                                            form.answers[
                                                                question.id
                                                            ]
                                                        "
                                                        :value="option.value"
                                                        :id="`q${question.id}_${option.value}`"
                                                        type="radio"
                                                        class="form-check-input"
                                                        :name="`question_${question.id}`"
                                                    />
                                                    <label
                                                        :for="`q${question.id}_${option.value}`"
                                                        class="form-check-label d-block small"
                                                    >
                                                        <strong>{{
                                                            option.value
                                                        }}</strong
                                                        ><br />
                                                        <span
                                                            class="text-muted"
                                                            >{{
                                                                option.label
                                                            }}</span
                                                        >
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- For textarea questions -->
                                    <div
                                        v-else-if="
                                            question.input_type === 'textarea'
                                        "
                                    >
                                        <div v-if="question.is_for_lecturer">
                                            <div class="mb-3">
                                                <label class="form-label small">
                                                    Saran untuk
                                                    {{
                                                        getLecturerName(
                                                            form.lecturer_1_id
                                                        )
                                                    }}
                                                </label>
                                                <textarea
                                                    v-model="
                                                        form.answers[
                                                            question.id
                                                        ][form.lecturer_1_id]
                                                    "
                                                    class="form-control"
                                                    rows="3"
                                                    :placeholder="`Berikan saran untuk ${getLecturerName(
                                                        form.lecturer_1_id
                                                    )}`"
                                                ></textarea>
                                            </div>
                                            <div
                                                v-if="form.lecturer_count == 2"
                                            >
                                                <label class="form-label small">
                                                    Saran untuk
                                                    {{
                                                        getLecturerName(
                                                            form.lecturer_2_id
                                                        )
                                                    }}
                                                </label>
                                                <textarea
                                                    v-model="
                                                        form.answers[
                                                            question.id
                                                        ][form.lecturer_2_id]
                                                    "
                                                    class="form-control"
                                                    rows="3"
                                                    :placeholder="`Berikan saran untuk ${getLecturerName(
                                                        form.lecturer_2_id
                                                    )}`"
                                                ></textarea>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <textarea
                                                v-model="
                                                    form.answers[question.id]
                                                "
                                                class="form-control"
                                                rows="3"
                                                :placeholder="'Masukkan jawaban Anda'"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div v-if="shouldShowQuestions" class="text-center">
                        <button
                            type="submit"
                            class="btn btn-primary btn-lg px-5"
                            :disabled="isSubmitting || !canSubmit"
                        >
                            <span
                                v-if="isSubmitting"
                                class="spinner-border spinner-border-sm me-2"
                            ></span>
                            <i v-else class="bi bi-send me-2"></i>
                            {{
                                isSubmitting ? "Mengirim..." : "Kirim Evaluasi"
                            }}
                        </button>

                        <div class="mt-3">
                            <Link
                                :href="route('evaluation.index')"
                                class="btn btn-outline-secondary"
                            >
                                <i class="bi bi-arrow-left me-2"></i>
                                Kembali
                            </Link>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";

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
    errors: {
        type: Object,
        default: () => ({}),
    },
});

// Reactive data
const isSubmitting = ref(false);
const studentVerification = ref({
    status: false,
    valid: false,
    message: "",
});
const studentData = ref(null);

const form = reactive({
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

// Computed properties
const availableLecturers2 = computed(() => {
    return props.lecturers.filter(
        (lecturer) => lecturer.id != form.lecturer_1_id
    );
});

const shouldShowQuestions = computed(() => {
    return (
        studentVerification.value.valid &&
        form.lecturer_1_id &&
        form.attendance_lecturer_1 &&
        (form.lecturer_count == 1 ||
            (form.lecturer_2_id && form.attendance_lecturer_2))
    );
});

const canSubmit = computed(() => {
    return (
        studentVerification.value.valid &&
        shouldShowQuestions.value &&
        Object.keys(form.answers).length > 0
    );
});

const isStudentSemesterFixed = computed(() => {
    return studentVerification.value.valid && studentData.value?.semester;
});

// Methods
const initializeAnswers = () => {
    props.questionnaire.categories?.forEach((category) => {
        category.questions?.forEach((question) => {
            if (question.is_for_lecturer) {
                form.answers[question.id] = {};
            } else {
                form.answers[question.id] = "";
            }
        });
    });
};

const getLecturerName = (lecturerId) => {
    const lecturer = props.lecturers.find((l) => l.id == lecturerId);
    return lecturer ? lecturer.name : "";
};

const checkStudent = async () => {
    if (!form.student_nim || !form.student_email) return;

    // Reset previous state
    studentVerification.value = { status: false, valid: false, message: "" };
    studentData.value = null;

    try {
        const token = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        const response = await axios.post(
            "/evaluation/check-student",
            {
                nim: form.student_nim,
                email: form.student_email,
            },
            {
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Content-Type": "application/json",
                },
            }
        );

        studentData.value = response.data.student;

        // Auto-fill semester if available
        if (studentData.value.semester) {
            form.semester_taken = studentData.value.semester;
        }

        studentVerification.value = {
            status: true,
            valid: true,
            message: "Data mahasiswa valid dan dapat mengisi kuesioner ini",
        };
    } catch (error) {
        console.error("Error checking student:", error);

        let message = "Tidak dapat memverifikasi data mahasiswa";

        if (error.response?.status === 422) {
            message =
                error.response.data.message ||
                "NIM dan email tidak terdaftar atau tidak cocok";
        } else if (error.response?.status === 500) {
            message = "Terjadi kesalahan server, silakan coba lagi";
        } else if (error.code === "ERR_NETWORK") {
            message = "Tidak dapat terhubung ke server";
        }

        studentVerification.value = {
            status: true,
            valid: false,
            message: message,
        };
        studentData.value = null;
    }
};

const submitForm = () => {
    isSubmitting.value = true;

    router.post(route("evaluation.store", props.questionnaire.id), form, {
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};

// Watchers
watch(
    () => form.lecturer_count,
    () => {
        if (form.lecturer_count == 1) {
            form.lecturer_2_id = "";
            form.attendance_lecturer_2 = "";
            form.suggestion_lecturer_2 = "";
        }
    }
);

// Initialize
onMounted(() => {
    initializeAnswers();
    console.log("Questionnaire data:", props.questionnaire);
    console.log("Categories:", props.questionnaire.categories);
    console.log("Scale options:", props.questionnaire.scale_options);
    console.log("Lecturers:", props.lecturers);
});
</script>

<style scoped>
.page-title {
    min-height: 300px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    position: relative;
}

.page-title::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
}

.page-title .container {
    z-index: 1;
}

.page-title h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
}

.page-title p {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
}

.breadcrumbs ol {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
}

.breadcrumbs li {
    margin-right: 0.5rem;
}

.breadcrumbs li:not(:last-child)::after {
    content: "/";
    margin-left: 0.5rem;
    color: rgba(255, 255, 255, 0.7);
}

.breadcrumbs a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumbs a:hover {
    color: white;
}

.breadcrumbs .current {
    color: white;
    font-weight: 500;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}

.question-block {
    transition: all 0.2s ease-in-out;
}

.question-block:hover {
    border-color: #0d6efd !important;
}

.lecturer-evaluation {
    transition: box-shadow 0.2s ease-in-out;
}

.lecturer-evaluation:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.category-header {
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
    padding: 1rem 0;
    margin: -1rem 0 1rem 0;
}
</style>
