<template>
    <AppLayout>
        <!-- Page Title -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>{{ pageTitle }}</h1>
                <p>{{ pageDescription }}</p>
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

                <!-- Target Filter Tabs -->
                <div
                    v-if="hasActiveSurveys"
                    class="row mb-8"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div class="col-12">
                        <div class="filter-tabs">
                            <button
                                @click="filterByTarget(null)"
                                :class="[
                                    'filter-tab',
                                    !currentTarget && 'active',
                                ]"
                            >
                                <span class="tab-label">Semua Survey</span>
                                <span class="tab-badge">{{
                                    surveys.length
                                }}</span>
                            </button>
                            <button
                                v-for="(target, key) in targets"
                                :key="key"
                                @click="filterByTarget(key)"
                                :class="[
                                    'filter-tab',
                                    currentTarget === key && 'active',
                                    `filter-tab-${target.color}`,
                                ]"
                                v-show="target.count > 0"
                            >
                                <span class="tab-label">{{
                                    target.label
                                }}</span>
                                <span class="tab-badge">{{
                                    target.count
                                }}</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active Surveys List -->
                <div
                    v-if="hasActiveSurveys"
                    class="row gy-4"
                    data-aos="fade-up"
                    data-aos-delay="150"
                >
                    <div
                        v-for="survey in surveys"
                        :key="survey.id"
                        class="col-lg-6"
                    >
                        <div class="survey-card">
                            <!-- Survey Header -->
                            <div class="survey-header">
                                <div class="survey-meta">
                                    <span
                                        :class="[
                                            'badge',
                                            `badge-${getTargetColor(
                                                survey.target_respondent,
                                            )}`,
                                        ]"
                                    >
                                        {{ survey.target_respondent_label }}
                                    </span>
                                    <span
                                        v-if="survey.is_anonymous"
                                        class="badge badge-gray"
                                        title="Survey Anonim"
                                    >
                                        <svg
                                            class="badge-icon"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                clip-rule="evenodd"
                                            />
                                            <path
                                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"
                                            />
                                        </svg>
                                        Anonim
                                    </span>
                                </div>
                                <h3 class="survey-title">{{ survey.title }}</h3>
                                <p
                                    v-if="survey.description"
                                    class="survey-description"
                                >
                                    {{ survey.description }}
                                </p>
                            </div>

                            <!-- Survey Info -->
                            <div class="survey-info">
                                <div class="info-row">
                                    <div class="info-item">
                                        <svg
                                            class="info-icon"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                        <span class="info-label">Periode:</span>
                                        <span class="info-value"
                                            >{{ survey.start_date }} -
                                            {{ survey.end_date }}</span
                                        >
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-item">
                                        <svg
                                            class="info-icon"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                            />
                                        </svg>
                                        <span class="info-label"
                                            >Pertanyaan:</span
                                        >
                                        <span class="info-value"
                                            >{{
                                                survey.total_questions
                                            }}
                                            soal</span
                                        >
                                    </div>

                                    <div class="info-item">
                                        <svg
                                            class="info-icon"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <span class="info-label"
                                            >Sisa Waktu:</span
                                        >
                                        <span class="info-value">{{
                                            formatDaysRemaining(
                                                survey.days_remaining,
                                            )
                                        }}</span>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div
                                    v-if="survey.target_responses"
                                    class="progress-section"
                                >
                                    <div class="progress-header">
                                        <span class="progress-label"
                                            >Progress Respons</span
                                        >
                                        <span class="progress-percentage"
                                            >{{
                                                survey.completion_percentage
                                            }}%</span
                                        >
                                    </div>
                                    <div class="progress-bar-wrapper">
                                        <div
                                            class="progress-bar"
                                            :style="{
                                                width: `${survey.completion_percentage}%`,
                                            }"
                                        ></div>
                                    </div>
                                    <div class="progress-count">
                                        {{ survey.total_responses }} dari
                                        {{ survey.target_responses }} target
                                        responden
                                    </div>
                                </div>
                            </div>

                            <!-- Survey Footer -->
                            <div class="survey-footer">
                                <a
                                    href=""
                                    v-if="survey.can_be_filled"
                                    :href="survey.survey_url"
                                    class="btn-fill-survey"
                                >
                                    <svg
                                        class="btn-icon"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                        />
                                    </svg>
                                    Isi Survey
                                </a>
                                <div v-else class="survey-closed">
                                    <svg
                                        class="closed-icon"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <span>Survey Tidak Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12">
                        <div class="empty-state">
                            <svg
                                class="empty-icon"
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
                            <h3 class="empty-title">Belum Ada Survey Aktif</h3>
                            <p class="empty-description">
                                Survey akan muncul di sini ketika admin
                                mengaktifkannya. <br />Silakan cek kembali nanti
                                atau hubungi GPM FTPP.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Guidelines Section -->
        <section
            v-if="hasActiveSurveys"
            class="section py-8 bg-light"
            data-aos="fade-up"
            data-aos-delay="200"
        >
            <div class="container">
                <div class="section-title text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">
                        Panduan Mengisi Survey
                    </h3>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-4">
                        <div class="guide-card">
                            <div class="guide-number">1</div>
                            <h4 class="guide-title">Pilih Survey</h4>
                            <p class="guide-text">
                                Pilih survey yang relevan dengan status Anda
                                (mahasiswa, dosen, alumni, dll)
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="guide-card">
                            <div class="guide-number">2</div>
                            <h4 class="guide-title">Isi dengan Jujur</h4>
                            <p class="guide-text">
                                Berikan jawaban yang jujur dan objektif untuk
                                setiap pertanyaan
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="guide-card">
                            <div class="guide-number">3</div>
                            <h4 class="guide-title">Submit</h4>
                            <p class="guide-text">
                                Pastikan semua pertanyaan telah dijawab sebelum
                                mengirimkan survey
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navigation Section -->
        <section class="section py-8">
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
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    pageTitle: {
        type: String,
        required: true,
    },
    pageDescription: {
        type: String,
        required: true,
    },
    surveys: {
        type: Array,
        default: () => [],
    },
    targets: {
        type: Object,
        default: () => ({}),
    },
    hasActiveSurveys: {
        type: Boolean,
        default: false,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
});

