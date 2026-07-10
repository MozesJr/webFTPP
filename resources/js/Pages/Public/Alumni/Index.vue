<!-- resources/js/Pages/Public/Alumni/Index.vue -->
<script setup>
import { Head, Link } from "@inertiajs/vue3";
import PublicLayout from "@/Layouts/AppLayout.vue";
import { ref, computed } from "vue";

defineOptions({ layout: PublicLayout });

const props = defineProps({
    statistics: Object,
    featuredAlumni: Array,
    allAlumni: Array,
    graduationYears: Array,
    programStudis: Array,
});

// Filter State
const selectedYear = ref("all");
const selectedProdi = ref("all");
const searchQuery = ref("");

// Computed Filtered Alumni
const filteredAlumni = computed(() => {
    let filtered = props.allAlumni;

    // Filter by year
    if (selectedYear.value !== "all") {
        filtered = filtered.filter(
            (alumni) => alumni.graduation_year == selectedYear.value,
        );
    }

    // Filter by program studi
    if (selectedProdi.value !== "all") {
        filtered = filtered.filter(
            (alumni) => alumni.program_studi === selectedProdi.value,
        );
    }

    // Filter by search query
    if (searchQuery.value.trim() !== "") {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter(
            (alumni) =>
                alumni.name.toLowerCase().includes(query) ||
                alumni.nim.toLowerCase().includes(query) ||
                alumni.company.toLowerCase().includes(query),
        );
    }

    return filtered;
});
</script>

