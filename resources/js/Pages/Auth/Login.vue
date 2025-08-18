<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    nim: "", // Tambahkan field nim untuk login orang tua
    password: "",
    remember: false,
});

// pakai 'manager' untuk admin panel, 'parent' untuk portal orang tua
const selectedRole = ref("manager");

// Computed property untuk menentukan endpoint dan mengosongkan form
const actionUrl = computed(() => {
    // Kosongkan form email atau nim saat peran berubah
    if (selectedRole.value === "manager") {
        form.nim = "";
    } else {
        form.email = "";
    }

    // Tentukan URL aksi berdasarkan peran
    return selectedRole.value === "manager"
        ? typeof route === "function"
            ? route("login")
            : "/login"
        : "/parent/login"; // Ini endpoint parent
});

// Computed property untuk menentukan placeholder input
const usernamePlaceholder = computed(() => {
    return selectedRole.value === "manager" ? "Email" : "NIM";
});

// Computed property untuk menentukan tipe input (text/email)
const usernameType = computed(() => {
    return selectedRole.value === "manager" ? "email" : "text";
});

// Computed property untuk menentukan nama field yang digunakan
const usernameField = computed(() => {
    return selectedRole.value === "manager" ? "email" : "nim";
});

const submit = () => {
    // Gunakan form.post dengan data yang relevan
    const formData = {
        password: form.password,
    };

    if (selectedRole.value === "manager") {
        formData.email = form.email;
    } else {
        formData.nim = form.nim;
    }

    form.post(actionUrl.value, {
        data: formData,
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="login-header box-shadow mb-20">
            <div
                class="container-fluid d-flex justify-content-between align-items-center"
            >
                <div class="brand-logo">
                    <Link href="/" class="text-decoration-none">
                        <img
                            src="/storage/assets/img/Logo_Universitas_Papua.png"
                            alt="Logo"
                            style="height: 60px"
                        />
                    </Link>
                </div>
            </div>
        </div>

        <div
            class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
        >
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-7 d-none d-md-block">
                        <div class="login-image">
                            <div class="illustration-placeholder">
                                <img
                                    src="/storage/assets/img/login-page-img.png"
                                    alt="Logo"
                                    style="height: 100%"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div
                            class="login-box bg-white box-shadow border-radius-10"
                        >
                            <div class="login-title">
                                <h2 class="text-center text-primary">Login</h2>
                            </div>

                            <div v-if="status" class="alert alert-success mb-4">
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit">
                                <div class="select-role">
                                    <div
                                        class="btn-group btn-group-toggle w-100"
                                    >
                                        <label
                                            :class="[
                                                'btn',
                                                selectedRole === 'manager'
                                                    ? 'active btn-primary'
                                                    : 'btn-outline-primary',
                                            ]"
                                            style="flex: 1; margin-right: 5px"
                                            @click="selectedRole = 'manager'"
                                        >
                                            <input
                                                type="radio"
                                                name="role"
                                                value="manager"
                                                v-model="selectedRole"
                                                style="display: none"
                                            />
                                            <div class="text-center">
                                                <div class="icon">
                                                    <img
                                                        src="/storage/assets/vendors/images/briefcase.svg"
                                                        class="svg"
                                                        alt=""
                                                    />
                                                </div>
                                                Dashboard Admin
                                            </div>
                                        </label>

                                        <label
                                            :class="[
                                                'btn',
                                                selectedRole === 'parent'
                                                    ? 'active btn-primary'
                                                    : 'btn-outline-primary',
                                            ]"
                                            style="flex: 1; margin-left: 5px"
                                            @click="selectedRole = 'parent'"
                                        >
                                            <input
                                                type="radio"
                                                name="role"
                                                value="parent"
                                                v-model="selectedRole"
                                                style="display: none"
                                            />
                                            <div class="text-center">
                                                <div class="icon">
                                                    <img
                                                        src="/storage/assets/vendors/images/person.svg"
                                                        class="svg"
                                                        alt=""
                                                    />
                                                </div>
                                                Portal Orang Tua
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="input-group custom">
                                    <input
                                        :type="usernameType"
                                        class="form-control form-control-lg"
                                        :placeholder="usernamePlaceholder"
                                        v-model="form[usernameField]"
                                        required
                                        autofocus
                                        :autocomplete="
                                            selectedRole === 'manager'
                                                ? 'username'
                                                : 'off'
                                        "
                                        :class="{
                                            'is-invalid':
                                                form.errors[usernameField],
                                        }"
                                    />
                                    <div class="input-group-append custom">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                    </div>
                                    <InputError
                                        class="invalid-feedback"
                                        :message="form.errors[usernameField]"
                                    />
                                </div>

                                <div class="input-group custom">
                                    <input
                                        type="password"
                                        class="form-control form-control-lg"
                                        placeholder="Password"
                                        v-model="form.password"
                                        required
                                        autocomplete="current-password"
                                        :class="{
                                            'is-invalid': form.errors.password,
                                        }"
                                    />
                                    <div class="input-group-append custom">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                    </div>
                                    <InputError
                                        class="invalid-feedback"
                                        :message="form.errors.password"
                                    />
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-0">
                                            <button
                                                type="submit"
                                                class="btn btn-primary btn-lg btn-block"
                                                :class="{
                                                    'opacity-25':
                                                        form.processing,
                                                }"
                                                :disabled="form.processing"
                                            >
                                                {{
                                                    form.processing
                                                        ? "Signing In..."
                                                        : "Sign In"
                                                }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