const currentTarget = ref(props.filters?.target || null);

// Filter surveys by target
const filterByTarget = (target) => {
    currentTarget.value = target;
    router.get(
        route("gpm.survey-kepuasan"),
        { target: target },
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

// Get target color class
const getTargetColor = (target) => {
    const colors = {
        mahasiswa: "blue",
        dosen: "green",
        alumni: "purple",
        stakeholder: "orange",
    };
    return colors[target] || "gray";
};

// Format days remaining
const formatDaysRemaining = (days) => {
    if (days < 0) return "Sudah berakhir";
    if (days === 0) return "Hari ini";
    if (days === 1) return "1 hari lagi";
    return `${days} hari lagi`;
};
</script>

<style scoped>
/* Filter Tabs */
.filter-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.filter-tab {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    background: white;
    color: #4a5568;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-tab:hover {
    border-color: #cbd5e0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.filter-tab.active {
    background: #667eea;
    border-color: #667eea;
    color: white;
}

.filter-tab-blue.active {
    background: #3b82f6;
    border-color: #3b82f6;
}

.filter-tab-green.active {
    background: #10b981;
    border-color: #10b981;
}

.filter-tab-purple.active {
    background: #9333ea;
    border-color: #9333ea;
}

.filter-tab-orange.active {
    background: #f97316;
    border-color: #f97316;
}

.tab-badge {
    padding: 4px 10px;
    background: #f7fafc;
    color: #2d3748;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 700;
}

.filter-tab.active .tab-badge {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

/* Survey Card */
.survey-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.survey-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.survey-header {
    padding: 1.5rem;
    border-bottom: 2px solid #f7fafc;
}

.survey-meta {
    display: flex;
    gap: 8px;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-blue {
    background: #dbeafe;
    color: #1e40af;
}

.badge-green {
    background: #d1fae5;
    color: #065f46;
}

.badge-purple {
    background: #f3e8ff;
    color: #6b21a8;
}

.badge-orange {
    background: #ffedd5;
    color: #9a3412;
}

.badge-gray {
    background: #f3f4f6;
    color: #374151;
}

.badge-icon {
    width: 14px;
    height: 14px;
}

.survey-title {
    margin: 0 0 0.75rem 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a202c;
    line-height: 1.3;
}

.survey-description {
    margin: 0;
    color: #718096;
    font-size: 0.95rem;
    line-height: 1.6;
}

.survey-info {
    padding: 1.5rem;
    flex: 1;
}

.info-row {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 16px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
}

.info-icon {
    width: 18px;
    height: 18px;
    color: #667eea;
    flex-shrink: 0;
}

.info-label {
    color: #718096;
    font-weight: 500;
}

.info-value {
    color: #2d3748;
    font-weight: 600;
}

/* Progress Section */
.progress-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f7fafc;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.progress-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
}

.progress-percentage {
    font-size: 0.875rem;
    font-weight: 700;
    color: #667eea;
}

.progress-bar-wrapper {
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
    transition: width 0.5s ease;
}

.progress-count {
    margin-top: 6px;
    font-size: 0.75rem;
    color: #718096;
    text-align: right;
}

/* Survey Footer */
.survey-footer {
    padding: 1.5rem;
    background: #f7fafc;
    border-top: 2px solid #e2e8f0;
}

.btn-fill-survey {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 700;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-fill-survey:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-icon {
    width: 20px;
    height: 20px;
}

.survey-closed {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 14px 24px;
    background: #f3f4f6;
    color: #6b7280;
    font-weight: 600;
    border-radius: 8px;
}

.closed-icon {
    width: 20px;
    height: 20px;
}

/* Empty State */
.empty-state {
    background: white;
    padding: 4rem 2rem;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.empty-icon {
    width: 96px;
    height: 96px;
    color: #cbd5e0;
    margin: 0 auto 1.5rem;
}

.empty-title {
    margin: 0 0 0.75rem 0;
    font-size: 1.75rem;
    font-weight: 700;
    color: #4a5568;
}

.empty-description {
    margin: 0;
    color: #718096;
    font-size: 1rem;
    line-height: 1.6;
}

/* Guide Cards */
.guide-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    height: 100%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.guide-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}

.guide-number {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 2rem;
    font-weight: 700;
    border-radius: 50%;
}

.guide-title {
    margin: 0 0 0.75rem 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3748;
}

.guide-text {
    margin: 0;
    color: #718096;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-tabs {
        gap: 8px;
    }

    .filter-tab {
        padding: 10px 16px;
        font-size: 0.875rem;
    }

    .survey-title {
        font-size: 1.25rem;
    }

    .info-row {
        gap: 8px;
    }

    .guide-number {
        width: 56px;
        height: 56px;
        font-size: 1.75rem;
    }
}
</style>
