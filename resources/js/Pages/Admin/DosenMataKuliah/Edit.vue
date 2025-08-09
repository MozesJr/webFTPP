<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Penugasan Dosen
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Perbarui penugasan:
                            {{ dosenMataKuliah.dosen?.name }} -
                            {{ dosenMataKuliah.mata_kuliah?.name }}
                        </p>
                    </div>
                    <Link
                        href="/admin/dosen-mata-kuliah"
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
                <h2 class="text-lg font-medium text-gray-900">
                    Informasi Penugasan
                </h2>
            </div>

            <form @submit.prevent="submit" class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Dosen -->
                        <div>
                            <label
                                for="dosen_id"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Dosen <span class="text-red-500">*</span>
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
                                    {{ dosen.name }} - {{ dosen.email }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.dosen_id"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.dosen_id }}
                            </div>
                        </div>

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
                                        }})</span
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

                        <!-- Role and Academic Year -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Role -->
                            <div>
                                <label
                                    for="role"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="role"
                                    v-model="form.role"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300': form.errors.role,
                                    }"
                                >
                                    <option value="">Pilih Role</option>
                                    <option value="Koordinator">
                                        Koordinator
                                    </option>
                                    <option value="Pengampu">Pengampu</option>
                                    <option value="Asisten">Asisten</option>
                                </select>
                                <div
                                    v-if="form.errors.role"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.role }}
                                </div>
                            </div>

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
                                <p class="mt-1 text-sm text-gray-500">
                                    Format: YYYY/YYYY
                                </p>
                            </div>
                        </div>

                        <!-- Current Assignment Info -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">
                                Ringkasan Penugasan Saat Ini
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm">
                                        <span class="font-medium text-gray-700"
                                            >Dosen:</span
                                        >
                                        <div class="mt-1">
                                            {{
                                                selectedDosen?.name ||
                                                dosenMataKuliah.dosen?.name
                                            }}
                                        </div>
                                        <div class="text-gray-500">
                                            {{
                                                selectedDosen?.email ||
                                                dosenMataKuliah.dosen?.email
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm">
                                        <span class="font-medium text-gray-700"
                                            >Mata Kuliah:</span
                                        >
                                        <div class="mt-1">
                                            {{
                                                selectedMataKuliah?.code ||
                                                dosenMataKuliah.mata_kuliah
                                                    ?.code
                                            }}
                                            -
                                            {{
                                                selectedMataKuliah?.name ||
                                                dosenMataKuliah.mata_kuliah
                                                    ?.name
                                            }}
                                        </div>
                                        <div class="text-gray-500">
                                            {{
                                                selectedMataKuliah?.credits ||
                                                dosenMataKuliah.mata_kuliah
                                                    ?.credits
                                            }}
                                            SKS - Semester
                                            {{
                                                selectedMataKuliah?.semester ||
                                                dosenMataKuliah.mata_kuliah
                                                    ?.semester
                                            }}
                                        </div>
                                        <div class="text-gray-500">
                                            {{
                                                selectedMataKuliah?.kurikulum
                                                    ?.program_studi?.name ||
                                                dosenMataKuliah.mata_kuliah
                                                    ?.kurikulum?.program_studi
                                                    ?.name
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Status -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">
                                Status
                            </h3>
                            <div class="flex items-center">
                                <input
                                    id="is_active"
                                    v-model="form.is_active"
                                    type="checkbox"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label
                                    for="is_active"
                                    class="ml-2 block text-sm text-gray-900"
                                >
                                    Aktifkan penugasan
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Penugasan aktif akan muncul di jadwal dan
                                laporan
                            </p>
                        </div>

                        <!-- Role Info -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-900 mb-2">
                                Informasi Role
                            </h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>
                                    <strong>Koordinator:</strong> Penanggung
                                    jawab mata kuliah
                                </li>
                                <li>
                                    <strong>Pengampu:</strong> Dosen pengajar
                                    utama
                                </li>
                                <li>
                                    <strong>Asisten:</strong> Dosen pendamping
                                </li>
                            </ul>
                        </div>

                        <!-- Assignment History -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-green-900 mb-2">
                                Informasi Penugasan
                            </h3>
                            <div class="text-sm text-green-700 space-y-1">
                                <div>
                                    <span class="font-medium">Dibuat:</span>
                                    {{ formatDate(dosenMataKuliah.created_at) }}
                                </div>
                                <div>
                                    <span class="font-medium">Diperbarui:</span>
                                    {{ formatDate(dosenMataKuliah.updated_at) }}
                                </div>
                                <div>
                                    <span class="font-medium"
                                        >Role Saat Ini:</span
                                    >
                                    <span
                                        :class="
                                            getRoleColor(dosenMataKuliah.role)
                                        "
                                        class="ml-1 px-2 py-0.5 rounded-full text-xs"
                                    >
                                        {{ dosenMataKuliah.role }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Warning -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3
                                class="text-sm font-medium text-yellow-900 mb-2"
                            >
                                Perhatian
                            </h3>
                            <ul class="text-sm text-yellow-700 space-y-1">
                                <li>
                                    • Setiap mata kuliah hanya boleh memiliki 1
                                    koordinator
                                </li>
                                <li>
                                    • Dosen tidak boleh ditugaskan ganda untuk
                                    mata kuliah yang sama
                                </li>
                                <li>
                                    • Perubahan akan mempengaruhi jadwal terkait
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-3 border-t pt-6">
                    <Link
                        href="/admin/dosen-mata-kuliah"
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
                        <span v-else> Update Penugasan </span>
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
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    dosenMataKuliah: {
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

// Form dengan _method untuk method spoofing
const form = useForm({
    _method: "PUT",
    dosen_id: props.dosenMataKuliah?.dosen_id || "",
    mata_kuliah_id: props.dosenMataKuliah?.mata_kuliah_id || "",
    role: props.dosenMataKuliah?.role || "",
    academic_year: props.dosenMataKuliah?.academic_year || "",
    is_active: props.dosenMataKuliah?.is_active ?? true,
});

// Computed
const selectedDosen = computed(() => {
    return props.dosens.find(
        (dosen) => dosen.id.toString() === form.dosen_id.toString()
    );
});

const selectedMataKuliah = computed(() => {
    return props.mataKuliahs.find(
        (matkul) => matkul.id.toString() === form.mata_kuliah_id.toString()
    );
});

// Methods
const getRoleColor = (role) => {
    const colors = {
        Koordinator: "bg-purple-100 text-purple-800",
        Pengampu: "bg-blue-100 text-blue-800",
        Asisten: "bg-green-100 text-green-800",
    };
    return colors[role] || "bg-gray-100 text-gray-800";
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

const submit = () => {
    // Gunakan POST dengan method spoofing
    form.post(`/admin/dosen-mata-kuliah/${props.dosenMataKuliah.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            success("Berhasil!", "Penugasan dosen berhasil diperbarui.");
        },
        onError: (errors) => {
            console.log("Update errors:", errors);
            error("Error!", "Terjadi kesalahan saat memperbarui data.");
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
