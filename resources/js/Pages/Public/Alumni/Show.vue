<!-- resources/js/Pages/Public/Alumni/Show.vue -->
<script setup>
import { Head, Link } from "@inertiajs/vue3";
import PublicLayout from "@/Layouts/AppLayout.vue";

defineOptions({ layout: PublicLayout });

const props = defineProps({
    alumni: Object,
});
</script>

<template>
    <Head :title="`${alumni.name} - Alumni FTPP UNIPA`" />

    <div
        class="page-title dark-background"
        data-aos="fade"
        style="background-image: url(/storage/assets/img/imgBg3.png)"
    >
        <div class="container position-relative">
            <h1>Alumni FTPP UNIPA</h1>
            <p>Jejak Prestasi dan Kontribusi Alumni di Dunia Industri</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li><a href="/alumni">Alumni FTPP UNIPA</a></li>
                    <li class="current">{{ alumni.name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="alumni-detail-page">
        <!-- Profile Section -->
        <section class="profile-section py-5" data-aos="fade-up">
            <div class="container">
                <div class="row">
                    <!-- Left Column - Photo & Basic Info -->
                    <div class="col-lg-4">
                        <div class="profile-card sticky-top">
                            <div class="profile-photo-wrapper">
                                <img
                                    :src="alumni.photo"
                                    :alt="alumni.name"
                                    class="profile-photo"
                                    @error="
                                        $event.target.src =
                                            '/images/default-avatar.png'
                                    "
                                />
                            </div>

                            <div class="profile-basic-info">
                                <h2 class="profile-name">{{ alumni.name }}</h2>
                                <p class="profile-nim">NIM: {{ alumni.nim }}</p>
                                <div class="profile-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-building"></i>
                                        <span>{{ alumni.program_studi }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-calendar-check"></i>
                                        <span
                                            >Lulus
                                            {{ alumni.graduation_year }}</span
                                        >
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-award"></i>
                                        <span>IPK: {{ alumni.ipk }}</span>
                                    </div>
                                </div>

                                <!-- Social Links -->
                                <div class="social-links-detail">
                                    <a
                                        href=""
                                        v-if="alumni.linkedin_url"
                                        :href="alumni.linkedin_url"
                                        target="_blank"
                                        class="social-link linkedin"
                                    >
                                        <i class="bi bi-linkedin"></i>
                                        LinkedIn
                                    </a>

                                    <a
                                        href=""
                                        v-if="alumni.instagram_url"
                                        :href="alumni.instagram_url"
                                        target="_blank"
                                        class="social-link instagram"
                                    >
                                        <i class="bi bi-instagram"></i>
                                        Instagram
                                    </a>
                                </div>

                                <!-- Contact Info -->
                                <div class="contact-info">
                                    <h5 class="contact-title">
                                        Informasi Kontak
                                    </h5>
                                    <div class="contact-item">
                                        <i class="bi bi-envelope"></i>
                                        <a :href="`mailto:${alumni.email}`">{{
                                            alumni.email
                                        }}</a>
                                    </div>
                                    <div class="contact-item">
                                        <i class="bi bi-telephone"></i>
                                        <a :href="`tel:${alumni.phone}`">{{
                                            alumni.phone
                                        }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Detailed Info -->
                    <div class="col-lg-8">
                        <!-- Current Position -->
                        <div class="detail-section" data-aos="fade-up">
                            <div class="section-icon">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                            <h3 class="detail-section-title">
                                Posisi Saat Ini
                            </h3>
                            <div class="current-job-card">
                                <div class="job-position">
                                    {{ alumni.position }}
                                </div>
                                <div class="job-company">
                                    <i class="bi bi-building"></i>
                                    {{ alumni.company }}
                                </div>
                                <div class="job-type">
                                    <span class="badge-job">{{
                                        alumni.current_job
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Career History -->
                        <div class="detail-section" data-aos="fade-up">
                            <div class="section-icon">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <h3 class="detail-section-title">Riwayat Karir</h3>
                            <div class="career-timeline">
                                <div
                                    v-for="(
                                        career, index
                                    ) in alumni.career_history"
                                    :key="index"
                                    class="timeline-item"
                                >
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-year">
                                            {{ career.year }}
                                        </div>
                                        <div class="timeline-position">
                                            {{ career.position }}
                                        </div>
                                        <div class="timeline-company">
                                            {{ career.company }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial -->
                        <div class="detail-section" data-aos="fade-up">
                            <div class="section-icon">
                                <i class="bi bi-chat-quote"></i>
                            </div>
                            <h3 class="detail-section-title">Testimoni</h3>
                            <div class="testimonial-card">
                                <i class="bi bi-quote quote-icon"></i>
                                <p class="testimonial-text">
                                    {{ alumni.testimonial }}
                                </p>
                            </div>
                        </div>

                        <!-- Achievements -->
                        <div class="detail-section" data-aos="fade-up">
                            <div class="section-icon">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <h3 class="detail-section-title">
                                Prestasi & Penghargaan
                            </h3>
                            <div class="achievements-list">
                                <div
                                    v-for="(
                                        achievement, index
                                    ) in alumni.achievements"
                                    :key="index"
                                    class="achievement-item"
                                >
                                    <div class="achievement-icon">
                                        <i class="bi bi-award-fill"></i>
                                    </div>
                                    <div class="achievement-text">
                                        {{ achievement }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <div class="action-buttons" data-aos="fade-up">
                            <Link href="/alumni" class="btn-back">
                                <i class="bi bi-arrow-left"></i>
                                Kembali ke Direktori Alumni
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
/* Breadcrumb */
.breadcrumb-section {
    background: #f8f9fa;
    padding: 1.5rem 0;
    margin-top: -20px;
}

.breadcrumb {
    background: transparent;
    margin: 0;
    padding: 0;
}

.breadcrumb-item a {
    color: #667eea;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Profile Card */
.profile-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    top: 100px;
}

.profile-photo-wrapper {
    height: 400px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
}

.profile-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-basic-info {
    padding: 2rem;
}

.profile-name {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.profile-nim {
    color: #95a5a6;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
}

.profile-meta {
    margin-bottom: 2rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.meta-item:last-child {
    border-bottom: none;
}

.meta-item i {
    color: #667eea;
    font-size: 1.2rem;
    width: 25px;
}

.meta-item span {
    color: #2c3e50;
    font-weight: 500;
}

/* Social Links */
.social-links-detail {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin-bottom: 2rem;
}

.social-link {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 1.2rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.social-link:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.social-link.linkedin {
    background: #0077b5;
    color: white;
}

.social-link.instagram {
    background: linear-gradient(
        45deg,
        #f09433 0%,
        #e6683c 25%,
        #dc2743 50%,
        #cc2366 75%,
        #bc1888 100%
    );
    color: white;
}

/* Contact Info */
.contact-info {
    border-top: 2px solid #f0f0f0;
    padding-top: 1.5rem;
}

.contact-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.6rem 0;
}

.contact-item i {
    color: #667eea;
    font-size: 1.1rem;
}

.contact-item a {
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-item a:hover {
    color: #667eea;
}

/* Detail Sections */
.detail-section {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    position: relative;
}

.section-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    margin-bottom: 1.5rem;
}

.detail-section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
}

/* Current Job Card */
.current-job-card {
    background: linear-gradient(135deg, #fff5f8 0%, #ffe9e9 100%);
    border-left: 5px solid #667eea;
    padding: 2rem;
    border-radius: 10px;
}

.job-position {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.8rem;
}

.job-company {
    font-size: 1.2rem;
    color: #7f8c8d;
    margin-bottom: 1rem;
}

.job-company i {
    margin-right: 0.5rem;
    color: #667eea;
}

.badge-job {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1.2rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

/* Career Timeline */
.career-timeline {
    position: relative;
    padding-left: 2rem;
}

.career-timeline::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-marker {
    position: absolute;
    left: -2.5rem;
    top: 0;
    width: 15px;
    height: 15px;
    background: white;
    border: 3px solid #667eea;
    border-radius: 50%;
}

.timeline-content {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
}

.timeline-year {
    color: #667eea;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.timeline-position {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.3rem;
}

.timeline-company {
    color: #7f8c8d;
}

/* Testimonial */
.testimonial-card {
    background: linear-gradient(135deg, #fff5f8 0%, #ffe9e9 100%);
    padding: 2.5rem;
    border-radius: 15px;
    position: relative;
}

.quote-icon {
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 4rem;
    color: #f093fb;
    opacity: 0.2;
}

.testimonial-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #2c3e50;
    font-style: italic;
    margin: 0;
    position: relative;
    z-index: 1;
}

/* Achievements */
.achievements-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.achievement-item {
    display: flex;
    align-items: start;
    gap: 1rem;
    background: #f8f9fa;
    padding: 1.2rem;
    border-radius: 10px;
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.achievement-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.achievement-icon {
    flex-shrink: 0;
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #2c3e50;
}

.achievement-text {
    flex: 1;
    color: #2c3e50;
    font-weight: 500;
    line-height: 1.6;
}

/* Action Buttons */
.action-buttons {
    margin-top: 3rem;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 2rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.btn-back:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(245, 87, 108, 0.3);
    color: white;
}

/* Responsive */
@media (max-width: 991px) {
    .profile-card {
        position: static !important;
        margin-bottom: 2rem;
    }
}

@media (max-width: 768px) {
    .profile-photo-wrapper {
        height: 300px;
    }

    .profile-name {
        font-size: 1.5rem;
    }

    .detail-section-title {
        font-size: 1.3rem;
    }
}
</style>
