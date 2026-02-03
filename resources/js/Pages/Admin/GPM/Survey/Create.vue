<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const form = useForm({
    title: "",
    description: "",
    target_respondent: "",
    start_date: "",
    end_date: "",
    is_active: false,
    questions: [],
});

// Question types
const questionTypes = [
    { value: "text", label: "Text Pendek" },
    { value: "textarea", label: "Text Panjang" },
    { value: "rating", label: "Rating (1-5)" },
    { value: "multiple_choice", label: "Pilihan Ganda" },
    { value: "checkbox", label: "Checkbox" },
    { value: "yes_no", label: "Ya/Tidak" },
    { value: "scale", label: "Skala (1-10)" },
    { value: "dropdown", label: "Dropdown" },
];

// New question template
const newQuestion = ref({
    type: "text",
    question_text: "",
    is_required: true,
    options: "",
});

// Add question to list
const addQuestion = () => {
    if (!newQuestion.value.question_text) return;

    // Convert string options (comma separated) to Array
    let processedOptions = null;
    if (needsOptions(newQuestion.value.type) && newQuestion.value.options) {
        processedOptions = newQuestion.value.options
            .split(",")
            .map((opt) => opt.trim())
            .filter((opt) => opt !== "");
    }

    const question = {
        question: newQuestion.value.question_text, // Sesuaikan dengan controller (question, bukan question_text)
        type: newQuestion.value.type,
        is_required: newQuestion.value.is_required,
        options: processedOptions, // Simpan sebagai array
        order: form.questions.length + 1,
    };

    form.questions.push(question);

    // Reset new question
    newQuestion.value = {
        type: "text",
        question_text: "",
        is_required: true,
        options: "",
    };
};

// Remove question
const removeQuestion = (index) => {
    form.questions.splice(index, 1);
    // Reorder
    form.questions.forEach((q, i) => {
        q.order = i + 1;
    });
};

// Move question up
const moveUp = (index) => {
    if (index === 0) return;
    const temp = form.questions[index];
    form.questions[index] = form.questions[index - 1];
    form.questions[index - 1] = temp;
    // Reorder
    form.questions.forEach((q, i) => {
        q.order = i + 1;
    });
};

// Move question down
const moveDown = (index) => {
    if (index === form.questions.length - 1) return;
    const temp = form.questions[index];
    form.questions[index] = form.questions[index + 1];
    form.questions[index + 1] = temp;
    // Reorder
    form.questions.forEach((q, i) => {
        q.order = i + 1;
    });
};

// Check if type needs options
const needsOptions = (type) => {
    return ["multiple_choice", "checkbox", "dropdown"].includes(type);
};

// Get question type label
const getTypeLabel = (type) => {
    return questionTypes.find((t) => t.value === type)?.label || type;
};

