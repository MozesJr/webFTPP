<template>
    <AppLayout>
        <!-- Page Title -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Survey Kepuasan</h1>
                <p>Survey Kepuasan Mahasiswa, Dosen, dan Stakeholder</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/evaluation">GPM</Link></li>
                        <li class="current">Survey Kepuasan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Survey Section -->
        <section class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Survey Kepuasan</h2>
                    <p>
                        Berikan masukan Anda untuk peningkatan kualitas layanan
                        FTPP
                    </p>
                </div>

                <!-- Info Alert -->
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
                                        Survey aktif akan ditampilkan di sini.
                                        Admin dapat membuat dan mengelola survey
                                        melalui dashboard.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Survey Types -->
                <div
                    class="row gy-4 mb-8"
                    data-aos="fade-up"
                    data-aos-delay="150"
                >
                    <div class="col-lg-3 col-md-6">
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
                                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-blue-900 mb-2">
                                Mahasiswa
                            </h4>
                            <p class="text-blue-700 text-sm mb-3">
                                Survey kepuasan mahasiswa terhadap layanan
                                akademik
                            </p>
                            <span
                                class="badge bg-blue-600 text-white px-3 py-2"
                            >
                                0 Survey Aktif
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
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
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-green-900 mb-2">
                                Dosen
                            </h4>
                            <p class="text-green-700 text-sm mb-3">
                                Survey kepuasan dosen terhadap fasilitas dan
                                lingkungan kerja
                            </p>
                            <span
                                class="badge bg-green-600 text-white px-3 py-2"
                            >
                                0 Survey Aktif
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
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
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-purple-900 mb-2">
                                Alumni
                            </h4>
                            <p class="text-purple-700 text-sm mb-3">
                                Survey pelacakan alumni dan feedback pendidikan
                            </p>
                            <span
                                class="badge bg-purple-600 text-white px-3 py-2"
                            >
                                0 Survey Aktif
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div
                            class="bg-yellow-50 p-6 rounded-lg text-center h-100"
                        >
                            <div
                                class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <svg
                                    class="w-10 h-10 text-yellow-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-yellow-900 mb-2">
                                Stakeholder
                            </h4>
                            <p class="text-yellow-700 text-sm mb-3">
                                Survey kepuasan mitra industri dan stakeholder
                                eksternal
                            </p>
                            <span
                                class="badge bg-yellow-600 text-white px-3 py-2"
                            >
                                0 Survey Aktif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div class="row" data-aos="fade-up" data-aos-delay="200">
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
                                Belum Ada Survey Aktif
                            </h3>
                            <p class="text-gray-500">
                                Survey akan muncul di sini ketika admin
                                mengaktifkannya
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
            data-aos-delay="250"
        >
            <div class="container">
                <div class="section-title text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">
                        Panduan Mengisi Survey
                    </h3>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-4">
                        <div class="bg-white p-6 rounded-lg text-center h-100">
                            <div
                                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <span class="text-2xl font-bold text-blue-600"
                                    >1</span
                                >
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">
                                Pilih Survey
                            </h4>
                            <p class="text-gray-600">
                                Pilih survey yang relevan dengan status Anda
                                (mahasiswa, dosen, alumni, dll)
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="bg-white p-6 rounded-lg text-center h-100">
                            <div
                                class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <span class="text-2xl font-bold text-green-600"
                                    >2</span
                                >
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">
                                Isi dengan Jujur
                            </h4>
                            <p class="text-gray-600">
                                Berikan jawaban yang jujur dan objektif untuk
                                setiap pertanyaan
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="bg-white p-6 rounded-lg text-center h-100">
                            <div
                                class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <span class="text-2xl font-bold text-purple-600"
                                    >3</span
                                >
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">
                                Submit
                            </h4>
                            <p class="text-gray-600">
                                Pastikan semua pertanyaan telah dijawab sebelum
                                mengirimkan survey
                            </p>
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
        default: "Survey Kepuasan",
    },
    pageDescription: {
        type: String,
        default: "Survey Kepuasan Mahasiswa, Dosen, dan Stakeholder",
    },
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
});
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
