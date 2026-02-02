<template>
    <AppLayout>
        <!-- Page Title -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Struktur Organisasi GPM</h1>
                <p>Struktur Organisasi Gugus Penjaminan Mutu FTPP</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/evaluation">GPM</Link></li>
                        <li class="current">Struktur Organisasi</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Struktur Organisasi Section -->
        <section class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Struktur Organisasi GPM</h2>
                    <p>Struktur dan Personil Gugus Penjaminan Mutu FTPP</p>
                </div>

                <!-- Placeholder Info -->
                <div class="row mb-8" data-aos="fade-up" data-aos-delay="100">
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
                                        Struktur organisasi GPM akan ditampilkan
                                        di sini. Konten ini akan dikelola
                                        melalui dashboard admin.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization Chart -->
                <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">
                    <!-- Ketua GPM -->
                    <div class="col-12 mb-4">
                        <div
                            class="bg-gradient-primary p-8 rounded-lg text-center"
                        >
                            <div
                                class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <svg
                                    class="w-12 h-12 text-blue-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-2">
                                Ketua GPM
                            </h3>
                            <p class="text-white opacity-90 mb-1">
                                Koordinator Utama
                            </p>
                            <p class="text-white font-medium">-</p>
                        </div>
                    </div>

                    <!-- Anggota GPM -->
                    <div class="col-lg-4 col-md-6">
                        <div
                            class="bg-blue-50 p-6 rounded-lg text-center h-100"
                        >
                            <div
                                class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <svg
                                    class="w-10 h-10 text-blue-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-blue-900 mb-2">
                                Sekretaris GPM
                            </h4>
                            <p class="text-blue-700 mb-1">
                                Administrasi & Dokumentasi
                            </p>
                            <p class="text-blue-900 font-medium">-</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div
                            class="bg-green-50 p-6 rounded-lg text-center h-100"
                        >
                            <div
                                class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <svg
                                    class="w-10 h-10 text-green-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-green-900 mb-2">
                                Koordinator Audit
                            </h4>
                            <p class="text-green-700 mb-1">
                                Audit Mutu Internal
                            </p>
                            <p class="text-green-900 font-medium">-</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div
                            class="bg-purple-50 p-6 rounded-lg text-center h-100"
                        >
                            <div
                                class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <svg
                                    class="w-10 h-10 text-purple-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-purple-900 mb-2">
                                Koordinator Evaluasi
                            </h4>
                            <p class="text-purple-700 mb-1">
                                Monitoring & Evaluasi
                            </p>
                            <p class="text-purple-900 font-medium">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tugas dan Fungsi Section -->
        <section
            class="py-8 bg-gray-50"
            data-aos="fade-up"
            data-aos-delay="300"
        >
            <div class="container">
                <div class="section-title text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">
                        Tugas dan Fungsi GPM
                    </h3>
                </div>

                <div class="row gy-4">
                    <!-- Tugas Utama -->
                    <div class="col-lg-6">
                        <div class="bg-white p-8 rounded-lg h-100">
                            <div class="d-flex align-items-center mb-4">
                                <svg
                                    class="w-8 h-8 text-blue-600 me-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <h4
                                    class="text-xl font-bold text-gray-900 mb-0"
                                >
                                    Tugas Utama
                                </h4>
                            </div>
                            <ul class="space-y-2">
                                <li class="text-gray-700">
                                    → Melaksanakan penjaminan mutu internal di
                                    tingkat fakultas
                                </li>
                                <li class="text-gray-700">
                                    → Melakukan monitoring dan evaluasi
                                    pelaksanaan standar mutu
                                </li>
                                <li class="text-gray-700">
                                    → Menyusun laporan hasil audit mutu internal
                                </li>
                                <li class="text-gray-700">
                                    → Memberikan rekomendasi perbaikan mutu
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Fungsi -->
                    <div class="col-lg-6">
                        <div class="bg-white p-8 rounded-lg h-100">
                            <div class="d-flex align-items-center mb-4">
                                <svg
                                    class="w-8 h-8 text-green-600 me-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <h4
                                    class="text-xl font-bold text-gray-900 mb-0"
                                >
                                    Fungsi
                                </h4>
                            </div>
                            <ul class="space-y-2">
                                <li class="text-gray-700">
                                    → Perencanaan sistem penjaminan mutu
                                </li>
                                <li class="text-gray-700">
                                    → Pelaksanaan standar mutu akademik
                                </li>
                                <li class="text-gray-700">
                                    → Evaluasi dan pengendalian mutu
                                </li>
                                <li class="text-gray-700">
                                    → Peningkatan berkelanjutan (continuous
                                    improvement)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navigation Section -->
        <section class="py-8">
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
                                    href="/gpm/dokumen-spmi"
                                    class="btn btn-outline-primary"
                                >
                                    Dokumen SPMI
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

defineProps({
    pageTitle: {
        type: String,
        default: "Struktur Organisasi GPM",
    },
    pageDescription: {
        type: String,
        default: "Struktur Organisasi Gugus Penjaminan Mutu FTPP",
    },
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
});
</script>

<style scoped>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

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

.space-y-2 > * + * {
    margin-top: 0.5rem;
}
</style>
