<template>
    <AppLayout>
        <!-- Hero Section -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Tentang FTPP UNIPA</h1>
                <p>
                    Fakultas Teknik Pertambangan Perminyakan Universitas Papua
                </p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Tentang Fakultas</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Navigation Menu -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Informasi Fakultas
                    </h2>
                    <p class="text-lg text-gray-600">
                        Pilih informasi yang ingin Anda ketahui
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <!-- Profil Fakultas -->
                    <Link href="/about/profile" class="group">
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <div class="bg-blue-600 p-6 text-center">
                                <div
                                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-8 h-8 text-blue-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">
                                    Profil Fakultas
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 text-center">
                                    Gambaran umum, visi, misi, dan deskripsi
                                    Fakultas Teknik Pertambangan Perminyakan
                                </p>
                            </div>
                        </div>
                    </Link>

                    <!-- Sejarah -->
                    <Link href="/about/history" class="group">
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <div class="bg-green-600 p-6 text-center">
                                <div
                                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-8 h-8 text-green-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M12 2l3.09 6.26L22 9l-5 4.87L18.18 22 12 18.27 5.82 22 7 13.87 2 9l6.91-.74L12 2z"
                                        />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">
                                    Sejarah
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 text-center">
                                    Perjalanan sejarah dan milestone penting
                                    dalam perkembangan fakultas
                                </p>
                            </div>
                        </div>
                    </Link>

                    <!-- Visi Misi -->
                    <Link href="/about/vision-mission" class="group">
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <div class="bg-purple-600 p-6 text-center">
                                <div
                                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-8 h-8 text-purple-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M10 2L3 7v10c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V7l-7-5z"
                                        />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">
                                    Visi & Misi
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 text-center">
                                    Visi dan misi fakultas sebagai panduan dalam
                                    mencapai tujuan pendidikan
                                </p>
                            </div>
                        </div>
                    </Link>

                    <!-- Program Studi -->
                    <Link href="/about/program-studi" class="group">
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <div class="bg-orange-600 p-6 text-center">
                                <div
                                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-8 h-8 text-orange-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"
                                        />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">
                                    Program Studi
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 text-center">
                                    Daftar program studi yang tersedia dengan
                                    informasi akreditasi dan jenjang
                                </p>
                            </div>
                        </div>
                    </Link>

                    <!-- Akreditasi -->
                    <Link href="/about/accreditation" class="group">
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <div class="bg-red-600 p-6 text-center">
                                <div
                                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-8 h-8 text-red-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">
                                    Akreditasi
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 text-center">
                                    Status akreditasi program studi dan jaminan
                                    kualitas pendidikan
                                </p>
                            </div>
                        </div>
                    </Link>

                    <!-- Pimpinan & Staff -->
                    <Link href="/about/leadership" class="group">
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <div class="bg-indigo-600 p-6 text-center">
                                <div
                                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4"
                                >
                                    <svg
                                        class="w-8 h-8 text-indigo-600"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"
                                        />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white">
                                    Pimpinan & Staff
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-600 text-center">
                                    Struktur kepemimpinan dan tim dosen & staff
                                    fakultas
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Statistics Section -->
                <div class="mt-16 bg-gray-50 rounded-lg p-8">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                            Statistik Fakultas
                        </h3>
                    </div>
                    <div
                        class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center"
                    >
                        <div class="stat-item">
                            <div class="text-4xl font-bold text-blue-600 mb-2">
                                {{ formatNumber(stats.total_students) }}
                            </div>
                            <div class="text-gray-600">Mahasiswa</div>
                        </div>
                        <div class="stat-item">
                            <div class="text-4xl font-bold text-green-600 mb-2">
                                {{ formatNumber(stats.total_lecturers) }}
                            </div>
                            <div class="text-gray-600">Dosen</div>
                        </div>
                        <div class="stat-item">
                            <div
                                class="text-4xl font-bold text-purple-600 mb-2"
                            >
                                {{ formatNumber(stats.total_alumni) }}
                            </div>
                            <div class="text-gray-600">Alumni</div>
                        </div>
                        <div class="stat-item">
                            <div
                                class="text-4xl font-bold text-orange-600 mb-2"
                            >
                                {{ formatNumber(stats.total_partnerships) }}
                            </div>
                            <div class="text-gray-600">Mitra Kerja</div>
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
    stats: Object,
});

function formatNumber(num) {
    return new Intl.NumberFormat("id-ID").format(num);
}
</script>
