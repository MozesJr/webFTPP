<template>
    <AppLayout>
        <!-- Page Title -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Gugus Penjaminan Mutu</h1>
                <p>Sistem Penjaminan Mutu Internal FTPP UNIPA</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">GPM</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- GPM Menu Section -->
        <section class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Gugus Penjaminan Mutu</h2>
                    <p>
                        Sistem Penjaminan Mutu Internal Fakultas Teknologi
                        Pertambangan dan Perminyakan
                    </p>
                </div>

                <!-- Menu Cards -->
                <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
                    <!-- Struktur Organisasi Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="bg-blue-50 p-8 rounded-lg h-100">
                            <div class="text-center mb-4">
                                <div
                                    class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-10 h-10 text-blue-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"
                                        />
                                    </svg>
                                </div>
                                <h3
                                    class="text-2xl font-bold text-blue-900 mb-3"
                                >
                                    Struktur Organisasi
                                </h3>
                            </div>
                            <p class="text-blue-800 text-center mb-4">
                                Struktur organisasi Gugus Penjaminan Mutu FTPP
                                UNIPA
                            </p>
                            <div class="text-center">
                                <Link
                                    href="/gpm/struktur-organisasi"
                                    class="btn btn-primary"
                                >
                                    Lihat Detail
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen SPMI Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="bg-green-50 p-8 rounded-lg h-100">
                            <div class="text-center mb-4">
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
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                                <h3
                                    class="text-2xl font-bold text-green-900 mb-3"
                                >
                                    Dokumen SPMI
                                </h3>
                            </div>
                            <p class="text-green-800 text-center mb-4">
                                Dokumen Sistem Penjaminan Mutu Internal FTPP
                            </p>
                            <div class="text-center">
                                <Link
                                    href="/gpm/dokumen-spmi"
                                    class="btn btn-success"
                                >
                                    Lihat Dokumen
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Survey Kepuasan Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="bg-purple-50 p-8 rounded-lg h-100">
                            <div class="text-center mb-4">
                                <div
                                    class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-10 h-10 text-purple-600"
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
                                <h3
                                    class="text-2xl font-bold text-purple-900 mb-3"
                                >
                                    Survey Kepuasan
                                </h3>
                            </div>
                            <p class="text-purple-800 text-center mb-4">
                                Survey kepuasan mahasiswa, dosen, dan
                                stakeholder
                            </p>
                            <div class="text-center">
                                <Link
                                    href="/gpm/survey-kepuasan"
                                    class="btn btn-primary"
                                    style="
                                        background: #9333ea;
                                        border-color: #9333ea;
                                    "
                                >
                                    Ikuti Survey
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Survey EDOM Card -->
                    <div class="col-lg-6 mb-4">
                        <div class="bg-yellow-50 p-8 rounded-lg h-100">
                            <div class="text-center mb-4">
                                <div
                                    class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-10 h-10 text-yellow-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        />
                                    </svg>
                                </div>
                                <h3
                                    class="text-2xl font-bold text-yellow-900 mb-3"
                                >
                                    Survey EDOM
                                </h3>
                            </div>
                            <p class="text-yellow-800 text-center mb-4">
                                Evaluasi Dosen Oleh Mahasiswa
                            </p>
                            <div class="text-center">
                                <Link
                                    href="/gpm/survey-edom"
                                    class="btn btn-warning"
                                >
                                    Mulai Evaluasi
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About GPM Section -->
        <section
            class="py-8 bg-gray-50"
            data-aos="fade-up"
            data-aos-delay="200"
        >
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bg-white p-8 rounded-lg">
                            <h4
                                class="text-2xl font-bold text-gray-900 mb-4 text-center"
                            >
                                Tentang GPM
                            </h4>
                            <p class="text-gray-700 leading-relaxed mb-3">
                                Gugus Penjaminan Mutu (GPM) merupakan unit yang
                                bertanggung jawab dalam pelaksanaan sistem
                                penjaminan mutu internal di Fakultas Teknologi
                                Pertambangan dan Perminyakan Universitas Papua.
                            </p>
                            <p class="text-gray-700 leading-relaxed">
                                GPM memiliki tugas untuk memastikan bahwa
                                seluruh kegiatan akademik dan non-akademik di
                                lingkungan fakultas berjalan sesuai dengan
                                standar mutu yang telah ditetapkan.
                            </p>
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
        default: "Gugus Penjaminan Mutu",
    },
    pageDescription: {
        type: String,
        default: "Sistem Penjaminan Mutu Internal FTPP",
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
.text-purple-800 {
    color: #6b21a8;
}
.text-purple-900 {
    color: #581c87;
}
</style>
