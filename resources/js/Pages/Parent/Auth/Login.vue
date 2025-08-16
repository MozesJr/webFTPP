<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8"
    >
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div
                    class="mx-auto h-16 w-16 bg-indigo-600 rounded-full flex items-center justify-center"
                >
                    <AcademicCapIcon class="h-8 w-8 text-white" />
                </div>
                <h2 class="mt-6 text-3xl font-bold text-gray-900">
                    Portal Orang Tua
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Akses informasi KHS mahasiswa
                </p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <form @submit.prevent="handleSubmit" class="space-y-6">
                    <!-- Username Field -->
                    <div>
                        <label
                            for="username"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Username (NIM Mahasiswa)
                        </label>
                        <div class="relative">
                            <input
                                id="username"
                                name="username"
                                type="text"
                                autocomplete="username"
                                v-model="form.username"
                                :class="[
                                    'appearance-none relative block w-full px-3 py-3 border rounded-lg placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm',
                                    errors.username
                                        ? 'border-red-300 bg-red-50'
                                        : 'border-gray-300',
                                ]"
                                placeholder="Masukkan NIM mahasiswa"
                                required
                            />
                            <UserIcon
                                class="absolute right-3 top-3 h-5 w-5 text-gray-400"
                            />
                        </div>
                        <p
                            v-if="errors.username"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.username }}
                        </p>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Password
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                v-model="form.password"
                                :class="[
                                    'appearance-none relative block w-full px-3 py-3 border rounded-lg placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm pr-10',
                                    errors.password
                                        ? 'border-red-300 bg-red-50'
                                        : 'border-gray-300',
                                ]"
                                placeholder="Masukkan password"
                                required
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600"
                            >
                                <EyeIcon v-if="!showPassword" class="h-5 w-5" />
                                <EyeSlashIcon v-else class="h-5 w-5" />
                            </button>
                        </div>
                        <p
                            v-if="errors.password"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.password }}
                        </p>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                v-model="form.remember"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            />
                            <label
                                for="remember"
                                class="ml-2 block text-sm text-gray-700"
                            >
                                Ingat saya
                            </label>
                        </div>

                        <div class="text-sm">
                            <Link
                                :href="route('parent.forgot-password')"
                                class="font-medium text-indigo-600 hover:text-indigo-500"
                            >
                                Lupa password?
                            </Link>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            :disabled="processing"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                        >
                            <span
                                class="absolute left-0 inset-y-0 flex items-center pl-3"
                            >
                                <LockClosedIcon
                                    class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                                    aria-hidden="true"
                                />
                            </span>
                            <span v-if="processing" class="flex items-center">
                                <svg
                                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
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
                                Masuk...
                            </span>
                            <span v-else>Masuk ke Portal</span>
                        </button>
                    </div>
                </form>

                <!-- Login Info -->
                <div
                    class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg"
                >
                    <div class="flex">
                        <InformationCircleIcon
                            class="h-5 w-5 text-blue-600 mt-0.5"
                        />
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Informasi Login
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>
                                        <strong>Username:</strong> NIM mahasiswa
                                    </li>
                                    <li>
                                        <strong>Password:</strong> NIM + tanggal
                                        lahir (ddmmyyyy)
                                    </li>
                                    <li>
                                        Contoh: NIM 2025001, lahir 15/01/2000 →
                                        Password: 202500115012000
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Butuh bantuan?
                    <a
                        href="#"
                        class="font-medium text-indigo-600 hover:text-indigo-500"
                    >
                        Hubungi Admin
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import {
    AcademicCapIcon,
    UserIcon,
    EyeIcon,
    EyeSlashIcon,
    LockClosedIcon,
    InformationCircleIcon,
} from "@heroicons/vue/24/outline";

// Form state
const form = useForm({
    username: "",
    password: "",
    remember: false,
});

const processing = ref(false);
const errors = ref({});
const showPassword = ref(false);

// Methods
const handleSubmit = () => {
    processing.value = true;
    errors.value = {};

    form.post(route("parent.login"), {
        onSuccess: () => {
            processing.value = false;
        },
        onError: (responseErrors) => {
            processing.value = false;
            errors.value = responseErrors;
        },
        onFinish: () => {
            form.reset("password");
        },
    });
};

// Auto-focus username field
import { onMounted } from "vue";
onMounted(() => {
    document.getElementById("username")?.focus();
});
</script>
