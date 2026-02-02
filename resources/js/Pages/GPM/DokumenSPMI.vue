<template>
    <AppLayout>
        <!-- Page Title -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Dokumen SPMI</h1>
                <p>Dokumen Sistem Penjaminan Mutu Internal FTPP</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/evaluation">GPM</Link></li>
                        <li class="current">Dokumen SPMI</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Dokumen SPMI Section -->
        <section class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Dokumen SPMI</h2>
                    <p>Sistem Penjaminan Mutu Internal FTPP UNIPA</p>
                </div>

                <!-- Search and Filter -->
                <div class="row mb-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-8 mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <svg
                                    class="w-5 h-5 text-gray-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </span>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Cari dokumen SPMI..."
                                v-model="searchQuery"
                            />
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <select class="form-select" v-model="selectedCategory">
                            <option value="">Semua Kategori</option>
                            <option value="standar">Standar</option>
                            <option value="manual">Manual</option>
                            <option value="formulir">Formulir</option>
                            <option value="sop">SOP</option>
                        </select>
                    </div>
                </div>

                <!-- Placeholder Info -->
                <div class="row mb-8" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <svg
                                    class="w-6 h-6 text-blue-600 me-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <div>
                                    <strong>Informasi</strong>
                                    <p class="mb-0 mt-1">
                                        Dokumen SPMI akan ditampilkan di sini.
                                        Admin dapat mengunggah dan mengelola
                                        dokumen melalui dashboard.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Categories -->
                <div
                    class="row gy-4 mb-8"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <div class="col-lg-3 col-md-6">
                        <div
                            class="bg-blue-50 p-6 rounded-lg text-center h-100"
                        >
                            <div
                                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3"
                            >
                                <svg
                                    class="w-8 h-8 text-blue-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-blue-900 mb-2">
                                Standar SPMI
                            </h4>
                            <p class="text-blue-700 text-sm mb-3">
                                Dokumen standar penjaminan mutu
                            </p>
                            <span
                                class="badge bg-blue-600 text-white px-3 py-2"
                            >
                                0 Dokumen
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div
                            class="bg-green-50 p-6 rounded-lg text-center h-100"
                        >
                            <div
                                class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3"
                            >
                                <svg
                                    class="w-8 h-8 text-green-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-green-900 mb-2">
                                Manual SPMI
                            </h4>
                            <p class="text-green-700 text-sm mb-3">
                                Pedoman pelaksanaan SPMI
                            </p>
                            <span
                                class="badge bg-green-600 text-white px-3 py-2"
                            >
                                0 Dokumen
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div
                            class="bg-purple-50 p-6 rounded-lg text-center h-100"
                        >
                            <div
                                class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3"
                            >
                                <svg
                                    class="w-8 h-8 text-purple-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"
                                    />
                                    <path
                                        fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-purple-900 mb-2">
                                Formulir
                            </h4>
                            <p class="text-purple-700 text-sm mb-3">
                                Formulir terkait SPMI
                            </p>
                            <span
                                class="badge bg-purple-600 text-white px-3 py-2"
                            >
                                0 Dokumen
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div
                            class="bg-yellow-50 p-6 rounded-lg text-center h-100"
                        >
                            <div
                                class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3"
                            >
                                <svg
                                    class="w-8 h-8 text-yellow-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-yellow-900 mb-2">
                                SOP
                            </h4>
                            <p class="text-yellow-700 text-sm mb-3">
                                Standard Operating Procedures
                            </p>
                            <span
                                class="badge bg-yellow-600 text-white px-3 py-2"
                            >
                                0 Dokumen
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div class="row" data-aos="fade-up" data-aos-delay="250">
                    <div class="col-12">
                        <div class="bg-white p-12 rounded-lg text-center">
                            <svg
                                class="w-24 h-24 text-gray-400 mx-auto mb-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-700 mb-2">
                                Belum Ada Dokumen
                            </h3>
                            <p class="text-gray-500">
                                Dokumen SPMI akan ditampilkan di sini setelah
                                dikelola melalui dashboard admin
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navigation Section -->
        <section class="py-8 bg-gray-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-4">Menu GPM Lainnya</h4>
                            <div
                                class="d-flex flex-wrap justify-content-center gap-3"
                            >
                                <Link
                                    href="/evaluation"
                                    class="btn btn-outline-primary"
                                >
                                    GPM Home
                                </Link>
                                <Link
                                    href="/gpm/struktur-organisasi"
                                    class="btn btn-outline-primary"
                                >
                                    Struktur Organisasi
                                </Link>
                                <Link
                                    href="/gpm/survey-kepuasan"
                                    class="btn btn-outline-primary"
                                >
                                    Survey Kepuasan
                                </Link>
                                <Link
                                    href="/gpm/survey-edom"
                                    class="btn btn-outline-primary"
                                >
                                    Survey EDOM
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";

defineProps({
    pageTitle: {
        type: String,
        default: "Dokumen SPMI",
    },
    pageDescription: {
        type: String,
        default: "Dokumen Sistem Penjaminan Mutu Internal FTPP",
    },
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
});

const searchQuery = ref("");
const selectedCategory = ref("");
</script>

<style scoped>
.bg-purple-50 {
    background-color: #faf5ff;
}
.bg-purple-100 {
    background-color: #e9d5ff;
}
.text-purple-600 {
    color: #9333ea;
}
.text-purple-700 {
    color: #7e22ce;
}
.text-purple-900 {
    color: #581c87;
}
.bg-purple-600 {
    background-color: #9333ea;
}
</style>
