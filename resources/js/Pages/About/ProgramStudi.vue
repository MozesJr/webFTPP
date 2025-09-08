<template>
    <AppLayout>
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Program Studi</h1>
                <p>Pilihan Program Pendidikan Berkualitas</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/about">Tentang Fakultas</Link></li>
                        <li class="current">Program Studi</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Program List by Degree Level -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Program Studi
                    </h2>
                    <p class="text-lg text-gray-600">
                        Pilihan Program Pendidikan Berkualitas di Fakultas
                        Teknik Pertambangan Perminyakan
                    </p>
                </div>

                <div
                    v-for="(programs, level) in programStudis"
                    :key="level"
                    class="mb-16"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div class="text-center mb-12">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                            {{ getDegreeTitle(level) }}
                        </h3>
                        <p class="text-lg text-gray-600">
                            {{ getDegreeDescription(level) }}
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                    >
                        <div
                            v-for="program in programs"
                            :key="program.id"
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <!-- Program Image -->
                            <div class="h-48 overflow-hidden">
                                <img
                                    v-if="program.image_url"
                                    :src="program.image_url"
                                    :alt="program.name"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center"
                                >
                                    <div class="text-center text-white">
                                        <svg
                                            class="w-16 h-16 mx-auto mb-2"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"
                                            />
                                        </svg>
                                        <p class="text-sm font-medium">
                                            {{ program.code }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Program Content -->
                            <div class="p-6">
                                <!-- Program Title -->
                                <div class="mb-4">
                                    <h4
                                        class="text-xl font-bold text-gray-900 mb-2"
                                    >
                                        {{ program.name }}
                                    </h4>
                                    <p
                                        class="text-sm text-gray-500 font-medium"
                                    >
                                        {{ program.code }} •
                                        {{ program.degree_level }}
                                    </p>
                                </div>

                                <!-- Program Description -->
                                <p
                                    class="text-gray-600 text-sm mb-4 line-clamp-3"
                                >
                                    {{
                                        program.description ||
                                        program.overview ||
                                        "Deskripsi program studi akan segera diperbarui."
                                    }}
                                </p>

                                <!-- Program Info -->
                                <div class="space-y-2 mb-4">
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-sm text-gray-500"
                                            >Akreditasi:</span
                                        >
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full"
                                            :class="
                                                getAccreditationColor(
                                                    program.accreditation
                                                )
                                            "
                                        >
                                            {{ program.accreditation || "-" }}
                                        </span>
                                    </div>

                                    <div
                                        v-if="program.head_of_program"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-sm text-gray-500"
                                            >Kaprodi:</span
                                        >
                                        <span
                                            class="text-sm text-gray-700 font-medium"
                                            >{{ program.head_of_program }}</span
                                        >
                                    </div>

                                    <div
                                        v-if="program.established_year"
                                        class="flex items-center justify-between"
                                    >
                                        <span class="text-sm text-gray-500"
                                            >Didirikan:</span
                                        >
                                        <span
                                            class="text-sm text-gray-700 font-medium"
                                            >{{
                                                program.established_year
                                            }}</span
                                        >
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="pt-4 border-t border-gray-100">
                                    <Link
                                        :href="`/program-studi/${program.code}`"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-center block transition-colors duration-200"
                                    >
                                        Lihat Detail
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fallback if no programs -->
                <div
                    v-if="
                        !programStudis ||
                        Object.keys(programStudis).length === 0
                    "
                    class="text-center py-16"
                >
                    <svg
                        class="w-24 h-24 mx-auto text-gray-300 mb-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                        />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-500 mb-2">
                        Belum Ada Program Studi
                    </h3>
                    <p class="text-gray-400">
                        Data program studi akan segera diperbarui.
                    </p>
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
    programStudis: Object,
});

function getDegreeTitle(level) {
    const titles = {
        D3: "Program Diploma III",
        S1: "Program Sarjana (S1)",
        S2: "Program Magister (S2)",
        S3: "Program Doktor (S3)",
    };
    return titles[level] || level;
}

function getDegreeDescription(level) {
    const descriptions = {
        D3: "Program vokasi 3 tahun dengan fokus pada keahlian praktis",
        S1: "Program sarjana 4 tahun dengan keseimbangan teori dan praktik",
        S2: "Program magister 2 tahun untuk spesialisasi lanjutan",
        S3: "Program doktor untuk penelitian dan pengembangan ilmu pengetahuan",
    };
    return descriptions[level] || "";
}

function getAccreditationColor(accreditation) {
    const colors = {
        A: "bg-green-100 text-green-800",
        B: "bg-blue-100 text-blue-800",
        C: "bg-yellow-100 text-yellow-800",
        Unggul: "bg-purple-100 text-purple-800",
        "Baik Sekali": "bg-green-100 text-green-800",
        Baik: "bg-blue-100 text-blue-800",
    };
    return colors[accreditation] || "bg-gray-100 text-gray-800";
}
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
