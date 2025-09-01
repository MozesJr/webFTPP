<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Buat Kuesioner EDOM
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat kuesioner evaluasi dosen oleh mahasiswa
                        </p>
                    </div>
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
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
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
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Skala Penilaian
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Tentukan opsi skala penilaian untuk kuesioner
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

            <!-- Categories and Questions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Kategori & Pertanyaan
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Buat kategori dan pertanyaan untuk kuesioner
                            </p>
                        </div>
                        <button
                            @click="useDefaultTemplate"
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <DocumentTextIcon class="h-4 w-4 mr-2" />
                            Gunakan Template Default
                        </button>
                    </div>
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

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <Link
                    href="/admin/edom/questionnaire"
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
                    <span v-else>Simpan Kuesioner</span>
                </button>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    PlusIcon,
    TrashIcon,
    DocumentTextIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    programStudis: {
        type: Array,
        default: () => [],
    },
    currentYear: {
        type: Number,
        default: new Date().getFullYear(),
    },
    defaultCategories: {
        type: Array,
        default: () => [],
    },
    defaultScaleOptions: {
        type: Array,
        default: () => [],
    },
});

// Form data
const form = useForm({
    title: "",
    description: "",
    prodi_id: "",
    semester: "",
    academic_year: `${props.currentYear}/${props.currentYear + 1}`,
    is_active: true,
    start_date: "",
    end_date: "",
    categories: [
        {
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
        },
    ],
    scale_options:
        props.defaultScaleOptions.length > 0
            ? [...props.defaultScaleOptions]
            : [
                  { value: 1, label: "Tidak Memuaskan" },
                  { value: 2, label: "Cukup Memuaskan" },
                  { value: 3, label: "Memuaskan" },
                  { value: 4, label: "Sangat Memuaskan" },
              ],
});

const processing = ref(false);
const errors = ref({});

// Methods
const submitForm = () => {
    processing.value = true;
    errors.value = {};

    form.post("/admin/edom/questionnaire", {
        onSuccess: () => {
            processing.value = false;
        },
        onError: (formErrors) => {
            processing.value = false;
            errors.value = formErrors;
        },
    });
};

const useDefaultTemplate = () => {
    if (props.defaultCategories.length > 0) {
        form.categories = JSON.parse(JSON.stringify(props.defaultCategories));
    }
};

const addCategory = () => {
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
};

const removeCategory = (index) => {
    if (form.categories.length > 1) {
        form.categories.splice(index, 1);
    }
};

const addQuestion = (categoryIndex) => {
    form.categories[categoryIndex].questions.push({
        question_text: "",
        input_type: "radio",
        is_required: true,
        is_for_lecturer: true,
    });
};

const removeQuestion = (categoryIndex, questionIndex) => {
    if (form.categories[categoryIndex].questions.length > 1) {
        form.categories[categoryIndex].questions.splice(questionIndex, 1);
    }
};

const addScaleOption = () => {
    const newValue =
        form.scale_options.length > 0
            ? Math.max(...form.scale_options.map((o) => o.value)) + 1
            : 1;

    form.scale_options.push({
        value: newValue,
        label: "",
    });
};

const removeScaleOption = (index) => {
    if (form.scale_options.length > 2) {
        form.scale_options.splice(index, 1);
    }
};
</script>
