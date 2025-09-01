<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Kuesioner
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi lengkap dan statistik kuesioner EDOM
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="`/admin/edom/questionnaire/${questionnaire.id}/edit`"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit
                        </Link>
                        <Link
                            href="/admin/edom/questionnaire"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Informasi Kuesioner
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl
                            class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2"
                        >
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Judul
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ questionnaire.title }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Program Studi
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ questionnaire.program_studi?.name }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Semester
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ questionnaire.semester }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Tahun Akademik
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ questionnaire.academic_year }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Periode
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span
                                        v-if="
                                            questionnaire.start_date &&
                                            questionnaire.end_date
                                        "
                                    >
                                        {{
                                            formatDate(questionnaire.start_date)
                                        }}
                                        -
                                        {{ formatDate(questionnaire.end_date) }}
                                    </span>
                                    <span v-else class="text-gray-400"
                                        >Tidak dibatasi</span
                                    >
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Status
                                </dt>
                                <dd class="mt-1">
                                    <span
                                        :class="[
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            questionnaire.is_active
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800',
                                        ]"
                                    >
                                        {{
                                            questionnaire.is_active
                                                ? "Aktif"
                                                : "Tidak Aktif"
                                        }}
                                    </span>
                                </dd>
                            </div>
                            <div
                                v-if="questionnaire.description"
                                class="sm:col-span-2"
                            >
                                <dt class="text-sm font-medium text-gray-500">
                                    Deskripsi
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ questionnaire.description }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Scale Options -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Skala Penilaian
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div
                                v-for="option in questionnaire.scale_options"
                                :key="option.id"
                                class="text-center p-3 border border-gray-200 rounded-md"
                            >
                                <div class="text-lg font-bold text-gray-700">
                                    {{ option.value }}
                                </div>
                                <div class="text-xs text-gray-600 mt-1">
                                    {{ option.label }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories and Questions -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Kategori & Pertanyaan
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div
                            v-for="category in questionnaire.categories"
                            :key="category.id"
                            class="px-6 py-4"
                        >
                            <div class="mb-3">
                                <h4 class="text-md font-medium text-gray-900">
                                    {{ category.name }}
                                </h4>
                                <p
                                    v-if="category.description"
                                    class="text-sm text-gray-600 mt-1"
                                >
                                    {{ category.description }}
                                </p>
                            </div>

                            <div class="space-y-2">
                                <div
                                    v-for="(
                                        question, index
                                    ) in category.questions"
                                    :key="question.id"
                                    class="flex items-start space-x-3 py-2 px-3 bg-gray-50 rounded-md"
                                >
                                    <span
                                        class="text-sm text-gray-500 font-medium mt-0.5"
                                        >{{ index + 1 }}.</span
                                    >
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900">
                                            {{ question.question_text }}
                                        </p>
                                        <div
                                            class="flex items-center space-x-4 mt-1"
                                        >
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"
                                            >
                                                {{
                                                    question.input_type ===
                                                    "radio"
                                                        ? "Rating"
                                                        : "Text"
                                                }}
                                            </span>
                                            <span
                                                v-if="question.is_required"
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800"
                                            >
                                                Wajib
                                            </span>
                                            <span
                                                v-if="question.is_for_lecturer"
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800"
                                            >
                                                Per Dosen
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistics -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Statistik
                        </h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-indigo-600">
                                {{ stats.total_submissions || 0 }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Total Responden
                            </div>
                        </div>

                        <div
                            v-if="
                                Object.keys(stats.by_semester || {}).length > 0
                            "
                            class="border-t border-gray-200 pt-4"
                        >
                            <h4 class="text-sm font-medium text-gray-900 mb-3">
                                Per Semester
                            </h4>
                            <div class="space-y-2">
                                <div
                                    v-for="(
                                        count, semester
                                    ) in stats.by_semester"
                                    :key="semester"
                                    class="flex justify-between text-sm"
                                >
                                    <span class="text-gray-600"
                                        >Semester {{ semester }}</span
                                    >
                                    <span class="font-medium">{{ count }}</span>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="
                                Object.keys(stats.by_lecturer_count || {})
                                    .length > 0
                            "
                            class="border-t border-gray-200 pt-4"
                        >
                            <h4 class="text-sm font-medium text-gray-900 mb-3">
                                Jumlah Dosen
                            </h4>
                            <div class="space-y-2">
                                <div
                                    v-for="(
                                        count, lecturerCount
                                    ) in stats.by_lecturer_count"
                                    :key="lecturerCount"
                                    class="flex justify-between text-sm"
                                >
                                    <span class="text-gray-600"
                                        >{{ lecturerCount }} Dosen</span
                                    >
                                    <span class="font-medium">{{ count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Submissions -->
                <div
                    v-if="stats.recent_submissions?.length > 0"
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Responden Terbaru
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-3">
                            <div
                                v-for="submission in stats.recent_submissions"
                                :key="submission.id"
                                class="flex items-center space-x-3"
                            >
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center"
                                    >
                                        <UserIcon
                                            class="h-5 w-5 text-gray-400"
                                        />
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-sm font-medium text-gray-900 truncate"
                                    >
                                        {{
                                            submission.student_name ||
                                            submission.student_nim
                                        }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{
                                            formatDateTime(
                                                submission.submitted_at
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Aksi</h3>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <Link
                            :href="`/admin/edom/evaluation?questionnaire_id=${questionnaire.id}`"
                            class="w-full inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <EyeIcon class="mr-2 h-4 w-4" />
                            Lihat Evaluasi
                        </Link>

                        <Link
                            :href="`/admin/edom/report?questionnaire_id=${questionnaire.id}`"
                            class="w-full inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <ChartBarIcon class="mr-2 h-4 w-4" />
                            Laporan
                        </Link>

                        <button
                            @click="toggleActive"
                            type="button"
                            class="w-full inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <component
                                :is="
                                    questionnaire.is_active
                                        ? PauseIcon
                                        : PlayIcon
                                "
                                class="mr-2 h-4 w-4"
                            />
                            {{
                                questionnaire.is_active
                                    ? "Nonaktifkan"
                                    : "Aktifkan"
                            }}
                        </button>

                        <button
                            @click="duplicate"
                            type="button"
                            class="w-full inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <DocumentDuplicateIcon class="mr-2 h-4 w-4" />
                            Duplikasi
                        </button>

                        <div
                            v-if="stats.total_submissions === 0"
                            class="pt-3 border-t border-gray-200"
                        >
                            <button
                                @click="deleteQuestionnaire"
                                type="button"
                                class="w-full inline-flex justify-center items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                <TrashIcon class="mr-2 h-4 w-4" />
                                Hapus Kuesioner
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import { onMounted } from "vue";
import {
    ArrowLeftIcon,
    PencilIcon,
    EyeIcon,
    ChartBarIcon,
    UserIcon,
    PauseIcon,
    PlayIcon,
    DocumentDuplicateIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    questionnaire: {
        type: Object,
        required: true,
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
});

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};

const formatDateTime = (datetime) => {
    return new Date(datetime).toLocaleString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const toggleActive = async () => {
    const action = props.questionnaire.is_active ? "nonaktifkan" : "aktifkan";
    const result = await confirmDelete(
        `${action.charAt(0).toUpperCase() + action.slice(1)} Kuesioner?`,
        `Kuesioner "${props.questionnaire.title}" akan di${action}.`
    );

    if (result.isConfirmed) {
        router.patch(
            `/admin/edom/questionnaire/${props.questionnaire.id}/toggle-active`,
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    success("Berhasil!", `Kuesioner berhasil di${action}.`);
                },
                onError: () => {
                    error(
                        "Error!",
                        `Terjadi kesalahan saat ${action} kuesioner.`
                    );
                },
            }
        );
    }
};

const duplicate = async () => {
    const result = await confirmDelete(
        "Duplikasi Kuesioner?",
        `Kuesioner "${props.questionnaire.title}" akan diduplikasi.`
    );

    if (result.isConfirmed) {
        router.post(
            `/admin/edom/questionnaire/${props.questionnaire.id}/duplicate`,
            {},
            {
                onSuccess: () => {
                    success("Berhasil!", "Kuesioner berhasil diduplikasi.");
                },
                onError: () => {
                    error(
                        "Error!",
                        "Terjadi kesalahan saat menduplikasi kuesioner."
                    );
                },
            }
        );
    }
};

const deleteQuestionnaire = async () => {
    const result = await confirmDelete(
        "Hapus Kuesioner?",
        `Kuesioner "${props.questionnaire.title}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/edom/questionnaire/${props.questionnaire.id}`, {
            onSuccess: () => {
                success("Berhasil!", "Kuesioner berhasil dihapus.");
            },
            onError: () => {
                error("Error!", "Terjadi kesalahan saat menghapus kuesioner.");
            },
        });
    }
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
