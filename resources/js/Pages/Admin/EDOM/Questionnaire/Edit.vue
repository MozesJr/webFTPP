<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Kuesioner EDOM
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Edit kuesioner evaluasi dosen oleh mahasiswa
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            :href="`/admin/edom/questionnaire/${questionnaire.id}`"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <EyeIcon class="w-4 h-4 mr-2" />
                            Lihat Detail
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

        <!-- Warning if has responses -->
        <div
            v-if="hasResponses"
            class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6"
        >
            <div class="flex">
                <ExclamationTriangleIcon
                    class="h-5 w-5 text-yellow-400 mt-0.5"
                />
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Peringatan: Kuesioner Memiliki Respons
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>
                            Kuesioner ini sudah memiliki
                            {{ responseCount }} respons. Perubahan struktur
                            pertanyaan tidak disarankan karena dapat
                            mempengaruhi validitas data.
                        </p>
                        <p class="mt-1">
                            Anda hanya dapat mengubah informasi dasar seperti
                            judul, deskripsi, dan periode.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form @submit.prevent="submitForm" class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Informasi Dasar
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Judul Kuesioner *
                            </label>
                            <input
                                v-model="form.title"
                                type="text"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                :class="{ 'border-red-300': errors.title }"
                                placeholder="Contoh: EDOM Semester Ganjil 2024/2025"
                            />
                            <p
                                v-if="errors.title"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.title }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Program Studi *
                            </label>
                            <select
                                v-model="form.prodi_id"
                                required
                                :disabled="hasResponses"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                                :class="{ 'border-red-300': errors.prodi_id }"
                            >
                                <option value="">Pilih Program Studi</option>
                                <option
                                    v-for="prodi in programStudis"
                                    :key="prodi.id"
                                    :value="prodi.id"
                                >
                                    {{ prodi.name }}
                                </option>
                            </select>
                            <p
                                v-if="errors.prodi_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.prodi_id }}
                            </p>
                            <p
                                v-if="hasResponses"
                                class="mt-1 text-xs text-gray-500"
                            >
                                Tidak dapat diubah karena sudah ada respons
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Semester *
                            </label>
                            <select
                                v-model="form.semester"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                :class="{ 'border-red-300': errors.semester }"
                            >
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil">Semester Ganjil</option>
                                <option value="Genap">Semester Genap</option>
                                <option value="Pendek">Semester Pendek</option>
                            </select>
                            <p
                                v-if="errors.semester"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.semester }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Tahun Akademik *
                            </label>
                            <input
                                v-model="form.academic_year"
                                type="text"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                :class="{
                                    'border-red-300': errors.academic_year,
                                }"
                                placeholder="2024/2025"
                            />
                            <p
                                v-if="errors.academic_year"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.academic_year }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Status
                            </label>
                            <select
                                v-model="form.is_active"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option :value="true">Aktif</option>
                                <option :value="false">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Tanggal Mulai
                            </label>
                            <input
                                v-model="form.start_date"
                                type="date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                :class="{ 'border-red-300': errors.start_date }"
                            />
                            <p
                                v-if="errors.start_date"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.start_date }}
                            </p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Tanggal Berakhir
                            </label>
                            <input
                                v-model="form.end_date"
                                type="date"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                :class="{ 'border-red-300': errors.end_date }"
                            />
                            <p
                                v-if="errors.end_date"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.end_date }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Deskripsi
                        </label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            :class="{ 'border-red-300': errors.description }"
                            placeholder="Deskripsi singkat tentang kuesioner ini..."
                        ></textarea>
                        <p
                            v-if="errors.description"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Scale Options -->
            <div
                v-if="!hasResponses"
                class="bg-white rounded-lg shadow-sm border border-gray-200"
            >
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Skala Penilaian
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Edit opsi skala penilaian untuk kuesioner
                    </p>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        <div
                            v-for="(option, index) in form.scale_options"
                            :key="index"
                            class="flex items-center space-x-3"
                        >
                            <div class="w-20">
                                <input
                                    v-model.number="option.value"
                                    type="number"
                                    min="1"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Nilai"
                                />
                            </div>
                            <div class="flex-1">
                                <input
                                    v-model="option.label"
                                    type="text"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Label skala"
                                />
                            </div>
                            <button
                                v-if="form.scale_options.length > 2"
                                @click="removeScaleOption(index)"
                                type="button"
                                class="p-2 text-red-600 hover:text-red-800"
                            >
                                <TrashIcon class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button
                            @click="addScaleOption"
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <PlusIcon class="h-4 w-4 mr-2" />
                            Tambah Opsi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Scale Options (Read Only) -->
            <div
                v-else
                class="bg-white rounded-lg shadow-sm border border-gray-200"
            >
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Skala Penilaian
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Skala penilaian tidak dapat diubah karena sudah ada
                        respons
                    </p>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div
                            v-for="option in questionnaire.scale_options"
                            :key="option.id"
                            class="text-center p-3 border border-gray-200 rounded-md bg-gray-50"
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
                v-if="!hasResponses"
                class="bg-white rounded-lg shadow-sm border border-gray-200"
            >
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Kategori & Pertanyaan
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Edit kategori dan pertanyaan untuk kuesioner
                    </p>
                </div>

                <div class="px-6 py-4 space-y-6">
                    <div
                        v-for="(category, categoryIndex) in form.categories"
                        :key="categoryIndex"
                        class="border border-gray-200 rounded-lg p-4"
                    >
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1 space-y-3">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Nama Kategori *
                                    </label>
                                    <input
                                        v-model="category.name"
                                        type="text"
                                        required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Contoh: A. Penilaian Dosen"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Deskripsi Kategori
                                    </label>
                                    <input
                                        v-model="category.description"
                                        type="text"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Deskripsi singkat kategori..."
                                    />
                                </div>
                            </div>
                            <button
                                v-if="form.categories.length > 1"
                                @click="removeCategory(categoryIndex)"
                                type="button"
                                class="ml-4 p-2 text-red-600 hover:text-red-800"
                            >
                                <TrashIcon class="h-5 w-5" />
                            </button>
                        </div>

                        <!-- Questions for this category -->
                        <div class="space-y-3">
                            <h4 class="text-sm font-medium text-gray-900">
                                Pertanyaan
                            </h4>
                            <div
                                v-for="(
                                    question, questionIndex
                                ) in category.questions"
                                :key="questionIndex"
                                class="bg-gray-50 p-3 rounded-md"
                            >
                                <div class="flex items-start space-x-3">
                                    <div class="flex-1">
                                        <input
                                            v-model="question.question_text"
                                            type="text"
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Masukkan pertanyaan..."
                                        />
                                    </div>
                                    <div class="w-32">
                                        <select
                                            v-model="question.input_type"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        >
                                            <option value="radio">
                                                Rating
                                            </option>
                                            <option value="textarea">
                                                Text
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <label class="flex items-center">
                                            <input
                                                v-model="question.is_required"
                                                type="checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            />
                                            <span
                                                class="ml-1 text-xs text-gray-600"
                                                >Wajib</span
                                            >
                                        </label>
                                        <label class="flex items-center">
                                            <input
                                                v-model="
                                                    question.is_for_lecturer
                                                "
                                                type="checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            />
                                            <span
                                                class="ml-1 text-xs text-gray-600"
                                                >Per Dosen</span
                                            >
                                        </label>
                                    </div>
                                    <button
                                        v-if="category.questions.length > 1"
                                        @click="
                                            removeQuestion(
                                                categoryIndex,
                                                questionIndex
                                            )
                                        "
                                        type="button"
                                        class="p-2 text-red-600 hover:text-red-800"
                                    >
                                        <TrashIcon class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                            <button
                                @click="addQuestion(categoryIndex)"
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PlusIcon class="h-4 w-4 mr-2" />
                                Tambah Pertanyaan
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button
                            @click="addCategory"
                            type="button"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <PlusIcon class="h-5 w-5 mr-2" />
                            Tambah Kategori
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories and Questions (Read Only) -->
            <div
                v-else
                class="bg-white rounded-lg shadow-sm border border-gray-200"
            >
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Kategori & Pertanyaan
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Pertanyaan tidak dapat diubah karena sudah ada respons
                    </p>
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
                                v-for="(question, index) in category.questions"
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
                                                question.input_type === "radio"
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

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <Link
                    :href="`/admin/edom/questionnaire/${questionnaire.id}`"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Batal
                </Link>
                <button
                    type="submit"
                    :disabled="processing"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span v-if="processing">Menyimpan...</span>
                    <span v-else>Update Kuesioner</span>
                </button>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    EyeIcon,
    PlusIcon,
    TrashIcon,
    ExclamationTriangleIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    questionnaire: {
        type: Object,
        required: true,
    },
    programStudis: {
        type: Array,
        default: () => [],
    },
});

