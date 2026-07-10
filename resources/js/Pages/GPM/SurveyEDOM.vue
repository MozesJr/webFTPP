<template>
    <AppLayout>
        <!-- Page Title -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Survey EDOM</h1>
                <p>Evaluasi Dosen Oleh Mahasiswa</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/evaluation">GPM</Link></li>
                        <li class="current">Survey EDOM</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- EDOM Section -->
        <section class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Survey EDOM</h2>
                    <p>Evaluasi Dosen Oleh Mahasiswa - FTPP UNIPA</p>
                </div>

                <!-- Warning Alert -->
                <div class="row mb-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-center">
                                <svg
                                    class="w-6 h-6 text-yellow-600 me-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <div>
                                    <strong>Informasi Penting</strong>
                                    <p class="mb-0 mt-1">
                                        Survey EDOM hanya dapat diakses oleh
                                        mahasiswa yang terdaftar dan sedang
                                        aktif. Silakan login untuk mengakses
                                        survey EDOM Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- EDOM Info Grid -->
                <div
                    class="row gy-4 mb-8"
                    data-aos="fade-up"
                    data-aos-delay="150"
                >
                    <div class="col-lg-6">
                        <div class="bg-blue-50 p-8 rounded-lg h-100">
                            <div class="d-flex align-items-center mb-4">
                                <svg
                                    class="w-10 h-10 text-blue-600 me-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <h3
                                    class="text-2xl font-bold text-blue-900 mb-0"
                                >
                                    Apa itu EDOM?
                                </h3>
                            </div>
                            <p class="text-blue-800 leading-relaxed mb-3">
                                EDOM (Evaluasi Dosen Oleh Mahasiswa) adalah
                                instrumen penjaminan mutu untuk mengevaluasi
                                kinerja dosen dalam proses pembelajaran.
                                Evaluasi ini mencakup berbagai aspek seperti:
                            </p>
                            <ul class="space-y-2">
                                <li class="text-blue-700">
                                    ✓ Penguasaan materi pembelajaran
                                </li>
                                <li class="text-blue-700">
                                    ✓ Metode dan strategi pengajaran
                                </li>
                                <li class="text-blue-700">
                                    ✓ Interaksi dengan mahasiswa
                                </li>
                                <li class="text-blue-700">
                                    ✓ Penilaian dan feedback
                                </li>
                                <li class="text-blue-700">
                                    ✓ Kedisiplinan dan profesionalisme
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="bg-green-50 p-8 rounded-lg h-100">
                            <div class="d-flex align-items-center mb-4">
                                <svg
                                    class="w-10 h-10 text-green-600 me-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <h3
                                    class="text-2xl font-bold text-green-900 mb-0"
                                >
                                    Privasi & Kerahasiaan
                                </h3>
                            </div>
                            <p class="text-green-800 leading-relaxed mb-3">
                                Identitas Anda sebagai responden dijamin
                                kerahasiaannya. Hasil evaluasi bersifat anonim
                                dan hanya digunakan untuk:
                            </p>
                            <ul class="space-y-2">
                                <li class="text-green-700">
                                    ✓ Peningkatan kualitas pembelajaran
                                </li>
                                <li class="text-green-700">
                                    ✓ Pengembangan kompetensi dosen
                                </li>
                                <li class="text-green-700">
                                    ✓ Bahan evaluasi internal
                                </li>
                                <li class="text-green-700">
                                    ✓ Perbaikan sistem pendidikan
                                </li>
                            </ul>
                            <div class="alert alert-success mt-4 mb-0">
                                <div class="d-flex align-items-center">
                                    <svg
                                        class="w-5 h-5 text-green-600 me-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <span class="text-sm"
                                        >Data Anda dijamin 100% aman dan
                                        anonim</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- EDOM Process Section -->
        <section
            class="py-8 bg-gray-50"
            data-aos="fade-up"
            data-aos-delay="200"
        >
            <div class="container">
                <div class="section-title text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">
                        Tahapan Pengisian EDOM
                    </h3>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white p-6 rounded-lg text-center h-100">
                            <div
                                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <span class="text-2xl font-bold text-blue-600"
                                    >1</span
                                >
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">
                                Login
                            </h4>
                            <p class="text-gray-600">
                                Login menggunakan akun mahasiswa Anda
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white p-6 rounded-lg text-center h-100">
                            <div
                                class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <span class="text-2xl font-bold text-green-600"
                                    >2</span
                                >
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">
                                Pilih Mata Kuliah
                            </h4>
                            <p class="text-gray-600">
                                Pilih mata kuliah yang ingin dievaluasi
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white p-6 rounded-lg text-center h-100">
                            <div
                                class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <span class="text-2xl font-bold text-purple-600"
                                    >3</span
                                >
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">
                                Isi Kuesioner
                            </h4>
                            <p class="text-gray-600">
                                Jawab setiap pertanyaan dengan objektif
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white p-6 rounded-lg text-center h-100">
                            <div
                                class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <span class="text-2xl font-bold text-yellow-600"
                                    >4</span
                                >
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">
                                Submit
                            </h4>
                            <p class="text-gray-600">Kirim evaluasi Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Login Section -->
        <section class="py-16" data-aos="fade-up" data-aos-delay="250">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div
                            class="bg-gradient-primary p-12 rounded-lg text-center"
                        >
                            <svg
                                class="w-24 h-24 text-white mx-auto mb-6"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <h3 class="text-3xl font-bold text-white mb-4">
                                Akses Survey EDOM
                            </h3>
                            <p class="text-white text-lg opacity-90 mb-6">
                                Mahasiswa yang ingin mengisi Survey EDOM silakan
                                login terlebih dahulu menggunakan akun mahasiswa
                                Anda
                            </p>
                            <Link
                                href="/login"
                                class="btn btn-light btn-lg px-6 py-3"
                            >
                                <svg
                                    class="w-5 h-5 me-2"
                                    style="
                                        display: inline-block;
                                        vertical-align: middle;
                                    "
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Login Sebagai Mahasiswa
                            </Link>
                            <p class="text-white text-sm mt-4 mb-0 opacity-75">
                                <svg
                                    class="w-4 h-4 me-1"
                                    style="
                                        display: inline-block;
                                        vertical-align: middle;
                                    "
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Belum punya akun? Hubungi admin fakultas
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Guidelines Section -->
        <section
            class="py-8 bg-gray-50"
            data-aos="fade-up"
            data-aos-delay="300"
        >
            <div class="container">
                <div class="section-title text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">
                        Pedoman Pengisian
                    </h3>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="bg-white p-8 rounded-lg">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">
                                <svg
                                    class="w-6 h-6 me-2"
                                    style="
                                        display: inline-block;
                                        vertical-align: middle;
                                    "
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"
                                    />
                                    <path
                                        d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"
                                    />
                                </svg>
                                Tips Mengisi EDOM:
                            </h4>
                            <ul class="space-y-3">
                                <li class="text-gray-700 d-flex">
                                    <span class="text-blue-600 me-2">→</span>
                                    <span
                                        >Berikan penilaian yang jujur dan
                                        objektif</span
                                    >
                                </li>
                                <li class="text-gray-700 d-flex">
                                    <span class="text-blue-600 me-2">→</span>
                                    <span
                                        >Fokus pada aspek pembelajaran, bukan
                                        personal</span
                                    >
                                </li>
                                <li class="text-gray-700 d-flex">
                                    <span class="text-blue-600 me-2">→</span>
                                    <span
                                        >Berikan masukan konstruktif di kolom
                                        saran</span
                                    >
                                </li>
                                <li class="text-gray-700 d-flex">
                                    <span class="text-blue-600 me-2">→</span>
                                    <span
                                        >Isi semua pertanyaan sebelum
                                        submit</span
                                    >
                                </li>
                                <li class="text-gray-700 d-flex">
                                    <span class="text-blue-600 me-2">→</span>
                                    <span
                                        >Manfaatkan kesempatan ini untuk
                                        meningkatkan kualitas pendidikan</span
                                    >
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
                                    href="/gpm/struktur-organisasi"
                                    class="btn btn-outline-primary"
                                >
                                    Struktur Organisasi
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
        default: "Survey EDOM",
    },
    pageDescription: {
        type: String,
        default: "Evaluasi Dosen Oleh Mahasiswa",
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

.space-y-2 > * + * {
    margin-top: 0.5rem;
}

.space-y-3 > * + * {
    margin-top: 0.75rem;
}
</style>