<template>
    <Head title="Alumni - FTPP UNIPA" />

    <div class="alumni-page">
        <!-- Hero Section -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Alumni FTPP UNIPA</h1>
                <p>Jejak Prestasi dan Kontribusi Alumni di Dunia Industri</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Alumni FTPP UNIPA<</li>
                    </ol>
                </nav>
            </div>
        </div>

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
                                {{ statistics.total_alumni.toLocaleString() }}
                            </div>
                            <div class="stat-label">Total Alumni</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-briefcase-fill"></i>
                            </div>
                            <div class="stat-number">
                                {{
                                    statistics.employed_alumni.toLocaleString()
                                }}
                            </div>
                            <div class="stat-label">Alumni Bekerja</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div class="stat-number">
                                {{
                                    statistics.entrepreneur_alumni.toLocaleString()
                                }}
                            </div>
                            <div class="stat-label">Wirausaha</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="stat-number">
                                {{ statistics.employment_rate }}%
                            </div>
                            <div class="stat-label">Tingkat Penyerapan</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Alumni Section -->
        <section class="featured-section py-5 bg-light" data-aos="fade-up">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Alumni Berprestasi</h2>
                    <p class="section-subtitle">
                        Inspirasi dari alumni yang telah mencapai kesuksesan
                    </p>
                </div>

                <div class="row g-4">
                    <div
                        v-for="alumni in featuredAlumni"
                        :key="alumni.id"
                        class="col-lg-4 col-md-6"
                    >
                        <div class="featured-alumni-card">
                            <div class="alumni-photo-wrapper">
                                <img
                                    :src="alumni.photo"
                                    :alt="alumni.name"
                                    class="alumni-photo"
                                    @error="
                                        $event.target.src =
                                            '/images/default-avatar.png'
                                    "
                                />
                                <div class="featured-badge">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                            <div class="alumni-info">
                                <h4 class="alumni-name">{{ alumni.name }}</h4>
                                <p class="alumni-prodi">
                                    {{ alumni.program_studi }}
                                </p>
                                <p class="alumni-graduation">
                                    Lulusan {{ alumni.graduation_year }}
                                </p>
                                <div class="current-position">
                                    <div class="position-title">
                                        {{ alumni.position }}
                                    </div>
                                    <div class="company-name">
                                        <i class="bi bi-building"></i>
                                        {{ alumni.company }}
                                    </div>
                                </div>
                                <div class="alumni-testimonial">
                                    <i class="bi bi-quote"></i>
                                    <p>{{ alumni.testimonial }}</p>
                                </div>
                                <div class="alumni-achievement">
                                    <i class="bi bi-trophy-fill"></i>
                                    {{ alumni.achievements }}
                                </div>
                                <div class="social-links">
                                    <a
                                        href=""
                                        v-if="alumni.linkedin_url"
                                        :href="alumni.linkedin_url"
                                        target="_blank"
                                        class="social-link linkedin"
                                    >
                                        <i class="bi bi-linkedin"></i>
                                    </a>
                                    <Link
                                        :href="`/alumni/${alumni.id}`"
                                        class="btn-detail"
                                    >
                                        Lihat Profil
                                        <i class="bi bi-arrow-right"></i>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- All Alumni Section with Filters -->
        <section class="all-alumni-section py-5" data-aos="fade-up">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Direktori Alumni</h2>
                    <p class="section-subtitle">
                        Temukan alumni berdasarkan tahun dan program studi
                    </p>
                </div>

                <!-- Filter Section -->
                <div class="filter-section mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="bi bi-search"></i> Cari Alumni
                                </label>
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    class="form-control filter-input"
                                    placeholder="Nama, NIM, atau Perusahaan..."
                                />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="bi bi-calendar3"></i> Tahun
                                    Kelulusan
                                </label>
                                <select
                                    v-model="selectedYear"
                                    class="form-select filter-select"
                                >
                                    <option value="all">Semua Tahun</option>
                                    <option
                                        v-for="year in graduationYears"
                                        :key="year"
                                        :value="year"
                                    >
                                        {{ year }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label class="filter-label">
                                    <i class="bi bi-building"></i> Program Studi
                                </label>
                                <select
                                    v-model="selectedProdi"
                                    class="form-select filter-select"
                                >
                                    <option value="all">Semua Program</option>
                                    <option
                                        v-for="prodi in programStudis"
                                        :key="prodi.id"
                                        :value="prodi.name"
                                    >
                                        {{ prodi.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Result Info -->
                    <div class="filter-result-info mt-3">
                        <span class="result-count">
                            Menampilkan {{ filteredAlumni.length }} dari
                            {{ allAlumni.length }} alumni
                        </span>
                        <button
                            v-if="
                                selectedYear !== 'all' ||
                                selectedProdi !== 'all' ||
                                searchQuery !== ''
                            "
                            @click="
                                ((selectedYear = 'all'),
                                (selectedProdi = 'all'),
                                (searchQuery = ''))
                            "
                            class="btn-reset-filter"
                        >
                            <i class="bi bi-x-circle"></i> Reset Filter
                        </button>
                    </div>
                </div>

                <!-- Alumni Grid -->
                <div v-if="filteredAlumni.length > 0" class="row g-4">
                    <div
                        v-for="alumni in filteredAlumni"
                        :key="alumni.id"
                        class="col-lg-3 col-md-4 col-sm-6"
                    >
                        <div class="alumni-card">
                            <div class="alumni-card-photo">
                                <img
                                    :src="alumni.photo"
                                    :alt="alumni.name"
                                    @error="
                                        $event.target.src =
                                            '/images/default-avatar.png'
                                    "
                                />
                            </div>
                            <div class="alumni-card-info">
                                <h5 class="alumni-card-name">
                                    {{ alumni.name }}
                                </h5>
                                <p class="alumni-card-nim">{{ alumni.nim }}</p>
                                <p class="alumni-card-prodi">
                                    {{ alumni.program_studi }}
                                </p>
                                <p class="alumni-card-year">
                                    <i class="bi bi-calendar-check"></i>
                                    {{ alumni.graduation_year }}
                                </p>
                                <div class="alumni-card-job">
                                    <div class="job-title">
                                        {{ alumni.current_job }}
                                    </div>
                                    <div class="company">
                                        <i class="bi bi-building"></i>
                                        {{ alumni.company }}
                                    </div>
                                </div>
                                <Link
                                    :href="`/alumni/${alumni.id}`"
                                    class="btn-view-profile"
                                >
                                    Lihat Profil
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h4>Tidak Ada Alumni Ditemukan</h4>
                    <p>
                        Coba ubah filter atau kata kunci pencarian untuk
                        menemukan alumni.
                    </p>
                    <button
                        @click="
                            ((selectedYear = 'all'),
                            (selectedProdi = 'all'),
                            (searchQuery = ''))
                        "
                        class="btn btn-primary"
                    >
                        Reset Filter
                    </button>
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

/* Featured Alumni Cards */
.featured-alumni-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
    height: 100%;
}

.featured-alumni-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}

.alumni-photo-wrapper {
    position: relative;
    height: 300px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.alumni-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.featured-alumni-card:hover .alumni-photo {
    transform: scale(1.1);
}

.featured-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    color: #2c3e50;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.alumni-info {
    padding: 2rem;
}

.alumni-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.alumni-prodi {
    color: #f5576c;
    font-weight: 600;
    margin-bottom: 0.3rem;
}

.alumni-graduation {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.current-position {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.position-title {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.company-name {
    color: #7f8c8d;
    font-size: 0.95rem;
}

.company-name i {
    margin-right: 0.5rem;
    color: #f5576c;
}

.alumni-testimonial {
    position: relative;
    padding: 1.5rem;
    background: #fff5f8;
    border-left: 4px solid #f5576c;
    border-radius: 8px;
    margin: 1.5rem 0;
}

.alumni-testimonial i {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 2rem;
    color: #f093fb;
    opacity: 0.3;
}

.alumni-testimonial p {
    margin: 0;
    font-style: italic;
    color: #2c3e50;
    line-height: 1.6;
    position: relative;
    z-index: 1;
}

.alumni-achievement {
    background: linear-gradient(135deg, #fff5e6 0%, #ffe9e9 100%);
    padding: 0.8rem 1rem;
    border-radius: 8px;
    color: #2c3e50;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.alumni-achievement i {
    color: #ffd700;
    margin-right: 0.5rem;
}

.social-links {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: transform 0.3s ease;
}

.social-link:hover {
    transform: scale(1.1);
}

.social-link.linkedin {
    background: #0077b5;
    color: white;
}

.btn-detail {
    flex: 1;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.6rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.btn-detail:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
    color: white;
}

/* Filter Section */
.filter-section {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.filter-group {
    margin-bottom: 0;
}

.filter-label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.filter-label i {
    color: #f5576c;
    margin-right: 0.5rem;
}

.filter-input,
.filter-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.7rem 1rem;
    font-size: 0.95rem;
    transition:
        border-color 0.3s ease,
        box-shadow 0.3s ease;
}

.filter-input:focus,
.filter-select:focus {
    border-color: #f5576c;
    box-shadow: 0 0 0 0.2rem rgba(245, 87, 108, 0.1);
}

.filter-result-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.result-count {
    color: #7f8c8d;
    font-weight: 600;
}

.btn-reset-filter {
    background: transparent;
    border: 2px solid #f5576c;
    color: #f5576c;
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-reset-filter:hover {
    background: #f5576c;
    color: white;
}

/* Alumni Card (Grid) */
.alumni-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
    height: 100%;
}

.alumni-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.alumni-card-photo {
    height: 250px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.alumni-card-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.alumni-card:hover .alumni-card-photo img {
    transform: scale(1.1);
}

.alumni-card-info {
    padding: 1.5rem;
}

.alumni-card-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.3rem;
}

.alumni-card-nim {
    color: #95a5a6;
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
}

.alumni-card-prodi {
    color: #f5576c;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
}

.alumni-card-year {
    color: #7f8c8d;
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

.alumni-card-year i {
    margin-right: 0.3rem;
}

.alumni-card-job {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.job-title {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.company {
    color: #7f8c8d;
    font-size: 0.85rem;
}

.company i {
    margin-right: 0.3rem;
    color: #f5576c;
}

.btn-view-profile {
    display: block;
    text-align: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.6rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.btn-view-profile:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(245, 87, 108, 0.3);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 5rem;
    color: #e9ecef;
    margin-bottom: 1rem;
}

.empty-state h4 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #7f8c8d;
    margin-bottom: 2rem;
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

    .filter-result-info {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>
