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
                        <li><a href="/">Home</a></li>
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
                    <div v-if="props.sejarah" class="col-lg-12">
                        <h3>Sejarah Singkat</h3>
                        <p>
                            {{ props.sejarah }}
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
                                    <tr
                                        v-for="prodi in programStudi"
                                        :key="prodi.id"
                                    >
                                        <td>{{ prodi.name }}</td>
                                        <td>{{ prodi.degree_level }}</td>
                                        <td>{{ prodi.accreditation }}</td>
                                        <td>
                                            {{
                                                prodi.accreditation_date &&
                                                prodi.accreditation_expire
                                                    ? `${new Date(
                                                          prodi.accreditation_date
                                                      ).getFullYear()}-${new Date(
                                                          prodi.accreditation_expire
                                                      ).getFullYear()}`
                                                    : "-"
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="program-studi" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Program Studi</h2>
                <p>Pilihan Program Pendidikan<br /></p>
            </div>

            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div
                        v-for="(prodi, index) in programStudiCards"
                        :key="prodi.code || index"
                        class="col-lg-3 col-md-6 mb-4"
                    >
                        <div class="card h-100">
                            <img
                                v-if="prodi.image_url"
                                :src="prodi.image_url"
                                class="card-img-top"
                                :alt="prodi.name"
                                style="height: 200px; object-fit: cover"
                            />
                            <div class="card-body">
                                <h5 class="card-title">{{ prodi.name }}</h5>
                                <p class="card-text">
                                    {{
                                        prodi.description ||
                                        prodi.overview ||
                                        "Deskripsi program studi belum tersedia."
                                    }}
                                </p>
                                <p>
                                    <strong>Akreditasi:</strong>
                                    {{ prodi.accreditation }}
                                </p>
                                <p>
                                    <strong>Jenjang:</strong>
                                    {{ prodi.degree_level }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Fallback cards jika data kosong -->
                    <template
                        v-if="
                            !programStudiCards || programStudiCards.length === 0
                        "
                    >
                        <!-- Default cards sama seperti di React -->
                    </template>
                </div>
            </div>
        </section>

        <section id="stats" class="stats section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div class="stat-item">
                        <div class="stat-number">
                            {{ formatNumber(stats.total_students) }}
                        </div>
                        <div class="stat-label">Mahasiswa</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            {{ formatNumber(stats.total_lecturers) }}
                        </div>
                        <div class="stat-label">Dosen</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            {{ formatNumber(stats.total_alumni) }}
                        </div>
                        <div class="stat-label">Alumni</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">
                            {{ formatNumber(stats.total_partnerships) }}
                        </div>
                        <div class="stat-label">Mitra Kerja</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Leadership Team -->
        <section
            v-if="Object.keys(leadership).length"
            class="starter-section section"
        >
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
        <section
            v-if="Object.keys(faculty).length"
            class="starter-section section"
        >
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

function formatNumber(num) {
    return new Intl.NumberFormat("id-ID").format(num);
}

// defineProps({
//     about: Object,
//     stats: Object,
//     leadership: Object,
//     faculty: Object,
// });

const props = defineProps({
    sejarah: String,
    about: Object,
    stats: Object,
    leadership: Object,
    faculty: Object,
    programStudi: Array,
    programStudiCards: Array,
});
const showVideo = ref(false);
</script>