// Computed
const hasResponses = computed(() => {
    return (
        props.questionnaire.evaluations &&
        props.questionnaire.evaluations.length > 0
    );
});

const responseCount = computed(() => {
    return props.questionnaire.evaluations
        ? props.questionnaire.evaluations.length
        : 0;
});

// Form data
const form = useForm({
    title: props.questionnaire.title,
    description: props.questionnaire.description,
    prodi_id: props.questionnaire.prodi_id,
    semester: props.questionnaire.semester,
    academic_year: props.questionnaire.academic_year,
    is_active: props.questionnaire.is_active,
    start_date: props.questionnaire.start_date,
    end_date: props.questionnaire.end_date,
    categories: hasResponses.value
        ? []
        : (props.questionnaire.categories || []).map((cat) => ({
              id: cat.id,
              name: cat.name,
              description: cat.description,
              questions: (cat.questions || []).map((q) => ({
                  id: q.id,
                  question_text: q.question_text,
                  input_type: q.input_type,
                  is_required: q.is_required,
                  is_for_lecturer: q.is_for_lecturer,
              })),
          })),
    scale_options: hasResponses.value
        ? []
        : (props.questionnaire.scale_options || []).map((opt) => ({
              id: opt.id,
              value: opt.value,
              label: opt.label,
          })),
});

