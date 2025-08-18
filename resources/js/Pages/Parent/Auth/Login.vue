<!-- resources/js/Pages/Parent/Auth/Login.vue (Breeze Compatible) -->
<template>
    <GuestLayout>
        <Head title="Parent Login" />

        <div class="mb-4 text-center">
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

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="username" value="Username (NIM Mahasiswa)" />
                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan NIM mahasiswa"
                />
                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link
                    :href="route('parent.forgot-password')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Lupa password?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Masuk ke Portal
                </PrimaryButton>
            </div>
        </form>

        <!-- Login Info -->
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex">
                <InformationCircleIcon class="h-5 w-5 text-blue-600 mt-0.5" />
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Informasi Login
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Username:</strong> NIM mahasiswa</li>
                            <li><strong>Password:</strong> NIM + 01012000</li>
                            <li>
                                Contoh: NIM 2025001 → Password: 202500101012000
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to main site -->
        <div class="mt-6 text-center">
            <Link
                :href="route('login')"
                class="text-sm text-gray-600 hover:text-gray-900"
            >
                ← Kembali ke Login Admin
            </Link>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import {
    AcademicCapIcon,
    InformationCircleIcon,
} from "@heroicons/vue/24/outline";

const form = useForm({
    username: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("parent.login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>
