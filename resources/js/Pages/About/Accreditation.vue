<template>
    <AppLayout>
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Status Akreditasi</h1>
                <p>Jaminan Kualitas Pendidikan</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/about">Tentang Fakultas</Link></li>
                        <li class="current">Akreditasi</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Accreditation Section -->
        <section id="akreditasi" class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Status Akreditasi</h2>
                    <p>Jaminan Kualitas Pendidikan Program Studi<br /></p>
                </div>

                <!-- Accreditation Overview -->
                <div class="row mb-12" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-8 mx-auto">
                        <div class="bg-blue-50 p-8 rounded-lg text-center">
                            <div
                                class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <svg
                                    class="w-10 h-10 text-blue-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-blue-900 mb-4">
                                Komitmen Kualitas
                            </h3>
                            <p class="text-blue-800 leading-relaxed">
                                Fakultas Teknik Pertambangan Perminyakan
                                berkomitmen untuk memberikan pendidikan
                                berkualitas tinggi. Semua program studi telah
                                menjalani proses akreditasi sesuai standar
                                nasional untuk memastikan kualitas pendidikan
                                yang terbaik bagi mahasiswa.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Accreditation Table -->
                <div class="row" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-12">
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden"
                        >
                            <div class="bg-gray-50 p-6 border-b">
                                <h3 class="text-xl font-bold text-gray-900">
                                    Akreditasi Program Studi
                                </h3>
                                <p class="text-gray-600 mt-2">
                                    Status akreditasi terkini untuk setiap
                                    program studi
                                </p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            >
                                                Program Studi
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            >
                                                Jenjang
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            >
                                                Status Akreditasi
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            >
                                                Tahun Berlaku
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            >
                                                Sertifikat
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200"
                                    >
                                        <tr
                                            v-for="prodi in programStudi"
                                            :key="prodi.id"
                                            class="hover:bg-gray-50 transition-colors"
                                        >
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div
                                                            class="text-sm font-medium text-gray-900"
                                                        >
                                                            {{ prodi.name }}
                                                        </div>
                                                        <div
                                                            class="text-sm text-gray-500"
                                                        >
                                                            {{ prodi.code }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                    :class="
                                                        getDegreeColor(
                                                            prodi.degree_level
                                                        )
                                                    "
                                                >
                                                    {{ prodi.degree_level }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                    :class="
                                                        getAccreditationColor(
                                                            prodi.accreditation
                                                        )
                                                    "
                                                >
                                                    {{
                                                        prodi.accreditation ||
                                                        "Dalam Proses"
                                                    }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 text-sm text-gray-900"
                                            >
                                                <div
                                                    v-if="
                                                        prodi.accreditation_date &&
                                                        prodi.accreditation_expire
                                                    "
                                                >
                                                    {{
                                                        formatDateRange(
                                                            prodi.accreditation_date,
                                                            prodi.accreditation_expire
                                                        )
                                                    }}
                                                </div>
                                                <div
                                                    v-else
                                                    class="text-gray-400"
                                                >
                                                    -
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <button
                                                    v-if="prodi.certificate_url"
                                                    @click="
                                                        viewCertificate(
                                                            prodi.certificate_url
                                                        )
                                                    "
                                                    class="text-blue-600 hover:text-blue-900 font-medium"
                                                >
                                                    Lihat
                                                </button>
                                                <span
                                                    v-else
                                                    class="text-gray-400"
                                                    >-</span
                                                >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accreditation Legend -->
                <div class="row mt-8" data-aos="fade-up" data-aos-delay="300">
                    <div class="col-12">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">
                                Keterangan Status Akreditasi
                            </h4>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"
                            >
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mr-3"
                                    >
                                        Unggul
                                    </span>
                                    <span class="text-sm text-gray-600"
                                        >Akreditasi Tertinggi</span
                                    >
                                </div>
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-3"
                                    >
                                        A / Baik Sekali
                                    </span>
                                    <span class="text-sm text-gray-600"
                                        >Sangat Baik</span
                                    >
                                </div>
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-3"
                                    >
                                        B / Baik
                                    </span>
                                    <span class="text-sm text-gray-600"
                                        >Baik</span
                                    >
                                </div>
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mr-3"
                                    >
                                        C
                                    </span>
                                    <span class="text-sm text-gray-600"
                                        >Cukup</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="row mt-8" data-aos="fade-up" data-aos-delay="400">
                    <div class="col-lg-6">
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">
                                Badan Akreditasi
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-center">
                                    <svg
                                        class="w-4 h-4 text-green-500 mr-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        />
                                    </svg>
                                    BAN-PT (Badan Akreditasi Nasional Perguruan
                                    Tinggi)
                                </li>
                                <li class="flex items-center">
                                    <svg
                                        class="w-4 h-4 text-green-500 mr-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        />
                                    </svg>
                                    LAM-PTKes (Lembaga Akreditasi Mandiri
                                    Pendidikan Tinggi Kesehatan)
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">
                                Informasi Tambahan
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li>• Akreditasi berlaku selama 5 tahun</li>
                                <li>
                                    • Evaluasi berkala dilakukan setiap tahun
                                </li>
                                <li>
                                    • Re-akreditasi dilakukan sebelum masa
                                    berlaku habis
                                </li>
                                <li>
                                    • Status dapat berubah berdasarkan evaluasi
                                </li>
                            </ul>
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
                                    href="/about/vision-mission"
                                    class="btn btn-outline-primary"
                                >
                                    Visi & Misi
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
    programStudi: Array,
});

function getAccreditationColor(accreditation) {
    const colors = {
        Unggul: "bg-purple-100 text-purple-800",
        A: "bg-green-100 text-green-800",
        "Baik Sekali": "bg-green-100 text-green-800",
        B: "bg-blue-100 text-blue-800",
        Baik: "bg-blue-100 text-blue-800",
        C: "bg-yellow-100 text-yellow-800",
        Cukup: "bg-yellow-100 text-yellow-800",
    };
    return colors[accreditation] || "bg-gray-100 text-gray-800";
}

function getDegreeColor(degree) {
    const colors = {
        D3: "bg-orange-100 text-orange-800",
        S1: "bg-blue-100 text-blue-800",
        S2: "bg-purple-100 text-purple-800",
        S3: "bg-red-100 text-red-800",
    };
    return colors[degree] || "bg-gray-100 text-gray-800";
}

function formatDateRange(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    return `${start.getFullYear()} - ${end.getFullYear()}`;
}

function viewCertificate(url) {
    window.open(url, "_blank");
}
</script>
