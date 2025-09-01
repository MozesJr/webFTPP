<template>
    <AppLayout>
        <!-- Hero Section -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>EDOM</h1>
                <p>Evaluasi Dosen Oleh Mahasiswa</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">EDOM</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <section class="py-5">
            <div class="container">
                <!-- Introduction -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-8 text-center">
                        <h2 class="mb-4">Kuesioner Evaluasi Dosen</h2>
                        <p class="lead text-muted">
                            Berpartisipasilah dalam evaluasi dosen untuk
                            meningkatkan kualitas pendidikan. Pilih program
                            studi Anda dan isi evaluasi yang tersedia.
                        </p>
                    </div>
                </div>

                <!-- Available Questionnaires by Program Studi -->
                <div v-if="questionnaires.length > 0" class="row">
                    <div
                        v-for="questionnaire in questionnaires"
                        :key="questionnaire.id"
                        class="col-lg-6 col-xl-4 mb-4"
                    >
                        <div
                            class="card h-100 shadow-sm border-0 questionnaire-card"
                        >
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    {{
                                        questionnaire.program_studi?.name ||
                                        "N/A"
                                    }}
                                </h5>
                                <small class="opacity-75">
                                    {{ questionnaire.semester }}
                                    {{ questionnaire.academic_year }}
                                </small>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-subtitle mb-3 text-primary">
                                    {{ questionnaire.title }}
                                </h6>

                                <p
                                    v-if="questionnaire.description"
                                    class="card-text text-muted small mb-3"
                                >
                                    {{ questionnaire.description }}
                                </p>

                                <!-- Status Info -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i
                                            class="bi bi-calendar-check text-success me-2"
                                        ></i>
                                        <small class="text-success">
                                            <strong>Tersedia</strong>
                                        </small>
                                    </div>

                                    <div
                                        v-if="
                                            questionnaire.start_date ||
                                            questionnaire.end_date
                                        "
                                        class="mb-2"
                                    >
                                        <i
                                            class="bi bi-clock text-muted me-2"
                                        ></i>
                                        <small class="text-muted">
                                            <span
                                                v-if="questionnaire.start_date"
                                            >
                                                Mulai:
                                                {{
                                                    formatDate(
                                                        questionnaire.start_date
                                                    )
                                                }}
                                            </span>
                                            <span
                                                v-if="
                                                    questionnaire.start_date &&
                                                    questionnaire.end_date
                                                "
                                            >
                                                -
                                            </span>
                                            <span v-if="questionnaire.end_date">
                                                Berakhir:
                                                {{
                                                    formatDate(
                                                        questionnaire.end_date
                                                    )
                                                }}
                                            </span>
                                        </small>
                                    </div>

                                    <div class="mb-2">
                                        <i
                                            class="bi bi-question-circle text-info me-2"
                                        ></i>
                                        <small class="text-muted">
                                            {{
                                                getTotalQuestions(questionnaire)
                                            }}
                                            pertanyaan
                                        </small>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-auto">
                                    <Link
                                        :href="
                                            route(
                                                'evaluation.create',
                                                questionnaire.id
                                            )
                                        "
                                        class="btn btn-primary btn-block w-100"
                                    >
                                        <i class="bi bi-pencil-square me-2"></i>
                                        Mulai Evaluasi
                                    </Link>
                                </div>
                            </div>

                            <!-- Card Footer with additional info -->
                            <div class="card-footer bg-light border-0">
                                <div class="row text-center small text-muted">
                                    <div class="col-6">
                                        <i class="bi bi-people me-1"></i>
                                        <span
                                            >{{
                                                questionnaire.categories
                                                    ?.length || 0
                                            }}
                                            Kategori</span
                                        >
                                    </div>
                                    <div class="col-6">
                                        <i class="bi bi-star me-1"></i>
                                        <span>Skala 1-4</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <div class="py-5">
                            <i
                                class="bi bi-inbox display-1 text-muted mb-4"
                            ></i>
                            <h4 class="text-muted mb-3">
                                Belum Ada Evaluasi Tersedia
                            </h4>
                            <p class="text-muted mb-4">
                                Saat ini belum ada kuesioner evaluasi yang
                                aktif. Silakan periksa kembali nanti atau
                                hubungi bagian akademik untuk informasi lebih
                                lanjut.
                            </p>
                            <Link href="/" class="btn btn-outline-primary">
                                <i class="bi bi-house me-2"></i>
                                Kembali ke Beranda
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Information Section -->
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-10">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center mb-3">
                                        <i
                                            class="bi bi-shield-check display-6 text-primary mb-3"
                                        ></i>
                                        <h6>Anonim & Aman</h6>
                                        <p class="small text-muted">
                                            Evaluasi Anda bersifat anonim dan
                                            data akan dijaga kerahasiaannya.
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-center mb-3">
                                        <i
                                            class="bi bi-clock display-6 text-success mb-3"
                                        ></i>
                                        <h6>Efisien & Cepat</h6>
                                        <p class="small text-muted">
                                            Proses evaluasi dapat diselesaikan
                                            dalam waktu 10-15 menit.
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-center mb-3">
                                        <i
                                            class="bi bi-graph-up display-6 text-warning mb-3"
                                        ></i>
                                        <h6>Berkontribusi</h6>
                                        <p class="small text-muted">
                                            Bantuan Anda sangat berharga untuk
                                            peningkatan kualitas pendidikan.
                                        </p>
                                    </div>
                                </div>
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

// Props
const props = defineProps({
    questionnaires: {
        type: Array,
        default: () => [],
    },
});

// Methods
const formatDate = (dateString) => {
    if (!dateString) return "";

    return new Date(dateString).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};

const getTotalQuestions = (questionnaire) => {
    if (!questionnaire.categories) return 0;

    return questionnaire.categories.reduce((total, category) => {
        return total + (category.questions?.length || 0);
    }, 0);
};
</script>

<style scoped>
.questionnaire-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.questionnaire-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.card-header {
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.btn-block {
    transition: all 0.2s ease-in-out;
}

.btn-block:hover {
    transform: scale(1.02);
}

.page-title {
    min-height: 300px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    position: relative;
}

.page-title::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
}

.page-title .container {
    z-index: 1;
}

.page-title h1 {
    font-size: 3rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
}

.page-title p {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
}

.breadcrumbs ol {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
}

.breadcrumbs li {
    margin-right: 0.5rem;
}

.breadcrumbs li:not(:last-child)::after {
    content: "/";
    margin-left: 0.5rem;
    color: rgba(255, 255, 255, 0.7);
}

.breadcrumbs a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumbs a:hover {
    color: white;
}

.breadcrumbs .current {
    color: white;
    font-weight: 500;
}

.display-1 {
    font-size: 5rem;
}

.display-6 {
    font-size: 2.5rem;
}
</style>
