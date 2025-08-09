<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit RPS
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Perbarui RPS: {{ rps.mata_kuliah?.name }} -
                            {{ rps.academic_year }} {{ rps.semester }}
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

            <form
                @submit.prevent="submit"
                class="p-6"
                enctype="multipart/form-data"
            >
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
                                        form.errors.mata_kuliah_id,
                                }"
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
                                v-if="form.errors.mata_kuliah_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.mata_kuliah_id }}
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
                                    'border-red-300': form.errors.dosen_id,
                                }"
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
                                v-if="form.errors.dosen_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.dosen_id }}
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
                                            form.errors.academic_year,
                                    }"
                                    placeholder="2024/2025"
                                />
                                <div
                                    v-if="form.errors.academic_year"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.academic_year }}
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
                                        'border-red-300': form.errors.semester,
                                    }"
                                >
                                    <option value="">Pilih Semester</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                <div
                                    v-if="form.errors.semester"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.semester }}
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
                                        form.errors.learning_objectives,
                                }"
                                placeholder="Jelaskan tujuan pembelajaran yang ingin dicapai dalam mata kuliah ini..."
                            ></textarea>
                            <div
                                v-if="form.errors.learning_objectives"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.learning_objectives }}
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
                                        form.errors.learning_outcomes,
                                }"
                                placeholder="Jelaskan capaian pembelajaran yang terukur dan dapat diamati..."
                            ></textarea>
                            <div
                                v-if="form.errors.learning_outcomes"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.learning_outcomes }}
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
                                        form.errors.assessment_methods,
                                }"
                                placeholder="Jelaskan metode penilaian yang akan digunakan (UTS, UAS, Tugas, Quiz, dll)..."
                            ></textarea>
                            <div
                                v-if="form.errors.assessment_methods"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.assessment_methods }}
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
                                    'border-red-300': form.errors.references,
                                }"
                                placeholder="Daftar buku, jurnal, atau sumber referensi yang digunakan..."
                            ></textarea>
                            <div
                                v-if="form.errors.references"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.references }}
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ form.references.length }}/2000 karakter
                            </p>
                        </div>

                        <!-- Current Document & Upload -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Dokumen RPS
                            </label>

                            <!-- Current Document -->
                            <div v-if="currentDocumentUrl" class="mb-3">
                                <div class="flex items-center space-x-3">
                                    <DocumentIcon
                                        class="h-8 w-8 text-blue-500"
                                    />
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            Dokumen saat ini
                                        </p>
                                        <a
                                            :href="currentDocumentUrl"
                                            target="_blank"
                                            class="text-sm text-blue-600 hover:text-blue-800"
                                        >
                                            Lihat dokumen
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- File Input -->
                            <input
                                id="document_url"
                                ref="documentInput"
                                type="file"
                                accept=".pdf,.doc,.docx"
                                @change="handleDocumentChange"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                            <div
                                v-if="form.errors.document_url"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.document_url }}
                            </div>

                            <!-- New Document Preview -->
                            <div v-if="documentPreview" class="mt-3">
                                <div class="flex items-center space-x-2">
                                    <DocumentIcon
                                        class="h-8 w-8 text-green-500"
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
                                            - Dokumen baru
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
                                Format: PDF, DOC, DOCX. Maksimal 5MB. Kosongkan
                                jika tidak ingin mengganti dokumen.
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
                                        'border-red-300': form.errors.status,
                                    }"
                                >
                                    <option value="">Pilih Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Submitted</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                <div
                                    v-if="form.errors.status"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.status }}
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Status saat ini:
                                    <span
                                        :class="getStatusColor(rps.status)"
                                        class="px-2 py-1 rounded-full text-xs"
                                        >{{ getStatusLabel(rps.status) }}</span
                                    >
                                </p>
                            </div>
                        </div>

                        <!-- RPS Information -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-green-900 mb-2">
                                Informasi RPS
                            </h3>
                            <div class="text-sm text-green-700 space-y-1">
                                <div>
                                    <span class="font-medium">Dibuat:</span>
                                    {{ formatDate(rps.created_at) }}
                                </div>
                                <div>
                                    <span class="font-medium">Diperbarui:</span>
                                    {{ formatDate(rps.updated_at) }}
                                </div>
                                <div v-if="rps.approved_by && rps.approved_at">
                                    <span class="font-medium"
                                        >Disetujui oleh:</span
                                    >
                                    {{ rps.approved_by }}
                                </div>
                                <div v-if="rps.approved_at">
                                    <span class="font-medium"
                                        >Tanggal persetujuan:</span
                                    >
                                    {{ formatDate(rps.approved_at) }}
                                </div>
                            </div>
                        </div>

                        <!-- Course Information -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-900 mb-2">
                                Informasi Mata Kuliah
                            </h3>
                            <div class="text-sm text-blue-800 space-y-1">
                                <div>
                                    <span class="font-medium">Kode:</span>
                                    {{
                                        selectedMataKuliah?.code ||
                                        rps.mata_kuliah?.code
                                    }}
                                </div>
                                <div>
                                    <span class="font-medium">SKS:</span>
                                    {{
                                        selectedMataKuliah?.credits ||
                                        rps.mata_kuliah?.credits
                                    }}
                                </div>
                                <div>
                                    <span class="font-medium">Semester:</span>
                                    {{
                                        selectedMataKuliah?.semester ||
                                        rps.mata_kuliah?.semester
                                    }}
                                </div>
                                <div>
                                    <span class="font-medium">Kategori:</span>
                                    {{
                                        selectedMataKuliah?.category ||
                                        rps.mata_kuliah?.category
                                    }}
                                </div>
                            </div>
                        </div>

                        <!-- Lecturer Information -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3
                                class="text-sm font-medium text-yellow-900 mb-2"
                            >
                                Informasi Dosen
                            </h3>
                            <div class="text-sm text-yellow-800 space-y-1">
                                <div>
                                    <span class="font-medium">Nama:</span>
                                    {{ selectedDosen?.name || rps.dosen?.name }}
                                </div>
                                <div>
                                    <span class="font-medium">Email:</span>
                                    {{
                                        selectedDosen?.email || rps.dosen?.email
                                    }}
                                </div>
                                <div
                                    v-if="
                                        selectedDosen?.expertise ||
                                        rps.dosen?.expertise
                                    "
                                >
                                    <span class="font-medium">Keahlian:</span>
                                    {{
                                        selectedDosen?.expertise ||
                                        rps.dosen?.expertise
                                    }}
                                </div>
                            </div>
                        </div>

                        <!-- Warning -->
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-red-900 mb-2">
                                Perhatian
                            </h3>
                            <ul class="text-sm text-red-700 space-y-1">
                                <li>
                                    • Perubahan RPS akan memerlukan persetujuan
                                    ulang
                                </li>
                                <li>
                                    • RPS yang sudah approved akan kembali ke
                                    status draft
                                </li>
                                <li>• Pastikan semua informasi telah akurat</li>
                                <li>
                                    • Dokumen yang diupload akan mengganti yang
                                    lama
                                </li>
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
                        :disabled="form.processing"
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
                        <span v-else> Update RPS </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
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
    rps: {
        type: Object,
        required: true,
    },
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

