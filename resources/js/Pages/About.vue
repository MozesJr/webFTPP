<template>
    <AppLayout>
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>{{ about.title }}</h1>
                <p>
                    {{ about.subtitle }}
                </p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.html#about">Home</a></li>
                        <li class="current">Profil Fakultas</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Profil Fakultas</h2>
                <p>{{ about.title }}<br /></p>
            </div>
            <div class="container">
                <div class="row gy-4">
                    <div
                        class="col-lg-6 mb-6"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <h3>{{ about.title }}</h3>

                        <p>
                            {{ about.subtitle }}
                        </p>
                        <p>
                            {{ about.description }}
                        </p>
                    </div>

                    <div
                        class="col-lg-6 mb-6"
                        data-aos="fade-up"
                        data-aos-delay="250"
                    >
                        <div class="content ps-0 ps-lg-5">
                            <div class="position-relative mt-4">
                                <img
                                    src="storage/assets/img/About1.jpeg"
                                    class="img-fluid rounded-4"
                                    alt=""
                                />

                                <button
                                    v-if="about.video_url"
                                    @click="showVideo = true"
                                    class="glightbox pulsating-play-btn"
                                >
                                    <PlayIcon class="w-5 h-5 mr-2" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-lg-12 mt-6"
                        data-aos="fade-up"
                        data-aos-delay="250"
                    >
                        <!-- Vision & Mission -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div
                                v-if="about.vision"
                                class="bg-blue-50 p-6 rounded-lg"
                            >
                                <h3
                                    class="text-lg font-semibold text-blue-900 mb-3"
                                >
                                    Visi
                                </h3>
                                <p class="text-blue-800">{{ about.vision }}</p>
                            </div>
                            <div
                                v-if="about.mission"
                                class="bg-green-50 p-6 rounded-lg"
                            >
                                <h3
                                    class="text-lg font-semibold text-green-900 mb-3"
                                >
                                    Misi
                                </h3>
                                <p class="text-green-800">
                                    {{ about.mission }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Modal v-if="showVideo" @close="showVideo = false">
                <div class="aspect-video">
                    <iframe
                        :src="about.video_url"
                        class="w-full h-full rounded-lg"
                        frameborder="0"
                        allowfullscreen
                    >
                    </iframe>
                </div>
            </Modal>
        </section>
        <!-- /About Section -->

        <section id="sejarah" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Sejarah Fakultas</h2>
                <p>Perjalanan Panjang Menuju Keunggulan<br /></p>
            </div>

            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Sejarah Singkat</h3>
                        <p>
                            Fakultas Teknik Pertambangan dan Perminyakan
                            didirikan pada tahun 1985 sebagai respons terhadap
                            kebutuhan tenaga ahli di bidang pertambangan dan
                            energi di Indonesia. Pada awalnya, fakultas ini
                            hanya memiliki satu program studi yaitu Teknik
                            Pertambangan.
                        </p>

                        <p>
                            Seiring dengan perkembangan industri energi dan
                            kebutuhan akan diversifikasi keahlian, pada tahun
                            1992 dibuka program studi Teknik Perminyakan.
                            Kemudian pada tahun 2005, fakultas ini menambahkan
                            program studi Teknik Geologi untuk memperkuat basis
                            keilmuan dalam eksplorasi sumber daya mineral dan
                            energi.
                        </p>

                        <p>
                            Pada tahun 2010, fakultas ini memperoleh akreditasi
                            A dari BAN-PT dan terus mempertahankan standar
                            kualitas tinggi hingga saat ini. Berbagai pencapaian
                            telah diraih, termasuk pengakuan internasional dan
                            kemitraan dengan universitas terkemuka di dunia.
                        </p>

                        <h3>Milestone Penting</h3>
                        <ul>
                            <li>
                                <strong>1985:</strong> Pendirian Fakultas Teknik
                                Pertambangan
                            </li>
                            <li>
                                <strong>1992:</strong> Pembukaan Program Studi
                                Teknik Perminyakan
                            </li>
                            <li>
                                <strong>2005:</strong> Pembukaan Program Studi
                                Teknik Geologi
                            </li>
                            <li>
                                <strong>2010:</strong> Memperoleh Akreditasi A
                                dari BAN-PT
                            </li>
                            <li>
                                <strong>2015:</strong> Pembukaan Program
                                Magister Teknik Pertambangan
                            </li>
                            <li>
                                <strong>2020:</strong> Pembukaan Program Doktor
                                Teknik Pertambangan
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Akreditasi Section -->
        <section id="akreditasi" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Status Akreditasi</h2>
                <p>Jaminan Kualitas Pendidikan<br /></p>
            </div>

            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Akreditasi Program Studi</h3>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Program Studi</th>
                                        <th>Jenjang</th>
                                        <th>Status Akreditasi</th>
                                        <th>Tahun Berlaku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Teknik Pertambangan</td>
                                        <td>S1</td>
                                        <td>A</td>
                                        <td>2023-2028</td>
                                    </tr>
                                    <tr>
                                        <td>Teknik Perminyakan</td>
                                        <td>S1</td>
                                        <td>A</td>
                                        <td>2023-2028</td>
                                    </tr>
                                    <tr>
                                        <td>Teknik Geologi</td>
                                        <td>S1</td>
                                        <td>B</td>
                                        <td>2022-2027</td>
                                    </tr>
                                    <tr>
                                        <td>Teknik Pertambangan</td>
                                        <td>S2</td>
                                        <td>B</td>
                                        <td>2021-2026</td>
                                    </tr>
                                    <tr>
                                        <td>Teknik Pertambangan</td>
                                        <td>S3</td>
                                        <td>B</td>
                                        <td>2022-2027</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h3>Sertifikasi Internasional</h3>
                        <p>
                            Fakultas Teknik Pertambangan dan Perminyakan telah
                            memperoleh berbagai sertifikasi internasional yang
                            menjamin kualitas pendidikan sesuai standar global:
                        </p>
                        <ul>
                            <li>
                                ABET (Accreditation Board for Engineering and
                                Technology) - untuk Program Studi Teknik
                                Pertambangan
                            </li>
                            <li>
                                ASIIN (Accreditation Agency for Study Programmes
                                in Engineering, Informatics, Natural Sciences
                                and Mathematics) - untuk Program Studi Teknik
                                Perminyakan
                            </li>
                            <li>
                                Anggota The International Association of Mining
                                Schools and Institutions (IAMSI)
                            </li>
                            <li>
                                Kemitraan dengan Society of Petroleum Engineers
                                (SPE)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Program Studi Section -->
        <section id="program-studi" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Program Studi</h2>
                <p>Pilihan Program Pendidikan<br /></p>
            </div>

            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Teknik Pertambangan</h5>
                                <p class="card-text">
                                    Program studi yang mempelajari teknik
                                    ekstraksi mineral dan batubara, perencanaan
                                    tambang, dan teknologi pertambangan
                                    berkelanjutan.
                                </p>
                                <p><strong>Akreditasi:</strong> A</p>
                                <p><strong>Jenjang:</strong> S1, S2, S3</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Teknik Perminyakan</h5>
                                <p class="card-text">
                                    Program studi yang fokus pada eksplorasi,
                                    produksi, dan pengolahan minyak dan gas bumi
                                    serta energi terbarukan.
                                </p>
                                <p><strong>Akreditasi:</strong> A</p>
                                <p><strong>Jenjang:</strong> S1</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Teknik Geologi</h5>
                                <p class="card-text">
                                    Program studi yang mempelajari struktur
                                    bumi, mineral, dan proses geologi untuk
                                    eksplorasi sumber daya alam.
                                </p>
                                <p><strong>Akreditasi:</strong> B</p>
                                <p><strong>Jenjang:</strong> S1</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <StatsSection v-if="stats" :stats="stats" class="py-16" />

        <!-- Leadership Team -->
        <section v-if="Object.keys(leadership).length" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Pimpinan Fakultas
                    </h2>
                    <p class="text-lg text-gray-600">
                        Tim kepemimpinan yang berpengalaman
                    </p>
                </div>

                <div
                    v-for="(members, position) in leadership"
                    :key="position"
                    class="mb-12"
                >
                    <h3
                        class="text-xl font-semibold text-gray-900 mb-6 text-center"
                    >
                        {{ position }}
                    </h3>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                    >
                        <TeamCard
                            v-for="member in members"
                            :key="member.id"
                            :member="member"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Faculty Members -->
        <section v-if="Object.keys(faculty).length" class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Dosen & Staff
                    </h2>
                    <p class="text-lg text-gray-600">
                        Tim pengajar yang berkualitas per program studi
                    </p>
                </div>

                <div
                    v-for="(members, prodi) in faculty"
                    :key="prodi"
                    class="mb-12"
                >
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        {{ prodi }}
                    </h3>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                    >
                        <TeamCard
                            v-for="member in members"
                            :key="member.id"
                            :member="member"
                            size="compact"
                        />
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { PlayIcon } from "@heroicons/vue/24/solid";
import Modal from "@/Components/UI/Modal.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import AboutSection from "@/Components/Public/AboutSection.vue";
import StatsSection from "@/Components/Public/StatsSection.vue";
import TeamCard from "@/Components/Public/TeamCard.vue";

defineProps({
    about: Object,
    stats: Object,
    leadership: Object,
    faculty: Object,
});
const showVideo = ref(false);
</script>
