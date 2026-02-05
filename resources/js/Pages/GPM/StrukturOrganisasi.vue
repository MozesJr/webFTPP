<template>
    <AppLayout>
        <!-- Page Title -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>{{ pageTitle }}</h1>
                <p>{{ pageDescription }}</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/evaluation">GPM</Link></li>
                        <li class="current">Struktur Organisasi</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Empty State -->
        <section v-if="!hasData" class="section py-16">
            <div class="container">
                <div class="row" data-aos="fade-up">
                    <div class="col-12">
                        <div class="alert alert-info text-center p-5">
                            <svg
                                class="w-16 h-16 text-blue-600 mx-auto mb-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <h4 class="mb-3">Data Belum Tersedia</h4>
                            <p class="mb-0 text-muted">
                                Struktur organisasi GPM sedang dalam proses
                                penyusunan. <br />Silakan kembali lagi nanti
                                atau hubungi administrator.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Members Section -->
        <section v-if="hasData && featured.length > 0" class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Pimpinan GPM</h2>
                    <p>Pimpinan Gugus Penjaminan Mutu FTPP</p>
                </div>

                <div class="row gy-4 justify-content-center">
                    <div
                        v-for="member in featured"
                        :key="member.id"
                        class="col-lg-4 col-md-6"
                        data-aos="fade-up"
                        :data-aos-delay="100 * (featured.indexOf(member) + 1)"
                    >
                        <div class="team-member featured-member">
                            <div class="member-img">
                                <img
                                    :src="member.photo_url"
                                    :alt="member.nama"
                                    class="img-fluid"
                                    loading="lazy"
                                    @error="handleImageError"
                                />
                                <div class="featured-badge">
                                    <svg
                                        class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>{{ member.nama }}</h4>
                                <span class="position">{{
                                    member.jabatan
                                }}</span>
                                <div class="member-meta mt-3">
                                    <p v-if="member.nip !== '-'" class="nip">
                                        <strong>NIP:</strong> {{ member.nip }}
                                    </p>
                                    <p
                                        v-if="member.email !== '-'"
                                        class="email"
                                    >
                                        <svg
                                            class="icon"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"
                                            />
                                            <path
                                                d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"
                                            />
                                        </svg>
                                        <a :href="`mailto:${member.email}`">{{
                                            member.email
                                        }}</a>
                                    </p>
                                    <p
                                        v-if="member.phone !== '-'"
                                        class="phone"
                                    >
                                        <svg
                                            class="icon"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"
                                            />
                                        </svg>
                                        <a :href="`tel:${member.phone}`">{{
                                            member.phone
                                        }}</a>
                                    </p>
                                </div>
                                <div
                                    v-if="member.tugas_fungsi"
                                    class="member-description mt-3"
                                >
                                    <p>{{ member.tugas_fungsi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Regular Members Section -->
        <section
            v-if="hasData && regular.length > 0"
            class="section py-16 bg-light"
        >
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Anggota GPM</h2>
                    <p>Tim Gugus Penjaminan Mutu FTPP</p>
                </div>

                <div class="row gy-4">
                    <div
                        v-for="member in regular"
                        :key="member.id"
                        class="col-lg-3 col-md-4 col-sm-6"
                        data-aos="fade-up"
                        :data-aos-delay="100 * (regular.indexOf(member) + 1)"
                    >
                        <div class="team-member regular-member">
                            <div class="member-img">
                                <img
                                    :src="member.photo_url"
                                    :alt="member.nama"
                                    class="img-fluid"
                                    loading="lazy"
                                    @error="handleImageError"
                                />
                            </div>
                            <div class="member-info">
                                <h5>{{ member.nama }}</h5>
                                <span class="position">{{
                                    member.jabatan
                                }}</span>
                                <div class="member-contact mt-2">
                                    <a
                                        href=""
                                        v-if="member.email !== '-'"
                                        :href="`mailto:${member.email}`"
                                        class="contact-link"
                                        title="Email"
                                    >
                                        <svg
                                            class="icon"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"
                                            />
                                            <path
                                                d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"
                                            />
                                        </svg>
                                    </a>

                                    <a
                                        href=""
                                        v-if="member.phone !== '-'"
                                        :href="`tel:${member.phone}`"
                                        class="contact-link"
                                        title="Phone"
                                    >
                                        <svg
                                            class="icon"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"
                                            />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tugas dan Fungsi Section -->
        <section
            v-if="hasData"
            class="section py-16"
            data-aos="fade-up"
            data-aos-delay="300"
        >
            <div class="container">
                <div class="section-title text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900">
                        Tugas dan Fungsi GPM
                    </h3>
                </div>

                <div class="row gy-4">
                    <!-- Tugas Utama -->
                    <div class="col-lg-6">
                        <div class="info-card h-100">
                            <div class="card-header">
                                <svg
                                    class="icon"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <h4>Tugas Utama</h4>
                            </div>
                            <ul class="info-list">
                                <li>
                                    Melaksanakan penjaminan mutu internal di
                                    tingkat fakultas
                                </li>
                                <li>
                                    Melakukan monitoring dan evaluasi
                                    pelaksanaan standar mutu
                                </li>
                                <li>
                                    Menyusun laporan hasil audit mutu internal
                                </li>
                                <li>Memberikan rekomendasi perbaikan mutu</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Fungsi -->
                    <div class="col-lg-6">
                        <div class="info-card h-100">
                            <div class="card-header">
                                <svg
                                    class="icon"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <h4>Fungsi</h4>
                            </div>
                            <ul class="info-list">
                                <li>Perencanaan sistem penjaminan mutu</li>
                                <li>Pelaksanaan standar mutu akademik</li>
                                <li>Evaluasi dan pengendalian mutu</li>
                                <li>
                                    Peningkatan berkelanjutan (continuous
                                    improvement)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navigation Section -->
        <section class="section py-8 bg-light">
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
                                    <svg
                                        class="btn-icon"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"
                                        />
                                        <path
                                            fill-rule="evenodd"
                                            d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    GPM Home
                                </Link>
                                <Link
                                    href="/gpm/dokumen-spmi"
                                    class="btn btn-outline-primary"
                                >
                                    Dokumen SPMI
                                </Link>
                                <Link
                                    href="/gpm/survey-kepuasan"
                                    class="btn btn-outline-primary"
                                >
                                    Survey Kepuasan
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
import { Link } from "@inertiajs/vue3";
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
    strukturs: {
        type: Array,
        default: () => [],
    },
    featured: {
        type: Array,
        default: () => [],
    },
    regular: {
        type: Array,
        default: () => [],
    },
    hasData: {
        type: Boolean,
        default: false,
    },
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
});

