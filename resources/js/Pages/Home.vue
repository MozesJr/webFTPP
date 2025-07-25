<template>
    <AppLayout>
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <div class="absolute inset-0 z-0">
                <video
                    v-if="hero.background_video_url"
                    autoplay
                    muted
                    loop
                    class="w-full h-full object-cover"
                >
                    <source :src="hero.background_video_url" type="video/mp4" />
                </video>
                <img
                    v-else-if="hero.background_image_url"
                    :src="hero.background_image_url"
                    alt="Hero Background"
                    class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            </div>

            <div class="container d-flex flex-column align-items-center">
                <h2 data-aos="fade-up" data-aos-delay="100">
                    {{ hero.title }}
                </h2>
                <p data-aos="fade-up" data-aos-delay="200">
                    {{ hero.subtitle }}
                </p>
                <div
                    class="d-flex mt-4"
                    data-aos="fade-up"
                    data-aos-delay="300"
                >
                    <a href="/program-studi" class="btn-get-started"
                        >Jelajahi Program</a
                    >
                    <a
                        :href="hero.explanation_video_url"
                        class="glightbox btn-watch-video d-flex align-items-center"
                    >
                        <i class="bi bi-play-circle"></i
                        ><span>Watch Video</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container section-title" data-aos="fade-up">
                <h2>About</h2>
                <p>ABOUT ALL FOR {{ siteSettings.site_title }}</p>
            </div>
            <div class="container">
                <div class="row gy-4">
                    <div
                        class="col-lg-6"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <a href="/about-detail" class="team-link">
                            <h3>
                                {{
                                    about?.title ||
                                    "Fakultas Teknik Pertambangan dan Perminyakan"
                                }}
                            </h3>
                            <img
                                :src="
                                    about?.image_url ||
                                    '/storage/assets/img/About1.jpeg'
                                "
                                class="img-fluid rounded-4 mb-4"
                                alt=""
                            />
                        </a>
                        <p
                            v-if="about?.description"
                            v-html="about.description"
                        ></p>
                        <p v-else>
                            Ut fugiat ut sunt quia veniam. Voluptate perferendis
                            perspiciatis quod nisi et. Placeat debitis quia
                            recusandae odit et consequatur voluptatem.
                            Dignissimos pariatur consectetur fugiat voluptas ea.
                        </p>
                    </div>

                    <div
                        class="col-lg-6"
                        data-aos="fade-up"
                        data-aos-delay="250"
                    >
                        <div class="content ps-0 ps-lg-5">
                            <p class="fst-italic">
                                {{
                                    about?.subtitle ||
                                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                                }}
                            </p>
                            <ul>
                                <li
                                    v-for="prodi in programStudis.slice(0, 4)"
                                    :key="prodi.id"
                                >
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span
                                        >{{ prodi.degree_level }}
                                        {{ prodi.name }}</span
                                    >
                                </li>
                            </ul>
                            <div class="position-relative mt-4">
                                <img
                                    :src="
                                        about?.secondary_image_url ||
                                        '/storage/assets/img/About2.jpeg'
                                    "
                                    class="img-fluid rounded-4"
                                    alt=""
                                />
                                <a
                                    :href="about?.video_url"
                                    class="glightbox pulsating-play-btn"
                                ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section id="stats" class="stats section light-background">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6">
                        <div
                            class="stats-item d-flex align-items-center w-100 h-100"
                        >
                            <i
                                class="bi bi-emoji-smile color-blue flex-shrink-0"
                            ></i>
                            <div>
                                <span
                                    data-purecounter-start="0"
                                    :data-purecounter-end="
                                        stats?.total_students || 500
                                    "
                                    data-purecounter-duration="1"
                                    class="purecounter"
                                ></span>
                                <p>Mahasiswa</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div
                            class="stats-item d-flex align-items-center w-100 h-100"
                        >
                            <i
                                class="bi bi-journal-richtext color-orange flex-shrink-0"
                            ></i>
                            <div>
                                <span
                                    data-purecounter-start="0"
                                    :data-purecounter-end="
                                        stats?.total_partnerships || 521
                                    "
                                    data-purecounter-duration="1"
                                    class="purecounter"
                                ></span>
                                <p>Projects</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div
                            class="stats-item d-flex align-items-center w-100 h-100"
                        >
                            <i
                                class="bi bi-headset color-green flex-shrink-0"
                            ></i>
                            <div>
                                <span
                                    data-purecounter-start="0"
                                    :data-purecounter-end="
                                        stats?.total_alumni || 1463
                                    "
                                    data-purecounter-duration="1"
                                    class="purecounter"
                                ></span>
                                <p>Alumni</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div
                            class="stats-item d-flex align-items-center w-100 h-100"
                        >
                            <i
                                class="bi bi-people color-pink flex-shrink-0"
                            ></i>
                            <div>
                                <span
                                    data-purecounter-start="0"
                                    :data-purecounter-end="
                                        stats?.total_lecturers || 30
                                    "
                                    data-purecounter-duration="1"
                                    class="purecounter"
                                ></span>
                                <p>Dosen</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="services section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Program Studi</h2>
                <p>Featured Program Studi<br /></p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-5">
                    <div
                        v-for="(prodi, index) in programStudis.slice(0, 4)"
                        :key="prodi.id"
                        class="col-xl-3 col-md-6"
                        data-aos="zoom-in"
                        :data-aos-delay="200 + index * 100"
                    >
                        <div class="service-item">
                            <div class="img">
                                <img
                                    :src="
                                        prodi.image_url ||
                                        `/assets/img/service${index + 1}.jpg`
                                    "
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="details position-relative">
                                <div class="icon">
                                    <i class="bi bi-activity"></i>
                                </div>
                                <a href="/program-studi" class="stretched-link">
                                    <h3>{{ prodi.name }}</h3>
                                </a>
                                <p>
                                    {{
                                        prodi.description ||
                                        "Deskripsi program studi akan ditampilkan di sini."
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clients Section -->
        <section
            id="clients"
            class="clients section light-background"
            v-if="clients.length"
        >
            <div class="container" data-aos="fade-up">
                <div class="row gy-4">
                    <div
                        v-for="(client, index) in clients"
                        :key="client.id"
                        class="col-xl-2 col-md-3 col-6 client-logo"
                    >
                        <img
                            :src="
                                client.logo_url ||
                                `/assets/img/clients/client${index + 1}.png`
                            "
                            class="img-fluid"
                            :alt="client.name"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="features section">
            <div class="container">
                <ul
                    class="nav nav-tabs row d-flex"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <li
                        v-for="(prodi, index) in programStudis.slice(0, 4)"
                        :key="prodi.id"
                        class="nav-item col-3"
                    >
                        <a
                            :class="[
                                'nav-link',
                                { 'active show': index === 0 },
                            ]"
                            data-bs-toggle="tab"
                            :data-bs-target="`#features-tab-${index + 1}`"
                        >
                            <i class="bi bi-binoculars"></i>
                            <h4 class="d-none d-lg-block">{{ prodi.name }}</h4>
                        </a>
                    </li>
                </ul>

                <div
                    class="tab-content"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <div
                        v-for="(prodi, index) in programStudis.slice(0, 4)"
                        :key="prodi.id"
                        :class="[
                            'tab-pane fade',
                            { 'active show': index === 0 },
                        ]"
                        :id="`features-tab-${index + 1}`"
                    >
                        <div class="row">
                            <div
                                class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0"
                            >
                                <h3>{{ prodi.name }}</h3>
                                <p class="fst-italic">
                                    {{ prodi.description }}
                                </p>
                                <ul v-if="prodi.features">
                                    <li
                                        v-for="feature in prodi.features"
                                        :key="feature.id"
                                    >
                                        <i class="bi bi-check2-all"></i>
                                        <span>{{ feature.title }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div
                                class="col-lg-6 order-1 order-lg-2 text-center"
                            >
                                <img
                                    :src="
                                        prodi.image_url ||
                                        `/assets/img/service${index + 1}.jpg`
                                    "
                                    alt=""
                                    class="img-fluid"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section
            id="testimonials"
            class="testimonials section dark-background"
            v-if="testimonials.length"
        >
            <img
                :src="
                    siteSettings.testimoni_back ||
                    '/storage/assets/img/imgBg1.jpg'
                "
                class="testimonials-bg"
                alt=""
            />

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper init-swiper">
                    <div class="swiper-wrapper">
                        <div
                            v-for="testimonial in testimonials"
                            :key="testimonial.id"
                            class="swiper-slide"
                        >
                            <div class="testimonial-item">
                                <img
                                    :src="
                                        testimonial.photo_url ||
                                        '/storage/assets/img/imgBg1.jpg'
                                    "
                                    class="testimonial-img"
                                    :alt="testimonial.name"
                                />
                                <h3>{{ testimonial.name }}</h3>
                                <h4>{{ testimonial.position }}</h4>
                                <div class="stars">
                                    <i
                                        v-for="i in testimonial.rating"
                                        :key="i"
                                        class="bi bi-star-fill"
                                    ></i>
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>{{ testimonial.content }}</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        <!-- Portfolio Section -->
        <section
            id="portfolio"
            class="portfolio section"
            v-if="latestNews.length"
        >
            <div class="container section-title" data-aos="fade-up">
                <h2>News</h2>
                <p>CHECK OUR NEWS</p>
            </div>

            <div class="container">
                <div
                    class="isotope-layout"
                    data-default-filter="*"
                    data-layout="masonry"
                    data-sort="original-order"
                >
                    <ul
                        class="portfolio-filters isotope-filters"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-academic">Academic</li>
                        <li data-filter=".filter-research">Research</li>
                        <li data-filter=".filter-events">Events</li>
                    </ul>

                    <div
                        class="row gy-4 isotope-container"
                        data-aos="fade-up"
                        data-aos-delay="200"
                    >
                        <div
                            v-for="news in latestNews"
                            :key="news.id"
                            class="col-lg-4 col-md-6 portfolio-item isotope-item filter-app"
                        >
                            <div class="portfolio-content h-100">
                                <img
                                    :src="
                                        news.featured_image ||
                                        '/storage/assets/img/blog1.jpg'
                                    "
                                    class="img-fluid"
                                    :alt="news.title"
                                />
                                <div class="portfolio-info">
                                    <h4>{{ news.title }} asdasdasda</h4>
                                    <p>{{ news.excerpt }}</p>
                                    <a
                                        :href="
                                            news.featured_image ||
                                            '/storage/assets/img/blog1.jpg'
                                        "
                                        :title="news.title"
                                        data-gallery="portfolio-gallery-news"
                                        class="glightbox preview-link"
                                    >
                                        <i class="bi bi-zoom-in"></i>
                                    </a>
                                    <a
                                        href="/news"
                                        title="More Details"
                                        class="details-link"
                                    >
                                        <i class="bi bi-link-45deg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section id="team" class="team section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Team</h2>
                <p>CHECK OUR TEAM</p>
            </div>

            <div class="container">
                <div class="row gy-5">
                    <div
                        class="col-lg-3 col-md-6"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        <div class="member">
                            <a href="/teams-details" class="team-link">
                                <div class="pic">
                                    <img
                                        src="/storage/assets/img/team1.png"
                                        class="img-fluid"
                                        alt=""
                                    />
                                </div>
                                <div class="member-info">
                                    <h4>Prof. Dr. Ir. Eko A. Martanto, MP</h4>
                                    <span>Dekan</span>
                                </div>
                            </a>
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-lg-3 col-md-6"
                        data-aos="fade-up"
                        data-aos-delay="200"
                    >
                        <div class="member">
                            <div class="pic">
                                <img
                                    src="/storage/assets/img/team2.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="member-info">
                                <h4>Ir. Hastowo Resesiyanto, ST., M.Eng</h4>
                                <span>Wakil Dekan I</span>
                                <div class="social">
                                    <a href=""
                                        ><i class="bi bi-twitter-x"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-facebook"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-instagram"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-linkedin"></i
                                    ></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-lg-3 col-md-6"
                        data-aos="fade-up"
                        data-aos-delay="300"
                    >
                        <div class="member">
                            <div class="pic">
                                <img
                                    src="/storage/assets/img/team3.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="member-info">
                                <h4>Ir. Bambang Triyanto, ST., M.T</h4>
                                <span>Wakil Dekan II</span>
                                <div class="social">
                                    <a href=""
                                        ><i class="bi bi-twitter-x"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-facebook"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-instagram"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-linkedin"></i
                                    ></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-lg-3 col-md-6"
                        data-aos="fade-up"
                        data-aos-delay="400"
                    >
                        <div class="member">
                            <div class="pic">
                                <img
                                    src="/storage/assets/img/team4.png"
                                    class="img-fluid"
                                    alt=""
                                />
                            </div>
                            <div class="member-info">
                                <h4>Ir. Erik A. Parandianan, ST., M.Eng</h4>
                                <span>Wakil Dekan III</span>
                                <div class="social">
                                    <a href=""
                                        ><i class="bi bi-twitter-x"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-facebook"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-instagram"></i
                                    ></a>
                                    <a href=""
                                        ><i class="bi bi-linkedin"></i
                                    ></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Necessitatibus eius consequatur</p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                    <iframe
                        style="border: 0; width: 100%; height: 270px"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4939.990614457536!2d134.06726077584824!3d-0.8365593353017936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d540b1a808859d5%3A0xdd84617fd198bdfe!2sFakultas%20Teknik%20UNIPA!5e1!3m2!1sen!2sid!4v1752415144982!5m2!1sen!2sid"
                        frameborder="0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div
                                    class="info-item d-flex flex-column justify-content-center align-items-center"
                                    data-aos="fade-up"
                                    data-aos-delay="200"
                                >
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Address</h3>
                                    <p>
                                        {{
                                            siteSettings?.address ||
                                            "Jl, Gunung Salju Amban, Manokwari, Papua Barat"
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div
                                    class="info-item d-flex flex-column justify-content-center align-items-center"
                                    data-aos="fade-up"
                                    data-aos-delay="300"
                                >
                                    <i class="bi bi-telephone"></i>
                                    <h3>Call Us</h3>
                                    <p>
                                        {{
                                            siteSettings?.contact_phone ||
                                            "+62 81234567890"
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div
                                    class="info-item d-flex flex-column justify-content-center align-items-center"
                                    data-aos="fade-up"
                                    data-aos-delay="400"
                                >
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email Us</h3>
                                    <p>
                                        {{
                                            siteSettings?.contact_email ||
                                            "adminftpp@mail.com"
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <form
                            action="/contact"
                            method="post"
                            class="php-email-form"
                            data-aos="fade-up"
                            data-aos-delay="500"
                        >
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        placeholder="Your Name"
                                        required
                                    />
                                </div>

                                <div class="col-md-6">
                                    <input
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        placeholder="Your Email"
                                        required
                                    />
                                </div>

                                <div class="col-md-12">
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="subject"
                                        placeholder="Subject"
                                        required
                                    />
                                </div>

                                <div class="col-md-12">
                                    <textarea
                                        class="form-control"
                                        name="message"
                                        rows="4"
                                        placeholder="Message"
                                        required
                                    ></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">
                                        Your message has been sent. Thank you!
                                    </div>
                                    <button type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { onMounted } from "vue";

defineProps({
    hero: Object,
    about: Object,
    stats: Object,
    programStudis: Array,
    clients: Array,
    testimonials: Array,
    latestNews: Array,
    upcomingEvents: Array,
    gallery: Array,
    siteSettings: Object,
});

onMounted(() => {
    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== "undefined") {
        AOS.init();
    }

    // Initialize PureCounter
    if (typeof PureCounter !== "undefined") {
        new PureCounter();
    }

    // Initialize Swiper
    if (typeof Swiper !== "undefined") {
        new Swiper(".init-swiper", {
            loop: true,
            speed: 600,
            autoplay: {
                delay: 5000,
            },
            slidesPerView: "auto",
            pagination: {
                el: ".swiper-pagination",
                type: "bullets",
                clickable: true,
            },
        });
    }
});
</script>

<style>
/* Import the original CSS styles */
/* @import url("/storage/assets/css/main.css"); */
@import "/public/storage/assets/css/main.css";

/* Custom styles for Vue components */
#hero.dark-background {
    background-color: transparent !important;
    background-image: none !important;
}

#video-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
}

#hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 0;
}

#hero .container {
    position: relative;
    z-index: 1;
}
</style>