const submit = () => {
    form.post(route("admin.gpm.survey.store"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AdminLayout>
        <div class="py-6">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
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
                    <h2 class="text-2xl font-bold text-gray-900">
                        Buat Survey Baru
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Buat survey kepuasan untuk stakeholder
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Basic Info -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Informasi Survey
                        </h3>

                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Judul Survey
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    v-model="form.title"
                                    type="text"
                                    placeholder="Survey Kepuasan Mahasiswa 2024"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{
                                        'border-red-500': form.errors.title,
                                    }"
                                />
                                <p
                                    v-if="form.errors.title"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Deskripsi</label
                                >
                                <textarea
                                    v-model="form.description"
                                    rows="3"
                                    placeholder="Deskripsi singkat tentang survey ini..."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                ></textarea>
                            </div>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                                <!-- Target -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Target Responden
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        v-model="form.target_respondent"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        :class="{
                                            'border-red-500':
                                                form.errors.target_respondent,
                                        }"
                                    >
                                        <option value="">Pilih Target</option>
                                        <option value="mahasiswa">
                                            Mahasiswa
                                        </option>
                                        <option value="dosen">Dosen</option>
                                        <option value="alumni">Alumni</option>
                                        <option value="stakeholder">
                                            Stakeholder
                                        </option>
                                    </select>
                                    <p
                                        v-if="form.errors.target_respondent"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ form.errors.target_respondent }}
                                    </p>
                                </div>

                                <!-- Start Date -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Tanggal Mulai
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        v-model="form.start_date"
                                        type="date"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        :class="{
                                            'border-red-500':
                                                form.errors.start_date,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.start_date"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ form.errors.start_date }}
                                    </p>
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Tanggal Selesai
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        v-model="form.end_date"
                                        type="date"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        :class="{
                                            'border-red-500':
                                                form.errors.end_date,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.end_date"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ form.errors.end_date }}
                                    </p>
                                </div>
                            </div>

                            <!-- Is Active -->
                            <div>
                                <label class="flex items-center">
                                    <input
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                    <span class="ml-2 text-sm text-gray-700"
                                        >Aktifkan survey</span
                                    >
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Question Builder -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Pertanyaan Survey
                            <span class="text-sm font-normal text-gray-500"
                                >({{ form.questions.length }} pertanyaan)</span
                            >
                        </h3>

                        <!-- Add Question Form -->
                        <div
                            class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg"
                        >
                            <h4 class="text-sm font-medium text-blue-900 mb-3">
                                Tambah Pertanyaan
                            </h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-12">
                                <div class="sm:col-span-3">
                                    <select
                                        v-model="newQuestion.type"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                    >
                                        <option
                                            v-for="type in questionTypes"
                                            :key="type.value"
                                            :value="type.value"
                                        >
                                            {{ type.label }}
                                        </option>
                                    </select>
                                </div>
                                <div class="sm:col-span-7">
                                    <input
                                        v-model="newQuestion.question_text"
                                        type="text"
                                        placeholder="Tulis pertanyaan di sini..."
                                        @keyup.enter="addQuestion"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                    />
                                </div>
                                <div class="sm:col-span-2">
                                    <button
                                        @click="addQuestion"
                                        type="button"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700"
                                    >
                                        <svg
                                            class="-ml-1 mr-2 h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                        Tambah
                                    </button>
                                </div>
                            </div>

                            <!-- Options (if needed) -->
                            <div
                                v-if="needsOptions(newQuestion.type)"
                                class="mt-3"
                            >
                                <input
                                    v-model="newQuestion.options"
                                    type="text"
                                    placeholder="Opsi (pisahkan dengan koma, contoh: Opsi 1, Opsi 2, Opsi 3)"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                />
                            </div>

                            <!-- Required Toggle -->
                            <div class="mt-3">
                                <label class="flex items-center">
                                    <input
                                        v-model="newQuestion.is_required"
                                        type="checkbox"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    />
                                    <span class="ml-2 text-sm text-gray-700"
                                        >Wajib diisi</span
                                    >
                                </label>
                            </div>
                        </div>

                        <!-- Questions List -->
                        <div v-if="form.questions.length > 0" class="space-y-3">
                            <div
                                v-for="(question, index) in form.questions"
                                :key="index"
                                class="flex items-start gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg hover:border-gray-300 transition"
                            >
                                <!-- Order Number -->
                                <div
                                    class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-full text-sm font-medium"
                                >
                                    {{ question.order }}
                                </div>

                                <!-- Question Content -->
                                <div class="flex-1 min-w-0">
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ question.question }}
                                    </div>
                                    <div
                                        class="mt-1 flex items-center gap-3 text-xs text-gray-500"
                                    >
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded bg-gray-200 text-gray-700"
                                        >
                                            {{ getTypeLabel(question.type) }}
                                        </span>
                                        <span
                                            v-if="question.is_required"
                                            class="text-red-600"
                                            >● Wajib</span
                                        >
                                        <span
                                            v-if="question.options"
                                            class="truncate max-w-xs"
                                        >
                                            Opsi: {{ question.options }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div
                                    class="flex-shrink-0 flex items-center gap-1"
                                >
                                    <button
                                        @click="moveUp(index)"
                                        :disabled="index === 0"
                                        type="button"
                                        class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30"
                                        title="Pindah ke atas"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 15l7-7 7 7"
                                            />
                                        </svg>
                                    </button>
                                    <button
                                        @click="moveDown(index)"
                                        :disabled="
                                            index === form.questions.length - 1
                                        "
                                        type="button"
                                        class="p-1 text-gray-400 hover:text-gray-600 disabled:opacity-30"
                                        title="Pindah ke bawah"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 9l-7 7-7-7"
                                            />
                                        </svg>
                                    </button>
                                    <button
                                        @click="removeQuestion(index)"
                                        type="button"
                                        class="p-1 text-red-400 hover:text-red-600"
                                        title="Hapus"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
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
                                Belum ada pertanyaan. Tambahkan pertanyaan di
                                atas.
                            </p>
                        </div>

                        <p
                            v-if="form.errors.questions"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ form.errors.questions }}
                        </p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end gap-3">
                        <a
                            :href="route('admin.gpm.survey.index')"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Batal
                        </a>
                        <button
                            type="submit"
                            :disabled="
                                form.processing || form.questions.length === 0
                            "
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                        >
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Simpan Survey</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
