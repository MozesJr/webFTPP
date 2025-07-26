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
                                                programStudi.accreditation
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
                                    id="features-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#features"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-star me-2"></i>Keunggulan
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
                                    id="testimonial-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#testimonial"
                                    type="button"
                                    role="tab"
                                >
                                    <i class="bi bi-chat-quote me-2"></i
                                    >Testimoni
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
                                <!-- Quality Metrics -->
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
                                                4
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

                                <!-- Program Information -->
                                <div class="row portfolio-details">
                                    <div class="col-md-6">
                                        <div class="portfolio-info">
                                            <h5>
                                                <i
                                                    class="bi bi-mortarboard me-2"
                                                ></i
                                                >Visi Program Studi
                                            </h5>
                                            <p>
                                                {{
                                                    programStudi.visi ||
                                                    "Menjadi program studi yang unggul dalam pendidikan, penelitian, dan pengabdian masyarakat di bidang " +
                                                        programStudi.name.toLowerCase() +
                                                        " pada tahun 2030."
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="portfolio-info">
                                            <h5>
                                                <i class="bi bi-target me-2"></i
                                                >Misi Program Studi
                                            </h5>
                                            <div v-if="programStudi.misi">
                                                <div
                                                    v-html="programStudi.misi"
                                                ></div>
                                            </div>
                                            <ul v-else class="mb-0">
                                                <li>
                                                    Menyelenggarakan pendidikan
                                                    berkualitas tinggi
                                                </li>
                                                <li>
                                                    Mengembangkan penelitian
                                                    inovatif
                                                </li>
                                                <li>
                                                    Melaksanakan pengabdian
                                                    kepada masyarakat
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="portfolio-info">
                                            <h5>
                                                <i class="bi bi-trophy me-2"></i
                                                >Kompetensi Lulusan
                                            </h5>
                                            <div
                                                v-if="
                                                    programStudi.kompetensi_lulusan
                                                "
                                            >
                                                <div
                                                    v-html="
                                                        programStudi.kompetensi_lulusan
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
                                        Object.keys(subjectsBySemester).length >
                                            0
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
                                                                subject.code ||
                                                                "-"
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
                                                <strong
                                                    >Mata Kuliah Wajib:</strong
                                                >
                                                {{
                                                    currentKurikulum.mandatory_credits ||
                                                    "120"
                                                }}
                                                SKS
                                            </div>
                                            <div class="col-md-4">
                                                <strong
                                                    >Mata Kuliah
                                                    Pilihan:</strong
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
                                                        <td>
                                                            Matematika Dasar
                                                        </td>
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
                                            <h5>
                                                Semester 3-4 (Mata Kuliah Inti)
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
                                                        <td>
                                                            {{
                                                                programStudi.code
                                                            }}201
                                                        </td>
                                                        <td>
                                                            Mata Kuliah Keahlian
                                                            I
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
                                                            Mata Kuliah Keahlian
                                                            II
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
                                                            Mata Kuliah Keahlian
                                                            III
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
                                                <strong
                                                    >Mata Kuliah Wajib:</strong
                                                >
                                                120 SKS
                                            </div>
                                            <div class="col-md-4">
                                                <strong
                                                    >Mata Kuliah
                                                    Pilihan:</strong
                                                >
                                                18 SKS
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Tugas Akhir:</strong> 6
                                                SKS
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Features Tab -->
                            <div
                                class="tab-pane fade"
                                id="features"
                                role="tabpanel"
                            >
                                <h4>Keunggulan {{ programStudi.name }}</h4>

                                <div
                                    v-if="
                                        programStudi.features &&
                                        programStudi.features.length > 0
                                    "
                                    class="row"
                                >
                                    <div
                                        v-for="feature in programStudi.features"
                                        :key="feature.id"
                                        class="col-md-6 mb-4"
                                    >
                                        <div class="feature-card">
                                            <div class="row">
                                                <div
                                                    class="col-md-3 text-center"
                                                >
                                                    <i
                                                        :class="
                                                            feature.icon ||
                                                            'bi bi-star'
                                                        "
                                                        style="
                                                            font-size: 2rem;
                                                            color: var(
                                                                --accent-color
                                                            );
                                                        "
                                                    ></i>
                                                </div>
                                                <div class="col-md-9">
                                                    <h5>{{ feature.title }}</h5>
                                                    <p>
                                                        {{
                                                            feature.description
                                                        }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fallback features -->
                                <div v-else class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="feature-card">
                                            <div class="row">
                                                <div
                                                    class="col-md-3 text-center"
                                                >
                                                    <i
                                                        class="bi bi-award"
                                                        style="
                                                            font-size: 2rem;
                                                            color: var(
                                                                --accent-color
                                                            );
                                                        "
                                                    ></i>
                                                </div>
                                                <div class="col-md-9">
                                                    <h5>
                                                        Akreditasi Berkualitas
                                                    </h5>
                                                    <p>
                                                        Program studi
                                                        terakreditasi dengan
                                                        standar nasional yang
                                                        berkualitas.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="feature-card">
                                            <div class="row">
                                                <div
                                                    class="col-md-3 text-center"
                                                >
                                                    <i
                                                        class="bi bi-people"
                                                        style="
                                                            font-size: 2rem;
                                                            color: var(
                                                                --accent-color
                                                            );
                                                        "
                                                    ></i>
                                                </div>
                                                <div class="col-md-9">
                                                    <h5>Dosen Berpengalaman</h5>
                                                    <p>
                                                        Didukung oleh
                                                        dosen-dosen
                                                        berpengalaman dan
                                                        berkualifikasi tinggi.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dosen Tab -->
                            <div
                                class="tab-pane fade"
                                id="dosen"
                                role="tabpanel"
                            >
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
                                                            dosen.position
                                                                ?.name ||
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
                                                                    ?.name
                                                            )
                                                        "
                                                    >
                                                        {{
                                                            dosen.position
                                                                ?.name ||
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

                            <!-- Testimonial Tab -->
                            <div
                                class="tab-pane fade"
                                id="testimonial"
                                role="tabpanel"
                            >
                                <h4>
                                    Testimoni Alumni {{ programStudi.name }}
                                </h4>

                                <div
                                    v-if="
                                        programStudi.testimonials &&
                                        programStudi.testimonials.length > 0
                                    "
                                    class="row"
                                >
                                    <div
                                        v-for="testimonial in programStudi.testimonials"
                                        :key="testimonial.id"
                                        class="col-md-6 mb-4"
                                    >
                                        <div class="testimonial-card">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <img
                                                        :src="
                                                            testimonial.photo_url ||
                                                            '/storage/assets/img/testimonials/testimonials-1.jpg'
                                                        "
                                                        class="img-fluid rounded-circle"
                                                        :alt="testimonial.name"
                                                    />
                                                </div>
                                                <div class="col-md-9">
                                                    <h5>
                                                        {{ testimonial.name }}
                                                    </h5>
                                                    <p class="text-muted mb-2">
                                                        {{
                                                            testimonial.position
                                                        }}
                                                        -
                                                        {{
                                                            testimonial.company
                                                        }}
                                                    </p>
                                                    <p>
                                                        "{{
                                                            testimonial.content
                                                        }}"
                                                    </p>
                                                    <div
                                                        class="rating"
                                                        v-if="
                                                            testimonial.rating
                                                        "
                                                    >
                                                        <i
                                                            v-for="star in 5"
                                                            :key="star"
                                                            :class="
                                                                star <=
                                                                testimonial.rating
                                                                    ? 'bi bi-star-fill'
                                                                    : 'bi bi-star'
                                                            "
                                                            class="text-warning"
                                                        ></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fallback if no testimonial data -->
                                <div v-else class="text-center py-5">
                                    <i
                                        class="bi bi-chat-quote text-muted"
                                        style="font-size: 3rem"
                                    ></i>
                                    <h5 class="text-muted mt-3">
                                        Testimoni belum tersedia
                                    </h5>
                                    <p class="text-muted">
                                        Testimoni alumni untuk program studi ini
                                        sedang dalam proses pengumpulan.
                                    </p>
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
import { computed } from "vue";
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
});

