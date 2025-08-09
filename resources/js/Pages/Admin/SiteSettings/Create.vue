<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Site Setting
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Tambahkan pengaturan website baru
                        </p>
                    </div>
                    <Link
                        href="/admin/site-settings"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Key Name -->
                        <div>
                            <label
                                for="key_name"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Key Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="key_name"
                                v-model="form.key_name"
                                type="text"
                                placeholder="contoh: site_title, contact_email"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{
                                    'border-red-500': form.errors.key_name,
                                }"
                            />
                            <p class="mt-1 text-xs text-gray-500">
                                Gunakan underscore untuk pemisah (snake_case)
                            </p>
                            <div
                                v-if="form.errors.key_name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.key_name }}
                            </div>
                        </div>

                        <!-- Type -->
                        <div>
                            <label
                                for="type"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Type <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="type"
                                v-model="form.type"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{ 'border-red-500': form.errors.type }"
                            >
                                <option value="">Pilih Type</option>
                                <option
                                    v-for="(label, value) in typeOptions"
                                    :key="value"
                                    :value="value"
                                >
                                    {{ label }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.type"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.type }}
                            </div>
                        </div>
                    </div>

                    <!-- Group -->
                    <div>
                        <label
                            for="group"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Group <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-2">
                            <select
                                v-model="selectedGroup"
                                @change="updateGroup"
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">
                                    Pilih dari existing atau ketik baru
                                </option>
                                <option
                                    v-for="group in groups"
                                    :key="group"
                                    :value="group"
                                >
                                    {{ group }}
                                </option>
                            </select>
                            <span class="text-gray-500 py-2">atau</span>
                            <input
                                id="group"
                                v-model="form.group"
                                type="text"
                                placeholder="Ketik group baru"
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                :class="{ 'border-red-500': form.errors.group }"
                            />
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            Contoh: general, contact, social, appearance, seo
                        </p>
                        <div
                            v-if="form.errors.group"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.group }}
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Description
                        </label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="3"
                            placeholder="Deskripsi pengaturan ini (opsional)"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{
                                'border-red-500': form.errors.description,
                            }"
                        ></textarea>
                        <div
                            v-if="form.errors.description"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <!-- Value Input (Dynamic based on type) -->
                    <div>
                        <label
                            for="value"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Value
                        </label>

                        <!-- Text Input -->
                        <input
                            v-if="
                                form.type === 'text' ||
                                form.type === 'email' ||
                                form.type === 'url'
                            "
                            id="value"
                            v-model="form.value"
                            :type="
                                form.type === 'email'
                                    ? 'email'
                                    : form.type === 'url'
                                    ? 'url'
                                    : 'text'
                            "
                            :placeholder="getPlaceholder()"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{ 'border-red-500': form.errors.value }"
                        />

                        <!-- Textarea -->
                        <textarea
                            v-else-if="form.type === 'textarea'"
                            id="value"
                            v-model="form.value"
                            rows="4"
                            :placeholder="getPlaceholder()"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{ 'border-red-500': form.errors.value }"
                        ></textarea>

                        <!-- Number Input -->
                        <input
                            v-else-if="form.type === 'number'"
                            id="value"
                            v-model="form.value"
                            type="number"
                            :placeholder="getPlaceholder()"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{ 'border-red-500': form.errors.value }"
                        />

                        <!-- Color Input -->
                        <input
                            v-else-if="form.type === 'color'"
                            id="value"
                            v-model="form.value"
                            type="color"
                            class="w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            :class="{ 'border-red-500': form.errors.value }"
                        />

                        <!-- Boolean Input -->
                        <div
                            v-else-if="form.type === 'boolean'"
                            class="flex items-center"
                        >
                            <input
                                id="value"
                                v-model="booleanValue"
                                type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <label
                                for="value"
                                class="ml-2 text-sm text-gray-600"
                            >
                                Enable this setting
                            </label>
                        </div>

                        <!-- File Input -->
                        <div v-else-if="form.type === 'file'">
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors"
                            >
                                <div class="space-y-1 text-center">
                                    <DocumentArrowUpIcon
                                        class="mx-auto h-12 w-12 text-gray-400"
                                    />
                                    <div class="flex text-sm text-gray-600">
                                        <label
                                            for="file_upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                        >
                                            <span>Upload file</span>
                                            <input
                                                id="file_upload"
                                                @change="handleFileChange"
                                                type="file"
                                                accept="image/*,.pdf,.doc,.docx"
                                                class="sr-only"
                                            />
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, PDF, DOC hingga 5MB
                                    </p>
                                    <div
                                        v-if="selectedFile"
                                        class="mt-2 text-sm text-green-600"
                                    >
                                        File terpilih: {{ selectedFile.name }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="form.errors.value"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.value }}
                        </div>
                        <div
                            v-if="form.errors.file_upload"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.file_upload }}
                        </div>
                    </div>
                </div>

                <div
                    class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3"
                >
                    <Link
                        href="/admin/site-settings"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Batal
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                    >
                        <span v-if="form.processing">
                            <svg
                                class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                        <span v-else>
                            <PlusIcon class="w-4 h-4 mr-2" />
                            Simpan Setting
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {
    ArrowLeftIcon,
    PlusIcon,
    DocumentArrowUpIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    groups: {
        type: Array,
        default: () => [],
    },
    typeOptions: {
        type: Object,
        default: () => ({}),
    },
});

// Form
const form = useForm({
    key_name: "",
    value: "",
    type: "",
    description: "",
    group: "",
    file_upload: null,
});

// Reactive data
const selectedFile = ref(null);
const selectedGroup = ref("");
const booleanValue = ref(false);

// Computed
const placeholderExamples = {
    text: "Contoh: Universitas Indonesia",
    email: "Contoh: info@university.ac.id",
    url: "Contoh: https://university.ac.id",
    textarea: "Masukkan teks panjang...",
    number: "Contoh: 10, 100, 1000",
    color: "#000000",
};

// Methods
const getPlaceholder = () => {
    return placeholderExamples[form.type] || "Masukkan nilai...";
};

const updateGroup = () => {
    if (selectedGroup.value) {
        form.group = selectedGroup.value;
    }
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        selectedFile.value = file;
        form.file_upload = file;
    }
};

// Watch boolean value changes
watch(booleanValue, (newValue) => {
    form.value = newValue ? "1" : "0";
});

// Submit form
const submit = () => {
    form.post(route("admin.site-settings.store"), {
        onSuccess: () => {
            // Handle success (redirect will be handled by controller)
        },
        onError: (errors) => {
            console.log("Form errors:", errors);
        },
    });
};
</script>