const processing = ref(false);
const errors = ref({});

// Methods
const submitForm = () => {
    processing.value = true;
    errors.value = {};

    const submitData = {
        title: form.title,
        description: form.description,
        prodi_id: form.prodi_id,
        semester: form.semester,
        academic_year: form.academic_year,
        is_active: form.is_active,
        start_date: form.start_date,
        end_date: form.end_date,
    };

    // Only include categories and scale_options if no responses
    if (!hasResponses.value) {
        submitData.categories = form.categories;
        submitData.scale_options = form.scale_options;
    }

    form.put(`/admin/edom/questionnaire/${props.questionnaire.id}`, {
        data: submitData,
        onSuccess: () => {
            processing.value = false;
        },
        onError: (formErrors) => {
            processing.value = false;
            errors.value = formErrors;
        },
    });
};

const addCategory = () => {
    if (!hasResponses.value) {
        form.categories.push({
            name: "",
            description: "",
            questions: [
                {
                    question_text: "",
                    input_type: "radio",
                    is_required: true,
                    is_for_lecturer: true,
                },
            ],
        });
    }
};

const removeCategory = (index) => {
    if (!hasResponses.value && form.categories.length > 1) {
        form.categories.splice(index, 1);
    }
};

const addQuestion = (categoryIndex) => {
    if (!hasResponses.value) {
        form.categories[categoryIndex].questions.push({
            question_text: "",
            input_type: "radio",
            is_required: true,
            is_for_lecturer: true,
        });
    }
};

const removeQuestion = (categoryIndex, questionIndex) => {
    if (
        !hasResponses.value &&
        form.categories[categoryIndex].questions.length > 1
    ) {
        form.categories[categoryIndex].questions.splice(questionIndex, 1);
    }
};

const addScaleOption = () => {
    if (!hasResponses.value) {
        const newValue =
            form.scale_options.length > 0
                ? Math.max(...form.scale_options.map((o) => o.value)) + 1
                : 1;

        form.scale_options.push({
            value: newValue,
            label: "",
        });
    }
};

const removeScaleOption = (index) => {
    if (!hasResponses.value && form.scale_options.length > 2) {
        form.scale_options.splice(index, 1);
    }
};
</script>