// Computed
const currentDocumentUrl = computed(() => {
    return props.rps?.document_url || null;
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

// Form dengan _method untuk method spoofing
const form = useForm({
    _method: "PUT",
    mata_kuliah_id: props.rps?.mata_kuliah_id || "",
    dosen_id: props.rps?.dosen_id || "",
    academic_year: props.rps?.academic_year || "",
    semester: props.rps?.semester || "",
    learning_objectives: props.rps?.learning_objectives || "",
    learning_outcomes: props.rps?.learning_outcomes || "",
    assessment_methods: props.rps?.assessment_methods || "",
    references: props.rps?.references || "",
    document_url: null,
    status: props.rps?.status || "draft",
});

// Methods
const getStatusColor = (status) => {
    const colors = {
        draft: "bg-gray-100 text-gray-800",
        submitted: "bg-yellow-100 text-yellow-800",
        approved: "bg-green-100 text-green-800",
        rejected: "bg-red-100 text-red-800",
    };
    return colors[status] || "bg-gray-100 text-gray-800";
};

const getStatusLabel = (status) => {
    const labels = {
        draft: "Draft",
        submitted: "Submitted",
        approved: "Approved",
        rejected: "Rejected",
    };
    return labels[status] || status;
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const handleDocumentChange = (event) => {
    const file = event.target.files[0];
    if (file) {
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
    // Gunakan POST dengan method spoofing
    form.post(`/admin/rps/${props.rps.id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "RPS berhasil diubah.");
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
