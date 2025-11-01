<template>
    <AppLayout>
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Visi & Misi</h1>
                <p>Visi dan Misi Fakultas Teknik Pertambangan Perminyakan</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/about">Tentang Fakultas</Link></li>
                        <li class="current">Visi & Misi</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Vision & Mission Section -->
        <section class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Visi & Misi</h2>
                    <p>Landasan dan Arah Pengembangan Fakultas<br /></p>
                </div>

                <!-- Vision & Mission Grid -->
                <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
                    <!-- Vision -->
                    <div class="col-lg-6 mb-6">
                        <div class="bg-blue-50 p-8 rounded-lg h-100">
                            <div class="text-center mb-6">
                                <div
                                    class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-10 h-10 text-blue-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M10 12a2 2 0 100-4 2 2 0 000 4z"
                                        />
                                        <path
                                            fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                                <h3
                                    class="text-2xl font-bold text-blue-900 mb-4"
                                >
                                    Visi
                                </h3>
                            </div>
                            <div class="text-center">
                                <p
                                    class="text-blue-800 text-lg leading-relaxed"
                                >
                                    {{
                                        about.vision ||
                                        "Visi fakultas belum tersedia."
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Mission -->
                    <div class="col-lg-6 mb-6">
                        <div class="bg-green-50 p-8 rounded-lg h-100">
                            <div class="text-center mb-6">
                                <div
                                    class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-10 h-10 text-green-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <h3
                                    class="text-2xl font-bold text-green-900 mb-4"
                                >
                                    Misi
                                </h3>
                            </div>
                            <div class="text-center">
                                <p
                                    class="text-green-800 text-lg leading-relaxed"
                                >
                                    {{
                                        about.mission ||
                                        "Misi fakultas belum tersedia."
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Content if Available -->
                <div
                    v-if="about.description"
                    class="row mt-12"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <div class="col-12">
                        <div class="bg-gray-50 p-8 rounded-lg">
                            <h4
                                class="text-xl font-bold text-gray-900 mb-4 text-center"
                            >
                                Deskripsi Fakultas
                            </h4>
                            <p
                                class="text-gray-700 text-center leading-relaxed"
                            >
                                {{ about.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Values or Goals Section (if you want to add from SiteSettings) -->
                <div
                    v-if="tujuan"
                    class="row mt-12"
                    data-aos="fade-up"
                    data-aos-delay="300"
                >
                    <div class="col-12">
                        <div class="text-center mb-8">
                            <h4 class="text-2xl font-bold text-gray-900 mb-4">
                                Tujuan
                            </h4>
                        </div>
                        <div class="bg-yellow-50 p-8 rounded-lg">
                            <p
                                class="text-yellow-800 text-lg leading-relaxed text-center"
                            >
                                {{ tujuan }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navigation to other sections -->
        <section class="py-8 bg-gray-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-4">Informasi Lainnya</h4>
                            <div
                                class="d-flex flex-wrap justify-content-center gap-3"
                            >
                                <Link
                                    href="/about/profile"
                                    class="btn btn-outline-primary"
                                >
                                    Profil Fakultas
                                </Link>
                                <Link
                                    href="/about/history"
                                    class="btn btn-outline-primary"
                                >
                                    Sejarah
                                </Link>
                                <Link
                                    href="/about/program-studi"
                                    class="btn btn-outline-primary"
                                >
                                    Program Studi
                                </Link>
                                <Link
                                    href="/about/accreditation"
                                    class="btn btn-outline-primary"
                                >
                                    Akreditasi
                                </Link>
                                <Link
                                    href="/about/leadership"
                                    class="btn btn-outline-primary"
                                >
                                    Pimpinan & Staff
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
    about: Object,
    tujuan: String, // Dari SiteSetting jika ada
});
</script>
