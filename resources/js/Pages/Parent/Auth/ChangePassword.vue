<!-- resources/js/Pages/Parent/Auth/ChangePassword.vue -->
<template>
    <ParentLayout :student="student" :parent="parent">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Ubah Password</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Perbarui password Anda untuk menjaga keamanan akun
                </p>
            </div>

            <!-- Change Password Form -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label
                                for="current_password"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Password Saat Ini
                            </label>
                            <div class="relative">
                                <input
                                    id="current_password"
                                    name="current_password"
                                    :type="
                                        showCurrentPassword
                                            ? 'text'
                                            : 'password'
                                    "
                                    v-model="form.current_password"
                                    :class="[
                                        'appearance-none relative block w-full px-3 py-3 border rounded-lg placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm pr-10',
                                        errors.current_password
                                            ? 'border-red-300 bg-red-50'
                                            : 'border-gray-300',
                                    ]"
                                    placeholder="Masukkan password saat ini"
                                    required
                                />
                                <button
                                    type="button"
                                    @click="
                                        showCurrentPassword =
                                            !showCurrentPassword
                                    "
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600"
                                >
                                    <EyeIcon
                                        v-if="!showCurrentPassword"
                                        class="h-5 w-5"
                                    />
                                    <EyeSlashIcon v-else class="h-5 w-5" />
                                </button>
                            </div>
                            <p
                                v-if="errors.current_password"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.current_password }}
                            </p>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Password Baru
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    name="password"
                                    :type="
                                        showNewPassword ? 'text' : 'password'
                                    "
                                    v-model="form.password"
                                    :class="[
                                        'appearance-none relative block w-full px-3 py-3 border rounded-lg placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm pr-10',
                                        errors.password
                                            ? 'border-red-300 bg-red-50'
                                            : 'border-gray-300',
                                    ]"
                                    placeholder="Masukkan password baru"
                                    required
                                />
                                <button
                                    type="button"
                                    @click="showNewPassword = !showNewPassword"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600"
                                >
                                    <EyeIcon
                                        v-if="!showNewPassword"
                                        class="h-5 w-5"
                                    />
                                    <EyeSlashIcon v-else class="h-5 w-5" />
                                </button>
                            </div>
                            <p
                                v-if="errors.password"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.password }}
                            </p>

                            <!-- Password Strength Indicator -->
                            <div v-if="form.password" class="mt-2">
                                <div class="flex items-center">
                                    <div class="flex-1">
                                        <div
                                            class="bg-gray-200 rounded-full h-2"
                                        >
                                            <div
                                                :class="[
                                                    'h-2 rounded-full transition-all duration-300',
                                                    passwordStrength.color,
                                                ]"
                                                :style="{
                                                    width: passwordStrength.width,
                                                }"
                                            ></div>
                                        </div>
                                    </div>
                                    <span
                                        :class="[
                                            'ml-2 text-xs font-medium',
                                            passwordStrength.textColor,
                                        ]"
                                    >
                                        {{ passwordStrength.label }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label
                                for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    :type="
                                        showConfirmPassword
                                            ? 'text'
                                            : 'password'
                                    "
                                    v-model="form.password_confirmation"
                                    :class="[
                                        'appearance-none relative block w-full px-3 py-3 border rounded-lg placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm pr-10',
                                        errors.password_confirmation
                                            ? 'border-red-300 bg-red-50'
                                            : 'border-gray-300',
                                    ]"
                                    placeholder="Konfirmasi password baru"
                                    required
                                />
                                <button
                                    type="button"
                                    @click="
                                        showConfirmPassword =
                                            !showConfirmPassword
                                    "
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600"
                                >
                                    <EyeIcon
                                        v-if="!showConfirmPassword"
                                        class="h-5 w-5"
                                    />
                                    <EyeSlashIcon v-else class="h-5 w-5" />
                                </button>
                            </div>
                            <p
                                v-if="errors.password_confirmation"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ errors.password_confirmation }}
                            </p>

                            <!-- Password Match Indicator -->
                            <div
                                v-if="
                                    form.password && form.password_confirmation
                                "
                                class="mt-1"
                            >
                                <p
                                    :class="[
                                        'text-xs',
                                        passwordsMatch
                                            ? 'text-green-600'
                                            : 'text-red-600',
                                    ]"
                                >
                                    {{
                                        passwordsMatch
                                            ? "✓ Password cocok"
                                            : "✗ Password tidak cocok"
                                    }}
                                </p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between pt-4">
                            <Link
                                :href="route('parent.profile')"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <ChevronLeftIcon class="mr-2 h-4 w-4" />
                                Kembali
                            </Link>
                            <button
                                type="submit"
                                :disabled="processing || !canSubmit"
                                class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span
                                    v-if="processing"
                                    class="flex items-center"
                                >
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
                                    Menyimpan...
                                </span>
                                <span v-else class="flex items-center">
                                    <KeyIcon class="mr-2 h-4 w-4" />
                                    Ubah Password
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Guidelines -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <InformationCircleIcon
                        class="h-5 w-5 text-blue-600 mt-0.5"
                    />
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-900">
                            Panduan Password
                        </h4>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Minimal 6 karakter</li>
                                <li>
                                    Gunakan kombinasi huruf besar, huruf kecil,
                                    dan angka
                                </li>
                                <li>
                                    Hindari menggunakan informasi pribadi (nama,
                                    tanggal lahir, dll)
                                </li>
                                <li>
                                    Pastikan password berbeda dengan password
                                    default
                                </li>
                                <li>
                                    Jangan bagikan password Anda kepada siapa
                                    pun
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </ParentLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import ParentLayout from "@/Layouts/ParentLayout.vue";
import {
    EyeIcon,
    EyeSlashIcon,
    KeyIcon,
    ChevronLeftIcon,
    InformationCircleIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    student: Object,
    parent: Object,
});

// Form state
const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const processing = ref(false);
const errors = ref({});
const showCurrentPassword = ref(false);
const showNewPassword = ref(false);
const showConfirmPassword = ref(false);

// Computed properties
const passwordsMatch = computed(() => {
    return (
        form.password &&
        form.password_confirmation &&
        form.password === form.password_confirmation
    );
});

const canSubmit = computed(() => {
    return (
        form.current_password &&
        form.password &&
        form.password_confirmation &&
        passwordsMatch.value &&
        form.password.length >= 6
    );
});

const passwordStrength = computed(() => {
    const password = form.password;
    if (!password)
        return {
            width: "0%",
            color: "bg-gray-200",
            label: "",
            textColor: "text-gray-500",
        };

    let score = 0;
    if (password.length >= 6) score++;
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    if (score <= 2) {
        return {
            width: "25%",
            color: "bg-red-400",
            label: "Lemah",
            textColor: "text-red-600",
        };
    } else if (score <= 4) {
        return {
            width: "50%",
            color: "bg-yellow-400",
            label: "Sedang",
            textColor: "text-yellow-600",
        };
    } else if (score <= 5) {
        return {
            width: "75%",
            color: "bg-blue-400",
            label: "Kuat",
            textColor: "text-blue-600",
        };
    } else {
        return {
            width: "100%",
            color: "bg-green-400",
            label: "Sangat Kuat",
            textColor: "text-green-600",
        };
    }
});

// Methods
const handleSubmit = () => {
    processing.value = true;
    errors.value = {};

    form.put(route("parent.password.update"), {
        onSuccess: () => {
            processing.value = false;
            form.reset();
        },
        onError: (responseErrors) => {
            processing.value = false;
            errors.value = responseErrors;
        },
    });
};
</script>
