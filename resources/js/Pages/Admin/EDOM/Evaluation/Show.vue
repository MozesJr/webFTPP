<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Evaluasi EDOM
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Hasil evaluasi dosen oleh mahasiswa
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="route('admin.edom.evaluation.index')"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student & Questionnaire Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Student Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Informasi Mahasiswa
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >Nama</label
                        >
                        <p class="text-sm text-gray-900 mt-1">
                            {{ evaluation.student_name || "N/A" }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >NIM</label
                        >
                        <p class="text-sm text-gray-900 mt-1">
                            {{ evaluation.student_nim }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >Email</label
                        >
                        <p class="text-sm text-gray-900 mt-1">
                            {{ evaluation.student_email }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >Semester Diambil</label
                        >
                        <p class="text-sm text-gray-900 mt-1">
                            Semester {{ evaluation.semester_taken }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >Tanggal Submit</label
                        >
                        <p class="text-sm text-gray-900 mt-1">
                            {{ formatDateTime(evaluation.submitted_at) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Questionnaire Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Informasi Kuesioner
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >Judul Kuesioner</label
                        >
                        <p class="text-sm text-gray-900 mt-1">
                            {{ evaluation.questionnaire?.title }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >Program Studi</label
                        >
                        <p class="text-sm text-gray-900 mt-1">
                            {{ evaluation.questionnaire?.program_studi?.name }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >Periode</label
                        >
                        <p class="text-sm text-gray-900 mt-1">
                            {{ evaluation.questionnaire?.semester }}
                            {{ evaluation.questionnaire?.academic_year }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700"
                            >Status</label
                        >
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1"
                        >
                            Completed
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lecturers Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Informasi Dosen
                </h3>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Lecturer 1 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-3">Dosen 1</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-700"
                                    >Nama</label
                                >
                                <p class="text-sm text-gray-900 mt-1">
                                    {{ evaluation.lecturer1?.name || "N/A" }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700"
                                    >Email</label
                                >
                                <p class="text-sm text-gray-900 mt-1">
                                    {{ evaluation.lecturer1?.email || "N/A" }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700"
                                    >Kehadiran</label
                                >
                                <p class="text-sm text-gray-900 mt-1">
                                    {{
                                        evaluation.attendance_lecturer_1 ||
                                        "N/A"
                                    }}
                                </p>
                            </div>
                            <div v-if="evaluation.suggestion_lecturer_1">
                                <label class="text-sm font-medium text-gray-700"
                                    >Saran</label
                                >
                                <p
                                    class="text-sm text-gray-900 mt-1 p-3 bg-gray-50 rounded-md"
                                >
                                    {{ evaluation.suggestion_lecturer_1 }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Lecturer 2 -->
                    <div
                        v-if="evaluation.lecturer_count === 2"
                        class="border border-gray-200 rounded-lg p-4"
                    >
                        <h4 class="font-medium text-gray-900 mb-3">Dosen 2</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-700"
                                    >Nama</label
                                >
                                <p class="text-sm text-gray-900 mt-1">
                                    {{ evaluation.lecturer2?.name || "N/A" }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700"
                                    >Email</label
                                >
                                <p class="text-sm text-gray-900 mt-1">
                                    {{ evaluation.lecturer2?.email || "N/A" }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700"
                                    >Kehadiran</label
                                >
                                <p class="text-sm text-gray-900 mt-1">
                                    {{
                                        evaluation.attendance_lecturer_2 ||
                                        "N/A"
                                    }}
                                </p>
                            </div>
                            <div v-if="evaluation.suggestion_lecturer_2">
                                <label class="text-sm font-medium text-gray-700"
                                    >Saran</label
                                >
                                <p
                                    class="text-sm text-gray-900 mt-1 p-3 bg-gray-50 rounded-md"
                                >
                                    {{ evaluation.suggestion_lecturer_2 }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Suggestion -->
        <div
            v-if="evaluation.general_suggestion"
            class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6"
        >
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Saran Umum</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-sm text-gray-900 p-4 bg-gray-50 rounded-lg">
                    {{ evaluation.general_suggestion }}
                </p>
            </div>
        </div>

        <!-- Evaluation Answers by Category -->
        <div class="space-y-6">
            <div
                v-for="(categoryAnswers, categoryName) in groupedAnswers"
                :key="categoryName"
                class="bg-white rounded-lg shadow-sm border border-gray-200"
            >
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ categoryName }}
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <!-- General Questions -->
                    <div v-if="categoryAnswers.general" class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-4">
                            Pertanyaan Umum
                        </h4>
                        <div class="space-y-4">
                            <div
                                v-for="(item, index) in categoryAnswers.general"
                                :key="`general-${index}`"
                                class="border border-gray-200 rounded-lg p-4"
                            >
                                <div class="mb-3">
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ item.question.question_text }}
                                    </p>
                                    <p
                                        v-if="item.question.description"
                                        class="text-xs text-gray-500 mt-1"
                                    >
                                        {{ item.question.description }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-900">
                                        <span
                                            v-if="
                                                item.question.input_type ===
                                                'radio'
                                            "
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2"
                                        >
                                            Skor:
                                            {{
                                                item.answer?.answer_value ||
                                                "N/A"
                                            }}
                                        </span>
                                        {{
                                            getAnswerDisplay(
                                                item.answer,
                                                item.question
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lecturer 1 Questions -->
                    <div v-if="categoryAnswers.lecturer_1" class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-4">
                            Evaluasi untuk {{ evaluation.lecturer1?.name }}
                        </h4>
                        <div class="space-y-4">
                            <div
                                v-for="(
                                    item, index
                                ) in categoryAnswers.lecturer_1"
                                :key="`lecturer1-${index}`"
                                class="border border-gray-200 rounded-lg p-4"
                            >
                                <div class="mb-3">
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ item.question.question_text }}
                                    </p>
                                    <p
                                        v-if="item.question.description"
                                        class="text-xs text-gray-500 mt-1"
                                    >
                                        {{ item.question.description }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-900">
                                        <span
                                            v-if="
                                                item.question.input_type ===
                                                'radio'
                                            "
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2"
                                        >
                                            Skor:
                                            {{
                                                item.answer?.answer_value ||
                                                "N/A"
                                            }}
                                        </span>
                                        {{
                                            getAnswerDisplay(
                                                item.answer,
                                                item.question
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lecturer 2 Questions -->
                    <div
                        v-if="
                            categoryAnswers.lecturer_2 &&
                            evaluation.lecturer_count === 2
                        "
                    >
                        <h4 class="font-medium text-gray-900 mb-4">
                            Evaluasi untuk {{ evaluation.lecturer2?.name }}
                        </h4>
                        <div class="space-y-4">
                            <div
                                v-for="(
                                    item, index
                                ) in categoryAnswers.lecturer_2"
                                :key="`lecturer2-${index}`"
                                class="border border-gray-200 rounded-lg p-4"
                            >
                                <div class="mb-3">
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ item.question.question_text }}
                                    </p>
                                    <p
                                        v-if="item.question.description"
                                        class="text-xs text-gray-500 mt-1"
                                    >
                                        {{ item.question.description }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-900">
                                        <span
                                            v-if="
                                                item.question.input_type ===
                                                'radio'
                                            "
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2"
                                        >
                                            Skor:
                                            {{
                                                item.answer?.answer_value ||
                                                "N/A"
                                            }}
                                        </span>
                                        {{
                                            getAnswerDisplay(
                                                item.answer,
                                                item.question
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    evaluation: {
        type: Object,
        required: true,
    },
    groupedAnswers: {
        type: Object,
        default: () => ({}),
    },
});

// Methods
const formatDateTime = (datetime) => {
    return new Date(datetime).toLocaleString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const getAnswerDisplay = (answer, question) => {
    if (!answer) return "Tidak dijawab";

    switch (question.input_type) {
        case "radio":
            return `Skor ${answer.answer_value} dari 5`;
        case "textarea":
            return answer.answer_value || "Tidak ada jawaban";
        case "text":
            return answer.answer_value || "Tidak diisi";
        case "select":
            return answer.answer_value || "Tidak dipilih";
        default:
            return answer.answer_value || "N/A";
    }
};
</script>