const page = usePage();

// Helper function untuk membuat route URL
function route(name, params = null) {
    const routes = {
        "program-studi.show": (code) => `/program-studi/${code}`,
        "program-studi.index": () => "/program-studi",
    };

    if (routes[name]) {
        return routes[name](params);
    }

    return "#";
}

// Computed properties
const groupedSemesters = computed(() => {
    if (
        !props.subjectsBySemester ||
        Object.keys(props.subjectsBySemester).length === 0
    )
        return {};

    const grouped = {};
    const semesters = Object.keys(props.subjectsBySemester).sort(
        (a, b) => Number(a) - Number(b)
    );

    for (let i = 0; i < semesters.length; i += 2) {
        const key = `${semesters[i]}-${semesters[i + 1] || ""}`;
        grouped[key] = {
            ...props.subjectsBySemester[semesters[i]],
            ...(props.subjectsBySemester[semesters[i + 1]] || {}),
        };
    }

    return grouped;
});

// Helper methods
function getAccreditationClass(accreditation) {
    switch (accreditation) {
        case "A":
            return "bg-success";
        case "B":
            return "bg-warning";
        case "C":
            return "bg-secondary";
        default:
            return "bg-secondary";
    }
}

function getSemesterTitle(semesterRange) {
    const [start, end] = semesterRange.split("-");
    if (end && end !== "") {
        return `Semester ${start}-${end}`;
    }
    return `Semester ${start}`;
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
.feature-card,
.testimonial-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #e9ecef;
    transition: transform 0.3s ease;
}

.lecturer-card:hover,
.feature-card:hover,
.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
</style>
