<script setup>
import { computed } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    survey: Object,
    questions: Array,
});

const getTargetLabel = (target) => {
    const labels = {
        mahasiswa: "Mahasiswa",
        dosen: "Dosen",
        alumni: "Alumni",
        stakeholder: "Stakeholder",
    };
    return labels[target] || target;
};

const getTargetColor = (target) => {
    const colors = {
        mahasiswa: "bg-blue-100 text-blue-800",
        dosen: "bg-green-100 text-green-800",
        alumni: "bg-purple-100 text-purple-800",
        stakeholder: "bg-orange-100 text-orange-800",
    };
    return colors[target] || "bg-gray-100 text-gray-800";
};

const getStatusInfo = (survey) => {
    if (survey.status === "running") {
        return {
            label: "Sedang Berjalan",
            color: "bg-green-100 text-green-800",
        };
    } else if (survey.status === "upcoming") {
        return { label: "Akan Datang", color: "bg-blue-100 text-blue-800" };
    } else if (survey.status === "completed") {
        return { label: "Selesai", color: "bg-gray-100 text-gray-800" };
    } else {
        return { label: "Tidak Aktif", color: "bg-red-100 text-red-800" };
    }
};

const getTypeLabel = (type) => {
    const labels = {
        text: "Text Pendek",
        textarea: "Text Panjang",
        rating: "Rating (1-5)",
        multiple_choice: "Pilihan Ganda",
        checkbox: "Checkbox",
        yes_no: "Ya/Tidak",
        scale: "Skala (1-10)",
        dropdown: "Dropdown",
    };
    return labels[type] || type;
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <a
                        :href="route('admin.gpm.survey.index')"
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

                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ survey.title }}
                            </h2>
                            <div class="mt-2 flex items-center gap-3">
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        getTargetColor(
                                            survey.target_respondent,
                                        ),
                                    ]"
                                >
                                    {{
                                        getTargetLabel(survey.target_respondent)
                                    }}
                                </span>
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        getStatusInfo(survey).color,
                                    ]"
                                >
                                    {{ getStatusInfo(survey).label }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <a
                                :href="
                                    route('admin.gpm.survey.results', survey.id)
                                "
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                            >
                                <svg
                                    class="-ml-1 mr-2 h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                    />
                                </svg>
                                Lihat Hasil
                            </a>
                            <a
                                :href="
                                    route('admin.gpm.survey.edit', survey.id)
                                "
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                            >
                                <svg
                                    class="-ml-1 mr-2 h-5 w-5"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                    />
                                </svg>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Description -->
                        <div
                            v-if="survey.description"
                            class="bg-white shadow rounded-lg p-6"
                        >
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Deskripsi
                            </h3>
                            <div class="prose max-w-none text-gray-700">
                                {{ survey.description }}
                            </div>
                        </div>

                        <!-- Questions List -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Daftar Pertanyaan
                                <span class="text-sm font-normal text-gray-500"
                                    >({{
                                        questions?.length || 0
                                    }}
                                    pertanyaan)</span
                                >
                            </h3>

                            <div v-if="questions?.length > 0" class="space-y-4">
                                <div
                                    v-for="(question, index) in questions"
                                    :key="question.id"
                                    class="p-4 bg-gray-50 border border-gray-200 rounded-lg"
                                >
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm font-medium"
                                        >
                                            {{ index + 1 }}
                                        </div>
                                        <div class="flex-1">
                                            <div
                                                class="text-sm font-medium text-gray-900"
                                            >
                                                {{ question.question_text }}
                                                <span
                                                    v-if="question.is_required"
                                                    class="text-red-500"
                                                    >*</span
                                                >
                                            </div>
                                            <div
                                                class="mt-2 flex items-center gap-3"
                                            >
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-200 text-gray-700"
                                                >
                                                    {{
                                                        getTypeLabel(
                                                            question.type,
                                                        )
                                                    }}
                                                </span>
                                                <span
                                                    v-if="question.is_required"
                                                    class="text-xs text-red-600"
                                                    >Wajib</span
                                                >
                                            </div>
                                            <div
                                                v-if="question.options"
                                                class="mt-2 text-sm text-gray-600"
                                            >
                                                <span class="font-medium"
                                                    >Opsi:</span
                                                >
                                                {{ question.options }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="text-center py-12 text-gray-500">
                                <svg
                                    class="mx-auto h-12 w-12 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                    />
                                </svg>
                                <p class="mt-2 text-sm">
                                    Belum ada pertanyaan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Survey Info -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Informasi Survey
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Target Responden
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{
                                            getTargetLabel(
                                                survey.target_respondent,
                                            )
                                        }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Periode
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ formatDate(survey.start_date) }}
                                        <br />
                                        s/d {{ formatDate(survey.end_date) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Jumlah Pertanyaan
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{
                                            survey.total_questions ||
                                            questions?.length
                                        }}
                                        pertanyaan
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Total Respons
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ survey.total_responses || 0 }}
                                        respons
                                    </dd>
                                </div>
                                <div v-if="survey.completion_percentage">
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Tingkat Pengisian
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ survey.completion_percentage }}%
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Metadata -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Metadata
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Dibuat oleh
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ survey.creator?.name || "System" }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Tanggal Dibuat
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ formatDate(survey.created_at) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-sm font-medium text-gray-500"
                                    >
                                        Terakhir Diupdate
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ formatDate(survey.updated_at) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white shadow rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Aksi Cepat
                            </h3>
                            <div class="space-y-2">
                                <a
                                    :href="
                                        route(
                                            'admin.gpm.survey.results',
                                            survey.id,
                                        )
                                    "
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <svg
                                        class="-ml-1 mr-2 h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                        />
                                    </svg>
                                    Lihat Hasil & Statistik
                                </a>
                                <a
                                    :href="
                                        route(
                                            'admin.gpm.survey.edit',
                                            survey.id,
                                        )
                                    "
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <svg
                                        class="-ml-1 mr-2 h-5 w-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                        />
                                    </svg>
                                    Edit Survey
                                </a>
                                <a
                                    :href="
                                        route(
                                            'admin.gpm.survey.export',
                                            survey.id,
                                        )
                                    "
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    <svg
                                        class="-ml-1 mr-2 h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                        />
                                    </svg>
                                    Export Hasil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
