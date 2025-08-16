<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Orang Tua
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat akun orang tua baru dengan data siswa
                        </p>
                    </div>
                    <Link
                        :href="route('super-admin.parents.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Data Orang Tua
                    </h2>
                </div>
                <form @submit.prevent="handleSubmit" class="p-6">
                    <!-- Student Selection -->
                    <div class="mb-6">
                        <label
                            for="student_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Pilih Siswa <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="student_id"
                            v-model="form.student_id"
                            @change="onStudentChange"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.student_id
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            required
                        >
                            <option value="">Pilih Siswa...</option>
                            <option
                                v-for="student in students"
                                :key="student.id"
                                :value="student.id"
                            >
                                {{ student.nim }} - {{ student.name }}
                            </option>
                        </select>
                        <p
                            v-if="errors.student_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.student_id }}
                        </p>
                    </div>

                    <!-- Parent Name -->
                    <div class="mb-6">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Nama Orang Tua <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.name
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            placeholder="Masukkan nama lengkap orang tua..."
                            required
                        />
                        <p v-if="errors.name" class="mt-1 text-sm text-red-600">
                            {{ errors.name }}
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.email
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            placeholder="email@example.com"
                        />
                        <p
                            v-if="errors.email"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.email }}
                        </p>
                    </div>

                    <!-- Phone -->
                    <div class="mb-6">
                        <label
                            for="phone"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Nomor Telepon
                        </label>
                        <input
                            id="phone"
                            type="tel"
                            v-model="form.phone"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.phone
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            placeholder="08123456789"
                        />
                        <p
                            v-if="errors.phone"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.phone }}
                        </p>
                    </div>

                    <!-- Relation -->
                    <div class="mb-6">
                        <label
                            for="relation"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Hubungan <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="relation"
                            v-model="form.relation"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.relation
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            required
                        >
                            <option value="ayah">Ayah</option>
                            <option value="ibu">Ibu</option>
                            <option value="wali">Wali</option>
                        </select>
                        <p
                            v-if="errors.relation"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.relation }}
                        </p>
                    </div>

                    <!-- Occupation -->
                    <div class="mb-6">
                        <label
                            for="occupation"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Pekerjaan
                        </label>
                        <input
                            id="occupation"
                            type="text"
                            v-model="form.occupation"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.occupation
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            placeholder="Pekerjaan orang tua..."
                        />
                        <p
                            v-if="errors.occupation"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.occupation }}
                        </p>
                    </div>

                    <!-- Address -->
                    <div class="mb-6">
                        <label
                            for="address"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Alamat
                        </label>
                        <textarea
                            id="address"
                            v-model="form.address"
                            rows="3"
                            :class="[
                                'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                                errors.address
                                    ? 'border-red-300'
                                    : 'border-gray-300',
                            ]"
                            placeholder="Alamat lengkap..."
                        ></textarea>
                        <p
                            v-if="errors.address"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.address }}
                        </p>
                    </div>

                    <!-- Active Status -->
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input
                                id="is_active"
                                type="checkbox"
                                v-model="form.is_active"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            />
                            <label
                                for="is_active"
                                class="ml-2 block text-sm text-gray-900"
                            >
                                Aktif (dapat login ke sistem)
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3">
                        <Link
                            :href="route('super-admin.parents.index')"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="processing"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                        >
                            <span v-if="processing">Menyimpan...</span>
                            <span v-else>Simpan Data</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Student Info Preview -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">
                        Preview Data Siswa
                    </h2>
                </div>
                <div class="p-6">
                    <div v-if="selectedStudent" class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                NIM
                            </dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 font-semibold"
                            >
                                {{ selectedStudent.nim }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Nama Siswa
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ selectedStudent.name }}
                            </dd>
                        </div>
                        <div v-if="selectedStudent.email">
                            <dt class="text-sm font-medium text-gray-500">
                                Email
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ selectedStudent.email }}
                            </dd>
                        </div>
                        <div v-if="selectedStudent.program_studi">
                            <dt class="text-sm font-medium text-gray-500">
                                Program Studi
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ selectedStudent.program_studi }}
                            </dd>
                        </div>
                        <div class="pt-4 border-t">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">
                                Akun yang akan dibuat:
                            </h3>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <p class="text-xs text-gray-600">
                                    <strong>Username:</strong>
                                    {{ selectedStudent.nim }}<br />
                                    <strong>Password:</strong>
                                    {{ selectedStudent.nim }}123
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center py-12">
                        <UserIcon class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-4 text-sm font-medium text-gray-900">
                            Pilih Siswa
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Pilih siswa untuk melihat preview data
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ArrowLeftIcon, UserIcon } from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    students: {
        type: Array,
        default: () => [],
    },
});

// Form
const form = useForm({
    student_id: "",
    name: "",
    email: "",
    phone: "",
    relation: "ayah",
    occupation: "",
    address: "",
    is_active: true,
});

const processing = ref(false);
const errors = ref({});

// Computed
const selectedStudent = computed(() => {
    if (!form.student_id) return null;
    return props.students.find((s) => s.id == form.student_id);
});

// Methods
const onStudentChange = () => {
    // Auto-fill address from student if available
    if (selectedStudent.value && selectedStudent.value.address) {
        form.address = selectedStudent.value.address;
    }
};

const handleSubmit = () => {
    processing.value = true;
    errors.value = {};

    form.post(route("super-admin.parents.store"), {
        onSuccess: () => {
            processing.value = false;
        },
        onError: (responseErrors) => {
            processing.value = false;
            errors.value = responseErrors;
        },
    });
};
</script>
