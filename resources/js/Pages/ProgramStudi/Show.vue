<template>
    <AppLayout>
        <!-- Hero Section -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            :style="`background-image: url(${
                programStudi.image_url || '/storage/assets/img/imgBg2.png'
            })`"
        >
            <div class="container position-relative">
                <h1>
                    {{ programStudi.name }} ({{ programStudi.degree_level }})
                </h1>
                <p>
                    {{
                        programStudi.overview ||
                        "Informasi lengkap mengenai program studi, kurikulum, jadwal kuliah, dan daftar dosen"
                    }}
                </p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>
                            <Link href="/program-studi">Program Studi</Link>
                        </li>
                        <li class="current">{{ programStudi.name }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Program Studi Details Section -->
        <section id="service-details" class="service-details section">
            <div class="container">
                <div class="row gy-4">
                    <div
                        class="col-lg-4"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <!-- Program List -->
                        <div class="services-list">
                            <Link
                                v-for="program in relatedPrograms"
                                :key="program.id"
                                :href="`/program-studi/${program.code}`"
                                :class="{
                                    active: program.id === programStudi.id,
                                }"
                            >
                                {{ program.name }} ({{ program.degree_level }})
                            </Link>
                        </div>

                        <!-- Program Info Card -->
                        <div class="mt-4">
                            <h4>
                                {{ programStudi.name }} ({{
                                    programStudi.degree_level
                                }})
                            </h4>
                            <p>
                                {{
                                    programStudi.description ||
                                    programStudi.overview
                                }}
                            </p>

                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="badge bg-primary">{{
                                            programStudi.degree_level
                                        }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span
                                            :class="`badge ${getAccreditationClass(
                                                programStudi.accreditation,
                                            )}`"
                                        >
                                            Akreditasi
                                            {{
                                                programStudi.accreditation ||
                                                "-"
                                            }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-person-check me-1"></i>
                                        Kepala Program:
                                        {{
                                            programStudi.head_of_program ||
                                            "Belum ditentukan"
                                        }}
                                    </small>
                                </div>
                                <div v-if="programStudi.established_year">
                                    <small class="text-muted">
                                        <i
                                            class="bi bi-calendar-check me-1"
                                        ></i>
                                        Didirikan:
                                        {{ programStudi.established_year }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-lg-8 about"
                        data-aos="fade-up"
                        data-aos-delay="200"
                    >
                        <div class="position-relative">
                            <img
                                :src="
                                    programStudi.image_url ||
                                    '/storage/assets/img/service1.jpg'
                                "
                                :alt="programStudi.name"
                                class="img-fluid services-img"
                            />
                            <!-- Video play button if available -->
                            <a
                                v-if="programStudi.video_url"
                                :href="programStudi.video_url"
                                class="glightbox pulsating-play-btn"
                            ></a>
                        </div>
                        <h3>
                            {{ programStudi.name }} ({{
                                programStudi.degree_level
                            }})
                        </h3>
                        <p>
                            {{
                                programStudi.description ||
                                programStudi.overview
                            }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tabs Section -->
        <section class="service-details light-background">
            <div class="container">
                <div class="row gy-4">
                    <div
                        class="col-lg-12"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <!-- Tabs Navigation -->
                        <ul
                            class="nav nav-tabs sub-menu-tabs text-center"
                            id="prodiTabs"
                            role="tablist"
                        >
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link active"
                                    id="overview-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#overview"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-info-circle me-2"></i
                                    >Overview
                                </button>
                            </li>
                            <li
                                class="nav-item"
                                role="presentation"
                                v-if="
                                    programStudi.vision ||
                                    programStudi.mission ||
                                    programStudi.questionnaire_link
                                "
                            >
                                <button
                                    class="nav-link"
                                    id="vmts-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#vmts"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-bullseye me-2"></i>Visi &
                                    Misi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    id="kurikulum-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#kurikulum"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-book me-2"></i>Kurikulum
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    id="documents-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#documents"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-file-earmark-text me-2"></i
                                    >Public Dokumen
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    id="jadwal-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#jadwal"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-calendar-week me-2"></i
                                    >Jadwal Kuliah
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    id="dosen-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#dosen"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-people me-2"></i>Daftar
                                    Dosen
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    id="dosen-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#dosen"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-people me-2"></i>Prestasi
                                    Dosen / Mahasiwa
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link"
                                    id="dosen-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#dosen"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-people me-2"></i>Media
                                    Sosial
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="prodiTabContent">
                            <!-- Overview Tab -->
                            <div
                                class="tab-pane fade show active"
                                id="overview"
                                role="tabpanel"
                            >
                                <div
                                    class="quality-metrics"
                                    v-if="
                                        programStudi.penjaminan_mutus &&
                                        programStudi.penjaminan_mutus.length > 0
                                    "
                                >
                                    <h2 class="text-center mb-4 text-white">
                                        Evaluasi Penjaminan Mutu
                                    </h2>
                                    <div class="row">
                                        <div
                                            v-for="mutu in programStudi.penjaminan_mutus.slice(
                                                0,
                                                4,
                                            )"
                                            :key="mutu.id"
                                            class="col-md-3 metric-item"
                                        >
                                            <span class="metric-value">{{
                                                mutu.value || mutu.title
                                            }}</span>
                                            <small>{{
                                                mutu.description || mutu.title
                                            }}</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Default Quality Metrics if no data -->
                                <div class="quality-metrics" v-else>
                                    <h2 class="text-center mb-4 text-white">
                                        Evaluasi Penjaminan Mutu
                                    </h2>
                                    <div class="row">
                                        <div class="col-md-3 metric-item">
                                            <span class="metric-value">{{
                                                programStudi.accreditation ||
                                                "B"
                                            }}</span>
                                            <small>Akreditasi BAN-PT</small>
                                        </div>
                                        <div class="col-md-3 metric-item">
                                            <span class="metric-value"
                                                >95%</span
                                            >
                                            <small>Tingkat Kelulusan</small>
                                        </div>
                                        <div class="col-md-3 metric-item">
                                            <span class="metric-value"
                                                >87%</span
                                            >
                                            <small>Tingkat Kepuasan</small>
                                        </div>
                                        <div class="col-md-3 metric-item">
                                            <span class="metric-value"
                                                >78%</span
                                            >
                                            <small>Lulusan Bekerja</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row portfolio-details">
                                    <div
                                        class="col-md-6"
                                        v-if="programStudi.vision"
                                    >
                                        <div class="portfolio-info">
                                            <h5>
                                                <i
                                                    class="bi bi-mortarboard me-2"
                                                ></i
                                                >Visi Program Studi
                                            </h5>
                                            <p>
                                                {{
                                                    truncateText(
                                                        programStudi.vision,
                                                        200,
                                                    )
                                                }}
                                            </p>
                                            <a
                                                href="#vmts"
                                                class="btn btn-sm btn-outline-primary"
                                                @click.prevent="
                                                    switchToTab('vmts-tab')
                                                "
                                            >
                                                Lihat Lengkap
                                                <i
                                                    class="bi bi-arrow-right ms-1"
                                                ></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div
                                        class="col-md-6"
                                        v-if="programStudi.mission"
                                    >
                                        <div class="portfolio-info">
                                            <h5>
                                                <i class="bi bi-target me-2"></i
                                                >Misi Program Studi
                                            </h5>
                                            <div
                                                v-html="
                                                    truncateText(
                                                        programStudi.mission,
                                                        200,
                                                    )
                                                "
                                            ></div>
                                            <a
                                                href="#vmts"
                                                class="btn btn-sm btn-outline-primary mt-2"
                                                @click.prevent="
                                                    switchToTab('vmts-tab')
                                                "
                                            >
                                                Lihat Lengkap
                                                <i
                                                    class="bi bi-arrow-right ms-1"
                                                ></i>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- ✅ Kompetensi Lulusan -->
                                    <div class="col-md-12 mt-4">
                                        <div class="portfolio-info">
                                            <h5>
                                                <i class="bi bi-trophy me-2"></i
                                                >Kompetensi Lulusan
                                            </h5>
                                            <div
                                                v-if="
                                                    programStudi.graduate_competencies
                                                "
                                            >
                                                <div
                                                    v-html="
                                                        programStudi.graduate_competencies
                                                    "
                                                ></div>
                                            </div>
                                            <div v-else class="row">
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li>
                                                            Mampu menguasai
                                                            konsep teoritis dan
                                                            praktis
                                                        </li>
                                                        <li>
                                                            Menguasai teknologi
                                                            terkini dalam
                                                            bidangnya
                                                        </li>
                                                        <li>
                                                            Memahami
                                                            prinsip-prinsip
                                                            keilmuan
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li>
                                                            Menerapkan prinsip
                                                            keselamatan kerja
                                                        </li>
                                                        <li>
                                                            Memiliki kemampuan
                                                            manajemen proyek
                                                        </li>
                                                        <li>
                                                            Berpikir kritis dan
                                                            analitis
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ✅ NEW TAB - VISI MISI & VMTS QUESTIONNAIRE -->
                            <div
                                class="tab-pane fade"
                                id="vmts"
                                role="tabpanel"
                                v-if="
                                    programStudi.vision ||
                                    programStudi.mission ||
                                    programStudi.questionnaire_link
                                "
                            >
                                <div class="vmts-container">
                                    <h4 class="text-center mb-4">
                                        Visi, Misi, Tujuan & Strategi
                                    </h4>
                                    <p class="text-center text-muted mb-5">
                                        {{ programStudi.name }} ({{
                                            programStudi.degree_level
                                        }})
                                    </p>

                                    <!-- ✅ VMTS Questionnaire Call-to-Action -->
                                    <div
                                        v-if="programStudi.questionnaire_link"
                                        class="vmts-cta-card mb-5"
                                        data-aos="zoom-in"
                                    >
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <div
                                                    class="d-flex align-items-center mb-3"
                                                >
                                                    <div class="cta-icon me-3">
                                                        <i
                                                            class="bi bi-clipboard-check"
                                                        ></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1">
                                                            Kuesioner Pemahaman
                                                            VMTS
                                                        </h5>
                                                        <p
                                                            class="text-muted mb-0"
                                                        >
                                                            Bantu kami
                                                            meningkatkan
                                                            kualitas program
                                                            studi
                                                        </p>
                                                    </div>
                                                </div>
                                                <p class="mb-0 small">
                                                    <i
                                                        class="bi bi-info-circle me-1"
                                                    ></i>
                                                    Kuesioner ini ditujukan
                                                    untuk mengukur pemahaman
                                                    mahasiswa dan dosen terhadap
                                                    Visi, Misi, Tujuan &
                                                    Strategi program studi.
                                                </p>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <a
                                                    :href="
                                                        programStudi.questionnaire_link
                                                    "
                                                    target="_blank"
                                                    class="btn btn-vmts-primary btn-lg"
                                                >
                                                    <i
                                                        class="bi bi-box-arrow-up-right me-2"
                                                    ></i>
                                                    Isi Kuesioner
                                                </a>
                                                <p
                                                    class="text-muted small mt-2 mb-0"
                                                >
                                                    <i
                                                        class="bi bi-lock me-1"
                                                    ></i>
                                                    Data Anda akan dijaga
                                                    kerahasiaannya
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ✅ Vision Section -->
                                    <div
                                        class="vmts-section"
                                        v-if="programStudi.vision"
                                        data-aos="fade-up"
                                    >
                                        <div class="section-header">
                                            <div class="icon-wrapper">
                                                <i
                                                    class="bi bi-mortarboard"
                                                ></i>
                                            </div>
                                            <h5>Visi Program Studi</h5>
                                        </div>
                                        <div class="section-content">
                                            <p class="vision-text">
                                                {{ programStudi.vision }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- ✅ Mission Section -->
                                    <div
                                        class="vmts-section"
                                        v-if="programStudi.mission"
                                        data-aos="fade-up"
                                        data-aos-delay="100"
                                    >
                                        <div class="section-header">
                                            <div class="icon-wrapper">
                                                <i class="bi bi-target"></i>
                                            </div>
                                            <h5>Misi Program Studi</h5>
                                        </div>
                                        <div class="section-content">
                                            <!-- Parse mission if it contains line breaks -->
                                            <div
                                                v-if="
                                                    isMissionList(
                                                        programStudi.mission,
                                                    )
                                                "
                                            >
                                                <ol class="mission-list">
                                                    <li
                                                        v-for="(
                                                            item, index
                                                        ) in parseMissionItems(
                                                            programStudi.mission,
                                                        )"
                                                        :key="index"
                                                    >
                                                        {{ item }}
                                                    </li>
                                                </ol>
                                            </div>
                                            <div
                                                v-else
                                                v-html="programStudi.mission"
                                            ></div>
                                        </div>
                                    </div>

                                    <!-- ✅ Info Box -->
                                    <div
                                        class="vmts-info-box"
                                        data-aos="fade-up"
                                        data-aos-delay="200"
                                    >
                                        <div class="row">
                                            <div class="col-md-4 info-item">
                                                <i
                                                    class="bi bi-calendar-check"
                                                ></i>
                                                <h6>Review Berkala</h6>
                                                <p>
                                                    VMTS direview setiap tahun
                                                    untuk memastikan relevansi
                                                </p>
                                            </div>
                                            <div class="col-md-4 info-item">
                                                <i class="bi bi-people"></i>
                                                <h6>Partisipasi Stakeholder</h6>
                                                <p>
                                                    Melibatkan dosen, mahasiswa,
                                                    alumni dan industri
                                                </p>
                                            </div>
                                            <div class="col-md-4 info-item">
                                                <i
                                                    class="bi bi-graph-up-arrow"
                                                ></i>
                                                <h6>Continuous Improvement</h6>
                                                <p>
                                                    Komitmen untuk terus
                                                    meningkatkan kualitas
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ✅ Questionnaire Reminder (if exists) -->
                                    <div
                                        v-if="programStudi.questionnaire_link"
                                        class="text-center mt-5"
                                        data-aos="fade-up"
                                        data-aos-delay="300"
                                    >
                                        <p class="text-muted mb-3">
                                            Sudah memahami Visi dan Misi kami?
                                        </p>
                                        <a
                                            :href="
                                                programStudi.questionnaire_link
                                            "
                                            target="_blank"
                                            class="btn btn-vmts-secondary"
                                        >
                                            <i
                                                class="bi bi-clipboard-check me-2"
                                            ></i>
                                            Isi Kuesioner Pemahaman VMTS
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kurikulum Tab -->
                        <div
                            class="tab-pane fade"
                            id="kurikulum"
                            role="tabpanel"
                        >
                            <h4>
                                Struktur Kurikulum
                                {{ programStudi.name }} ({{
                                    programStudi.degree_level
                                }})
                            </h4>

                            <div
                                v-if="
                                    currentKurikulum &&
                                    subjectsBySemester &&
                                    Object.keys(subjectsBySemester).length > 0
                                "
                            >
                                <!-- Semester Groups -->
                                <div class="row">
                                    <div
                                        v-for="(
                                            subjects, semester
                                        ) in subjectsBySemester"
                                        :key="semester"
                                        class="col-md-6 mb-4"
                                    >
                                        <h5>Semester {{ semester }}</h5>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>SKS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="subject in subjects"
                                                    :key="subject.id"
                                                >
                                                    <td>
                                                        {{
                                                            subject.code || "-"
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{ subject.name }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            subject.credits ||
                                                            subject.sks ||
                                                            "-"
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Summary -->
                                <div class="info-card">
                                    <h5>
                                        Total SKS:
                                        {{
                                            currentKurikulum.total_credits ||
                                            "144"
                                        }}
                                        SKS
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Mata Kuliah Wajib:</strong>
                                            {{
                                                currentKurikulum.mandatory_credits ||
                                                "120"
                                            }}
                                            SKS
                                        </div>
                                        <div class="col-md-4">
                                            <strong
                                                >Mata Kuliah Pilihan:</strong
                                            >
                                            {{
                                                currentKurikulum.elective_credits ||
                                                "18"
                                            }}
                                            SKS
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Tugas Akhir:</strong>
                                            {{
                                                currentKurikulum.thesis_credits ||
                                                "6"
                                            }}
                                            SKS
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sample curriculum if no data -->
                            <div v-else>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <h5>
                                            Semester 1-2 (Mata Kuliah Dasar)
                                        </h5>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>SKS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>MTK101</td>
                                                    <td>Matematika Dasar</td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>FIS101</td>
                                                    <td>Fisika Dasar</td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>KIM101</td>
                                                    <td>Kimia Dasar</td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>GEO101</td>
                                                    <td>Geologi Dasar</td>
                                                    <td>3</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <h5>Semester 3-4 (Mata Kuliah Inti)</h5>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>SKS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {{
                                                            programStudi.code
                                                        }}201
                                                    </td>
                                                    <td>
                                                        Mata Kuliah Keahlian I
                                                    </td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        {{
                                                            programStudi.code
                                                        }}202
                                                    </td>
                                                    <td>
                                                        Mata Kuliah Keahlian II
                                                    </td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        {{
                                                            programStudi.code
                                                        }}203
                                                    </td>
                                                    <td>
                                                        Mata Kuliah Keahlian III
                                                    </td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        {{
                                                            programStudi.code
                                                        }}204
                                                    </td>
                                                    <td>Praktikum</td>
                                                    <td>2</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="info-card">
                                    <h5>Total SKS: 144 SKS</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Mata Kuliah Wajib:</strong>
                                            120 SKS
                                        </div>
                                        <div class="col-md-4">
                                            <strong
                                                >Mata Kuliah Pilihan:</strong
                                            >
                                            18 SKS
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Tugas Akhir:</strong> 6 SKS
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Public Documents Tab -->
                        <div
                            class="tab-pane fade"
                            id="documents"
                            role="tabpanel"
                        >
                            <h4>Public Dokumen {{ programStudi.name }}</h4>
                            <p class="text-muted mb-4">
                                Download dokumen resmi dan panduan akademik
                                program studi.
                            </p>

                            <div
                                v-if="
                                    programStudi.documents &&
                                    programStudi.documents.length > 0
                                "
                                class="row"
                            >
                                <div
                                    v-for="doc in programStudi.documents"
                                    :key="doc.id"
                                    class="col-md-6 col-lg-4 mb-4"
                                >
                                    <div class="document-card">
                                        <div class="document-icon">
                                            <i
                                                :class="
                                                    getDocumentIcon(doc.type)
                                                "
                                                style="
                                                    font-size: 2.5rem;
                                                    color: var(--accent-color);
                                                "
                                            ></i>
                                        </div>
                                        <div class="document-info">
                                            <h5>{{ doc.title }}</h5>
                                            <p class="text-muted">
                                                {{ doc.description }}
                                            </p>
                                            <div class="document-meta">
                                                <small class="text-muted">
                                                    <i
                                                        class="bi bi-calendar me-1"
                                                    ></i>
                                                    {{
                                                        formatDate(
                                                            doc.updated_at,
                                                        )
                                                    }}
                                                </small>
                                                <small
                                                    class="text-muted ms-3"
                                                    v-if="doc.file_size"
                                                >
                                                    <i
                                                        class="bi bi-file-earmark me-1"
                                                    ></i>
                                                    {{
                                                        formatFileSize(
                                                            doc.file_size,
                                                        )
                                                    }}
                                                </small>
                                            </div>
                                            <div class="mt-3">
                                                <a
                                                    :href="doc.file_url"
                                                    target="_blank"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    <i
                                                        class="bi bi-download me-1"
                                                    ></i>
                                                    Download
                                                </a>
                                                <a
                                                    :href="doc.file_url"
                                                    target="_blank"
                                                    class="btn btn-outline-secondary btn-sm ms-2"
                                                >
                                                    <i
                                                        class="bi bi-eye me-1"
                                                    ></i>
                                                    Preview
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Default documents if no data -->
                            <div v-else class="row">
                                <div
                                    class="col-md-6 col-lg-4 mb-4"
                                    v-for="docType in defaultDocuments"
                                    :key="docType.type"
                                >
                                    <div class="document-card">
                                        <div class="document-icon">
                                            <i
                                                :class="docType.icon"
                                                style="
                                                    font-size: 2.5rem;
                                                    color: var(--accent-color);
                                                "
                                            ></i>
                                        </div>
                                        <div class="document-info">
                                            <h5>{{ docType.title }}</h5>
                                            <p class="text-muted">
                                                {{ docType.description }}
                                            </p>
                                            <div class="mt-3">
                                                <span class="badge bg-secondary"
                                                    >Segera Tersedia</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jadwal Kuliah Tab -->
                        <div class="tab-pane fade" id="jadwal" role="tabpanel">
                            <h4>Jadwal Kuliah {{ programStudi.name }}</h4>

                            <!-- Semester Filter -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <select
                                        class="form-select"
                                        v-model="selectedSemester"
                                    >
                                        <option value="">Pilih Semester</option>
                                        <option
                                            v-for="sem in availableSemesters"
                                            :key="sem"
                                            :value="sem"
                                        >
                                            Semester {{ sem }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select
                                        class="form-select"
                                        v-model="selectedAcademicYear"
                                    >
                                        <option value="">
                                            Pilih Tahun Akademik
                                        </option>
                                        <option
                                            v-for="year in academicYears"
                                            :key="year"
                                            :value="year"
                                        >
                                            {{ year }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div
                                v-if="
                                    filteredSchedules &&
                                    filteredSchedules.length > 0
                                "
                            >
                                <!-- Schedule Table -->
                                <div class="table-responsive">
                                    <table
                                        class="table table-striped schedule-table"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Kode MK</th>
                                                <th>Mata Kuliah</th>
                                                <th>SKS</th>
                                                <th>Kelas</th>
                                                <th>Hari</th>
                                                <th>Waktu</th>
                                                <th>Ruang</th>
                                                <th>Dosen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="schedule in filteredSchedules"
                                                :key="schedule.id"
                                            >
                                                <td>
                                                    {{ schedule.subject_code }}
                                                </td>
                                                <td>
                                                    {{ schedule.subject_name }}
                                                </td>
                                                <td>
                                                    {{ schedule.credits }}
                                                </td>
                                                <td>
                                                    {{ schedule.class_name }}
                                                </td>
                                                <td>{{ schedule.day }}</td>
                                                <td>
                                                    {{ schedule.start_time }}
                                                    -
                                                    {{ schedule.end_time }}
                                                </td>
                                                <td>{{ schedule.room }}</td>
                                                <td>
                                                    {{ schedule.lecturer_name }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Default schedule if no data -->
                            <div v-else class="text-center py-5">
                                <i
                                    class="bi bi-calendar-x text-muted"
                                    style="font-size: 3rem"
                                ></i>
                                <h5 class="text-muted mt-3">
                                    Jadwal kuliah belum tersedia
                                </h5>
                                <p class="text-muted">
                                    Jadwal kuliah untuk semester ini sedang
                                    dalam proses penyusunan.
                                </p>
                            </div>
                        </div>

                        <!-- Dosen Tab -->
                        <div class="tab-pane fade" id="dosen" role="tabpanel">
                            <h4>Daftar Dosen {{ programStudi.name }}</h4>

                            <div
                                v-if="
                                    programStudi.teams &&
                                    programStudi.teams.length > 0
                                "
                                class="row"
                            >
                                <div
                                    v-for="dosen in programStudi.teams"
                                    :key="dosen.id"
                                    class="col-md-6 mb-4"
                                >
                                    <div class="lecturer-card">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img
                                                    :src="
                                                        dosen.photo_url ||
                                                        '/storage/assets/img/team/team-1.jpg'
                                                    "
                                                    class="img-fluid rounded-circle"
                                                    :alt="dosen.name"
                                                />
                                            </div>
                                            <div class="col-md-8">
                                                <h5>{{ dosen.name }}</h5>
                                                <p class="text-muted mb-1">
                                                    {{
                                                        dosen.position?.name ||
                                                        dosen.expertise
                                                    }}
                                                </p>
                                                <p
                                                    class="mb-1"
                                                    v-if="dosen.email"
                                                >
                                                    <i
                                                        class="bi bi-envelope me-2"
                                                    ></i
                                                    >{{ dosen.email }}
                                                </p>
                                                <p
                                                    class="mb-1"
                                                    v-if="dosen.education"
                                                >
                                                    <i
                                                        class="bi bi-mortarboard me-2"
                                                    ></i
                                                    >{{ dosen.education }}
                                                </p>
                                                <small
                                                    :class="
                                                        getPositionClass(
                                                            dosen.position
                                                                ?.name,
                                                        )
                                                    "
                                                >
                                                    {{
                                                        dosen.position?.name ||
                                                        "Dosen"
                                                    }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fallback if no dosen data -->
                            <div v-else class="text-center py-5">
                                <i
                                    class="bi bi-people text-muted"
                                    style="font-size: 3rem"
                                ></i>
                                <h5 class="text-muted mt-3">
                                    Data dosen belum tersedia
                                </h5>
                                <p class="text-muted">
                                    Informasi dosen untuk program studi ini
                                    sedang dalam proses pembaruan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { computed, ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    programStudi: Object,
    currentKurikulum: Object,
    subjectsBySemester: Object,
    relatedPrograms: {
        type: Array,
        default: () => [],
    },
    schedules: {
        type: Array,
        default: () => [],
    },
});

// Reactive variables for filters
const selectedSemester = ref("");
const selectedAcademicYear = ref("");

// Default documents configuration
const defaultDocuments = [
    {
        type: "rps",
        title: "RPS (Rencana Pembelajaran Semester)",
        description: "Dokumen rencana pembelajaran untuk setiap mata kuliah",
        icon: "bi bi-file-earmark-text",
    },
    {
        type: "brosur",
        title: "Brosur Program Studi",
        description: "Informasi lengkap tentang program studi",
        icon: "bi bi-file-earmark-image",
    },
    {
        type: "peraturan",
        title: "Peraturan Akademik",
        description: "Peraturan dan tata tertib akademik",
        icon: "bi bi-file-earmark-ruled",
    },
    {
        type: "panduan",
        title: "Panduan Akademik",
        description: "Panduan untuk mahasiswa dan akademik",
        icon: "bi bi-file-earmark-check",
    },
    {
        type: "profil",
        title: "Profil Lulusan",
        description: "Profil dan kompetensi lulusan program studi",
        icon: "bi bi-file-earmark-person",
    },
];

// Computed properties
const availableSemesters = computed(() => {
    if (!props.schedules || props.schedules.length === 0)
        return [1, 2, 3, 4, 5, 6, 7, 8];
    return [...new Set(props.schedules.map((s) => s.semester))].sort();
});

const academicYears = computed(() => {
    if (!props.schedules || props.schedules.length === 0)
        return ["2024/2025", "2023/2024"];
    return [...new Set(props.schedules.map((s) => s.academic_year))]
        .sort()
        .reverse();
});

const filteredSchedules = computed(() => {
    if (!props.schedules) return [];

    return props.schedules.filter((schedule) => {
        const semesterMatch =
            !selectedSemester.value ||
            schedule.semester == selectedSemester.value;
        const yearMatch =
            !selectedAcademicYear.value ||
            schedule.academic_year === selectedAcademicYear.value;
        return semesterMatch && yearMatch;
    });
});

// Helper methods
function getAccreditationClass(accreditation) {
    switch (accreditation) {
        case "A":
        case "Unggul":
            return "bg-success";
        case "B":
        case "Baik Sekali":
            return "bg-primary";
        case "C":
        case "Baik":
            return "bg-warning";
        default:
            return "bg-secondary";
    }
}

function getPositionClass(position) {
    if (!position) return "text-muted";

    if (
        position.toLowerCase().includes("guru besar") ||
        position.toLowerCase().includes("profesor")
    ) {
        return "text-primary";
    } else if (position.toLowerCase().includes("lektor kepala")) {
        return "text-success";
    } else if (position.toLowerCase().includes("lektor")) {
        return "text-info";
    }
    return "text-muted";
}

function getDocumentIcon(type) {
    const icons = {
        rps: "bi bi-file-earmark-text",
        brosur: "bi bi-file-earmark-image",
        peraturan: "bi bi-file-earmark-ruled",
        panduan: "bi bi-file-earmark-check",
        profil: "bi bi-file-earmark-person",
        pdf: "bi bi-file-earmark-pdf",
        doc: "bi bi-file-earmark-word",
        xlsx: "bi bi-file-earmark-excel",
    };
    return icons[type] || "bi bi-file-earmark";
}

function formatDate(dateString) {
    if (!dateString) return "";
    const date = new Date(dateString);
    return date.toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}

function formatFileSize(bytes) {
    if (!bytes) return "";
    const sizes = ["Bytes", "KB", "MB", "GB"];
    if (bytes === 0) return "0 Byte";
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round((bytes / Math.pow(1024, i)) * 100) / 100 + " " + sizes[i];
}

// ✅ NEW HELPER METHODS
function truncateText(text, maxLength) {
    if (!text) return "";
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + "...";
}

function switchToTab(tabId) {
    const tab = document.getElementById(tabId);
    if (tab) {
        const bsTab = new bootstrap.Tab(tab);
        bsTab.show();
    }
}

function isMissionList(mission) {
    if (!mission) return false;
    // Check if mission contains line breaks or numbered items
    return mission.includes("\n") || mission.match(/^\d+\./m);
}

function parseMissionItems(mission) {
    if (!mission) return [];

    // Split by line breaks and filter empty lines
    const items = mission
        .split("\n")
        .map((item) => item.trim())
        .filter((item) => item.length > 0)
        // Remove numbering if exists (e.g., "1. Text" -> "Text")
        .map((item) => item.replace(/^\d+\.\s*/, ""));

    return items;
}
</script>

<style scoped>
.services-list {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.services-list a {
    display: block;
    padding: 10px 15px;
    margin-bottom: 5px;
    color: #333;
    text-decoration: none;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.services-list a:hover,
.services-list a.active {
    background: var(--accent-color);
    color: white;
}

.quality-metrics {
    background: linear-gradient(45deg, var(--accent-color), var(--nav-color));
    padding: 40px 20px;
    border-radius: 10px;
    margin-bottom: 40px;
    text-align: center;
}

.metric-item {
    padding: 20px;
}

.metric-value {
    display: block;
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
    margin-bottom: 10px;
}

.metric-item small {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
}

.portfolio-info {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    height: 100%;
}

.portfolio-info h5 {
    color: var(--heading-color);
    margin-bottom: 15px;
    font-weight: 600;
}

.sub-menu-tabs {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    padding: 10px;
}

.sub-menu-tabs .nav-link {
    border: none;
    border-radius: 8px;
    color: var(--default-color);
    font-weight: 500;
    padding: 12px 20px;
    margin: 0 5px;
    transition: all 0.3s ease;
}

.sub-menu-tabs .nav-link:hover,
.sub-menu-tabs .nav-link.active {
    background: var(--accent-color);
    color: white;
}

.tab-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.lecturer-card,
.document-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #e9ecef;
    transition: transform 0.3s ease;
    height: 100%;
}

.lecturer-card:hover,
.document-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.document-card {
    text-align: center;
}

.document-icon {
    margin-bottom: 15px;
}

.document-info h5 {
    margin-bottom: 10px;
    color: var(--heading-color);
}

.document-meta {
    margin: 10px 0;
}

.info-card {
    background: var(--surface-color);
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid var(--accent-color);
    margin-top: 20px;
}

.schedule-table th {
    background: var(--accent-color);
    color: white;
    text-align: center;
    font-weight: 600;
}

.schedule-table td {
    vertical-align: middle;
    text-align: center;
}

.pulsating-play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: rgba(var(--accent-color-rgb), 0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    text-decoration: none;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 0 0 0 0 rgba(var(--accent-color-rgb), 0.7);
    }
    70% {
        transform: translate(-50%, -50%) scale(1.1);
        box-shadow: 0 0 0 10px rgba(var(--accent-color-rgb), 0);
    }
    100% {
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 0 0 0 0 rgba(var(--accent-color-rgb), 0);
    }
}

/* ✅ VMTS Specific Styles */
.vmts-container {
    padding: 20px;
}

.vmts-cta-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    transition: transform 0.3s ease;
}

.vmts-cta-card:hover {
    transform: translateY(-5px);
}

.cta-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.vmts-cta-card h5 {
    color: white;
    font-weight: 600;
    margin: 0;
}

.vmts-cta-card .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

.btn-vmts-primary {
    background: white;
    color: #667eea;
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-vmts-primary:hover {
    background: #f8f9fa;
    color: #764ba2;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-vmts-secondary {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-vmts-secondary:hover {
    background: var(--nav-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.vmts-section {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 25px;
    border-left: 4px solid var(--accent-color);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.icon-wrapper {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--accent-color), var(--nav-color));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 24px;
    color: white;
}

.section-header h5 {
    margin: 0;
    color: var(--heading-color);
    font-weight: 600;
}

.section-content {
    color: var(--default-color);
    line-height: 1.8;
}

.vision-text {
    font-size: 1.1rem;
    font-style: italic;
    color: #555;
    margin: 0;
    padding: 10px 20px;
    border-left: 3px solid var(--accent-color);
    background: #f8f9fa;
    border-radius: 0 10px 10px 0;
}

.mission-list {
    padding-left: 25px;
    margin: 0;
}

.mission-list li {
    padding: 10px 0;
    line-height: 1.8;
    position: relative;
}

.mission-list li::marker {
    color: var(--accent-color);
    font-weight: bold;
}

.vmts-info-box {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 40px 30px;
    border-radius: 15px;
    margin-top: 40px;
}

.info-item {
    text-align: center;
    padding: 20px;
}

.info-item i {
    font-size: 3rem;
    color: var(--accent-color);
    margin-bottom: 15px;
}

.info-item h6 {
    font-weight: 600;
    color: var(--heading-color);
    margin-bottom: 10px;
}

.info-item p {
    color: #666;
    margin: 0;
    font-size: 0.9rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .vmts-cta-card .col-md-4 {
        margin-top: 20px;
        text-align: center !important;
    }

    .vmts-cta-card .row {
        text-align: center;
    }

    .cta-icon {
        margin: 0 auto 15px;
    }
}
</style>