// Handle image error - fallback to default avatar
const handleImageError = (e) => {
    e.target.src = "/images/default-avatar.png";
};
</script>

<style scoped>
/* Team Member Cards */
.team-member {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.team-member:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.member-img {
    position: relative;
    width: 100%;
    padding-top: 100%; /* 1:1 Aspect Ratio */
    overflow: hidden;
}

.featured-member .member-img {
    padding-top: 120%; /* Taller for featured */
}

.member-img img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.featured-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 8px 12px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.featured-badge svg {
    width: 1.25rem;
    height: 1.25rem;
}

.member-info {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.member-info h4,
.member-info h5 {
    margin: 0 0 0.5rem 0;
    color: #1a202c;
    font-weight: 700;
}

.member-info h4 {
    font-size: 1.25rem;
}

.member-info h5 {
    font-size: 1rem;
}

.position {
    display: inline-block;
    padding: 6px 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.member-meta {
    border-top: 1px solid #e2e8f0;
    padding-top: 1rem;
}

.member-meta p {
    margin: 0.5rem 0;
    font-size: 0.875rem;
    color: #4a5568;
    display: flex;
    align-items: center;
    gap: 8px;
}

.member-meta .icon {
    width: 1rem;
    height: 1rem;
    color: #667eea;
    flex-shrink: 0;
}

.member-meta a {
    color: #667eea;
    text-decoration: none;
    transition: color 0.2s;
}

.member-meta a:hover {
    color: #764ba2;
    text-decoration: underline;
}

.member-description {
    border-top: 1px solid #e2e8f0;
    padding-top: 1rem;
    margin-top: auto;
}

.member-description p {
    margin: 0;
    font-size: 0.875rem;
    color: #718096;
    line-height: 1.6;
}

.member-contact {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.contact-link {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.contact-link:hover {
    background: #667eea;
    transform: scale(1.1);
}

.contact-link .icon {
    width: 1rem;
    height: 1rem;
    color: #4a5568;
    transition: color 0.3s ease;
}

.contact-link:hover .icon {
    color: white;
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.info-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e2e8f0;
}

.card-header .icon {
    width: 2rem;
    height: 2rem;
    color: #667eea;
}

.card-header h4 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a202c;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    padding: 0.75rem 0;
    padding-left: 2rem;
    position: relative;
    color: #4a5568;
    line-height: 1.6;
}

.info-list li::before {
    content: "→";
    position: absolute;
    left: 0;
    color: #667eea;
    font-weight: bold;
}

/* Navigation Buttons */
.btn-outline-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.75rem 1.5rem;
    border: 2px solid #667eea;
    color: #667eea;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* Responsive */
@media (max-width: 768px) {
    .featured-member .member-img {
        padding-top: 100%;
    }

    .member-info {
        padding: 1rem;
    }

    .info-card {
        padding: 1.5rem;
    }
}
</style>
