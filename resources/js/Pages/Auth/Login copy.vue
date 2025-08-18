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
    password: "",
    remember: false,
});

// pakai 'manager' untuk admin panel, 'parent' untuk portal orang tua
const selectedRole = ref("manager");

const actionUrl = computed(() => {
    return selectedRole.value === "manager"
        ? typeof route === "function"
            ? route("login")
            : "/login"
        : "/parent/login"; // ini endpoint parent
});

const submit = () => {
    form.post(actionUrl.value, {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <!-- Login Header -->
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

        <!-- Login Wrap -->
        <div
            class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
        >
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-7 d-none d-md-block">
                        <div class="login-image">
                            <!-- Placeholder untuk gambar atau bisa dikosongkan -->
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

                            <!-- Status Message -->
                            <div v-if="status" class="alert alert-success mb-4">
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit">
                                <!-- Role Selection -->
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

                                <!-- Email Input -->
                                <div class="input-group custom">
                                    <input
                                        type="text"
                                        class="form-control form-control-lg"
                                        placeholder="Email"
                                        v-model="form.email"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        :class="{
                                            'is-invalid': form.errors.email,
                                        }"
                                    />
                                    <div class="input-group-append custom">
                                        <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                        </span>
                                    </div>
                                    <InputError
                                        class="invalid-feedback"
                                        :message="form.errors.email"
                                    />
                                </div>

                                <!-- Password Input -->
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

                                <!-- Submit Button -->
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
