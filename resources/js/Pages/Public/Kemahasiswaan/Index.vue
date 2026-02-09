<!-- resources/js/Pages/Public/Kemahasiswaan/Index.vue -->
<script setup>
import { Head } from "@inertiajs/vue3";
import PublicLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";

defineOptions({ layout: PublicLayout });

const props = defineProps({
    statistics: Object,
    organizations: Array,
    achievements: Array,
    scholarships: Array,
});
</script>

<template>
    <Head title="Kemahasiswaan - FTPP UNIPA" />

    <div class="kemahasiswaan-page">
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Kemahasiswaan</h1>
                <p>
                    Pusat Informasi dan Layanan Mahasiswa Fakultas Teknologi
                    Pertambangan dan Perminyakan
                </p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Kemahasiswaan</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Hero Section -->
        <!-- <section class="hero-section" data-aos="fade-up">
            <div class="container">
                <div class="hero-content text-center">
                    <h1 class="hero-title">Kemahasiswaan</h1>
                    <p class="hero-subtitle">
                        Pusat Informasi dan Layanan Mahasiswa Fakultas Teknologi
                        Pertambangan dan Perminyakan
                    </p>
                </div>
            </div>
        </section> -->

        <!-- Statistics Section -->
        <section class="statistics-section py-5" data-aos="fade-up">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="stat-number">
                                {{ statistics.total_students }}
                            </div>
                            <div class="stat-label">Total Mahasiswa</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <div class="stat-number">
                                {{ statistics.active_students }}
                            </div>
                            <div class="stat-label">Mahasiswa Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <div class="stat-number">
                                {{ statistics.graduate_students }}
                            </div>
                            <div class="stat-label">Lulusan 2024</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                            <div class="stat-number">
                                {{ statistics.international_students }}
                            </div>
                            <div class="stat-label">Mahasiswa Asing</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Student Organizations Section -->
        <section class="organizations-section py-5 bg-light" data-aos="fade-up">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Organisasi Kemahasiswaan</h2>
                    <p class="section-subtitle">
                        Wadah pengembangan potensi dan kreativitas mahasiswa
                    </p>
                </div>

                <div class="row g-4">
                    <div
                        v-for="org in organizations"
                        :key="org.id"
                        class="col-md-4"
                    >
                        <div class="organization-card">
                            <div class="org-logo">
                                <img
                                    :src="org.logo"
                                    :alt="org.name"
                                    @error="
                                        $event.target.src =
                                            '/images/default-org.png'
                                    "
                                />
                            </div>
                            <div class="org-content">
                                <h4 class="org-acronym">{{ org.acronym }}</h4>
                                <h5 class="org-name">{{ org.name }}</h5>
                                <p class="org-description">
                                    {{ org.description }}
                                </p>
                                <div class="org-contact">
                                    <p class="mb-1">
                                        <i class="bi bi-person"></i>
                                        {{ org.contact_person }}
                                    </p>
                                    <p class="mb-0">
                                        <i class="bi bi-envelope"></i>
                                        {{ org.contact_email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Achievements Section -->
        <section class="achievements-section py-5" data-aos="fade-up">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Prestasi Mahasiswa</h2>
                    <p class="section-subtitle">
                        Kebanggaan dan pencapaian mahasiswa FTPP UNIPA
                    </p>
                </div>

                <div class="row g-4">
                    <div
                        v-for="achievement in achievements"
                        :key="achievement.id"
                        class="col-md-4"
                    >
                        <div class="achievement-card">
                            <div class="achievement-image">
                                <img
                                    :src="achievement.image"
                                    :alt="achievement.title"
                                    @error="
                                        $event.target.src =
                                            '/images/default-achievement.jpg'
                                    "
                                />
                                <div class="achievement-year">
                                    {{ achievement.year }}
                                </div>
                            </div>
                            <div class="achievement-content">
                                <h4 class="achievement-title">
                                    {{ achievement.title }}
                                </h4>
                                <div class="achievement-student">
                                    <i class="bi bi-person-badge"></i>
                                    {{ achievement.student_name }}
                                </div>
                                <div class="achievement-prodi">
                                    <i class="bi bi-building"></i>
                                    {{ achievement.program_studi }}
                                </div>
                                <p class="achievement-description">
                                    {{ achievement.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Scholarships Section -->
        <section class="scholarships-section py-5 bg-light" data-aos="fade-up">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Beasiswa</h2>
                    <p class="section-subtitle">
                        Program beasiswa untuk mendukung pendidikan mahasiswa
                    </p>
                </div>

                <div class="row g-4">
                    <div
                        v-for="(scholarship, index) in scholarships"
                        :key="index"
                        class="col-md-4"
                    >
                        <div class="scholarship-card">
                            <div class="scholarship-header">
                                <div class="scholarship-icon">
                                    <i class="bi bi-award-fill"></i>
                                </div>
                                <h4 class="scholarship-name">
                                    {{ scholarship.name }}
                                </h4>
                            </div>
                            <div class="scholarship-body">
                                <p class="scholarship-description">
                                    {{ scholarship.description }}
                                </p>
                                <div class="scholarship-quota">
                                    <span class="label">Kuota:</span>
                                    <span class="value"
                                        >{{ scholarship.quota }} mahasiswa</span
                                    >
                                </div>
                                <div class="scholarship-requirements">
                                    <strong>Persyaratan:</strong>
                                    <ul>
                                        <li
                                            v-for="(
                                                req, i
                                            ) in scholarship.requirements"
                                            :key="i"
                                        >
                                            {{ req }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 100px 0 60px;
    margin-top: -20px;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.95;
    max-width: 700px;
    margin: 0 auto;
}

/* Statistics Cards */
.stat-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    font-size: 3rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #7f8c8d;
    font-size: 0.95rem;
    font-weight: 500;
}

/* Section Headers */
.section-header {
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
}

.section-subtitle {
    color: #7f8c8d;
    font-size: 1.1rem;
}

/* Organization Cards */
.organization-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    height: 100%;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.organization-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.org-logo {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #f8f9fa;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.org-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.org-acronym {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
}

.org-name {
    font-size: 1rem;
    color: #2c3e50;
    margin-bottom: 1rem;
    font-weight: 600;
}

.org-description {
    color: #7f8c8d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.org-contact p {
    font-size: 0.9rem;
    color: #95a5a6;
}

.org-contact i {
    margin-right: 0.5rem;
    color: #667eea;
}

/* Achievement Cards */
.achievement-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
    height: 100%;
}

.achievement-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.achievement-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.achievement-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.achievement-card:hover .achievement-image img {
    transform: scale(1.1);
}

.achievement-year {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.achievement-content {
    padding: 1.5rem;
}

.achievement-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.achievement-student,
.achievement-prodi {
    font-size: 0.9rem;
    color: #7f8c8d;
    margin-bottom: 0.5rem;
}

.achievement-student i,
.achievement-prodi i {
    margin-right: 0.5rem;
    color: #667eea;
}

.achievement-description {
    color: #95a5a6;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-top: 1rem;
}

/* Scholarship Cards */
.scholarship-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
    height: 100%;
}

.scholarship-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.scholarship-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem;
    text-align: center;
    color: white;
}

.scholarship-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.scholarship-name {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
}

.scholarship-body {
    padding: 1.5rem;
}

.scholarship-description {
    color: #7f8c8d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.scholarship-quota {
    background: #f8f9fa;
    padding: 0.8rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.scholarship-quota .label {
    font-weight: 600;
    color: #2c3e50;
    margin-right: 0.5rem;
}

.scholarship-quota .value {
    color: #667eea;
    font-weight: 600;
}

.scholarship-requirements {
    margin-top: 1rem;
}

.scholarship-requirements strong {
    color: #2c3e50;
    display: block;
    margin-bottom: 0.5rem;
}

.scholarship-requirements ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.scholarship-requirements li {
    padding: 0.4rem 0;
    color: #7f8c8d;
    position: relative;
    padding-left: 1.5rem;
}

.scholarship-requirements li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #667eea;
    font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }

    .hero-subtitle {
        font-size: 1rem;
    }

    .section-title {
        font-size: 2rem;
    }

    .stat-number {
        font-size: 2rem;
    }
}
</style>
