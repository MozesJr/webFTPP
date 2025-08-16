<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Tambah Permission
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Buat permission baru untuk sistem
                        </p>
                    </div>
                    <Link
                        :href="route('super-admin.permissions.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Kembali
                    </Link>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form @submit.prevent="handleSubmit" class="p-6">
                <!-- Permission Name -->
                <div class="mb-6">
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Nama Permission <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="name"
                        type="text"
                        v-model="form.name"
                        :class="[
                            'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                            errors.name ? 'border-red-300' : 'border-gray-300',
                        ]"
                        placeholder="Contoh: users.view, posts.create, etc..."
                        required
                    />
                    <p class="mt-1 text-xs text-gray-500">
                        Gunakan format: module.action (contoh: users.view,
                        posts.create, roles.delete)
                    </p>
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">
                        {{ errors.name }}
                    </p>
                </div>

                <!-- Permission Examples/Suggestions -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Contoh Permission
                    </label>
                    <div
                        class="bg-gray-50 border border-gray-200 rounded-md p-4"
                    >
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2"
                        >
                            <button
                                type="button"
                                v-for="example in permissionExamples"
                                :key="example"
                                @click="form.name = example"
                                class="text-left px-3 py-1 text-sm bg-white border border-gray-200 rounded hover:bg-gray-100 transition-colors"
                            >
                                {{ example }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <Link
                        :href="route('super-admin.permissions.index')"
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
                        <span v-else>Simpan Permission</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

// Form
const form = useForm({
    name: "",
});

const processing = ref(false);
const errors = ref({});

// Permission examples
const permissionExamples = ref([
    "users.view",
    "users.create",
    "users.edit",
    "users.delete",
    "roles.view",
    "roles.create",
    "roles.edit",
    "roles.delete",
    "permissions.view",
    "permissions.create",
    "permissions.edit",
    "permissions.delete",
    "posts.view",
    "posts.create",
    "posts.edit",
    "posts.delete",
    "categories.view",
    "categories.create",
    "categories.edit",
    "categories.delete",
    "settings.view",
    "settings.edit",
    "dashboard.view",
    "reports.view",
    "reports.export",
]);

// Methods
const handleSubmit = () => {
    processing.value = true;
    errors.value = {};

    form.post(route("super-admin.permissions.store"), {
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
