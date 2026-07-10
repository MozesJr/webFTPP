<template>
    <AppLayout>
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>{{ about.title }}</h1>
                <p>{{ about.subtitle }}</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/about">Tentang Fakultas</Link></li>
                        <li class="current">Profil Fakultas</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Profile Section -->
        <section id="profile" class="about section">
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
                        <p>{{ about.subtitle }}</p>
                        <p>{{ about.description }}</p>
                    </div>

                    <div
                        class="col-lg-6 mb-6"
                        data-aos="fade-up"
                        data-aos-delay="250"
                    >
                        <div class="content ps-0 ps-lg-5">
                            <div class="position-relative mt-4">
                                <img
                                    v-if="about.image_url"
                                    :src="about.image_url"
                                    class="img-fluid rounded-4"
                                    alt="Profile Image"
                                />
                                <img
                                    v-else
                                    src="theme-assets/assets/img/About1.jpeg"
                                    class="img-fluid rounded-4"
                                    alt="Default Profile Image"
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
                </div>
            </div>

            <!-- Video Modal -->
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

        <!-- Navigation to other sections -->
        <section class="py-8 bg-gray-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="mb-4">Informasi Lainnya</h4>
                            <div
                                class="d-flex flex-wrap justify-content-center gap-3"
                            >
                                <Link
                                    href="/about/vision-mission"
                                    class="btn btn-outline-primary"
                                >
                                    Visi & Misi
                                </Link>
                                <Link
                                    href="/about/history"
                                    class="btn btn-outline-primary"
                                >
                                    Sejarah
                                </Link>
                                <Link
                                    href="/about/program-studi"
                                    class="btn btn-outline-primary"
                                >
                                    Program Studi
                                </Link>
                                <Link
                                    href="/about/accreditation"
                                    class="btn btn-outline-primary"
                                >
                                    Akreditasi
                                </Link>
                                <Link
                                    href="/about/leadership"
                                    class="btn btn-outline-primary"
                                >
                                    Pimpinan & Staff
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
import { Link } from "@inertiajs/vue3";
import { PlayIcon } from "@heroicons/vue/24/solid";
import Modal from "@/Components/UI/Modal.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    about: Object,
});

const showVideo = ref(false);
</script>
