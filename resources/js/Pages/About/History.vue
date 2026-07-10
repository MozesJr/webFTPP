<template>
    <AppLayout>
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Sejarah Fakultas</h1>
                <p>Perjalanan Panjang Menuju Keunggulan</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/about">Tentang Fakultas</Link></li>
                        <li class="current">Sejarah</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- History Section -->
        <section id="sejarah" class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>Sejarah Fakultas</h2>
                    <p>Perjalanan Panjang Menuju Keunggulan<br /></p>
                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <!-- Main History Content -->
                    <div class="col-lg-8 mb-8">
                        <div class="bg-white p-8 rounded-lg shadow-sm">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">
                                Sejarah Singkat
                            </h3>
                            <div class="prose prose-lg">
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    {{
                                        sejarah ||
                                        "Sejarah fakultas akan segera diperbarui."
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Sidebar -->
                    <div class="col-lg-4 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h4 class="text-xl font-bold text-blue-900 mb-6">
                                Timeline Penting
                            </h4>

                            <!-- Timeline Items -->
                            <div class="space-y-4">
                                <div
                                    v-for="milestone in milestones"
                                    :key="milestone.year"
                                    class="flex"
                                >
                                    <div
                                        class="flex-shrink-0 w-16 text-sm font-bold text-blue-600"
                                    >
                                        {{ milestone.year }}
                                    </div>
                                    <div class="flex-1 ml-4">
                                        <p class="text-sm text-gray-700">
                                            {{ milestone.event }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Milestone Details -->
                <div
                    v-if="milestoneDetails && milestoneDetails.length"
                    class="row mt-12"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <div class="col-12">
                        <h3
                            class="text-2xl font-bold text-gray-900 mb-8 text-center"
                        >
                            Milestone Penting
                        </h3>

                        <div class="timeline">
                            <div
                                v-for="(detail, index) in milestoneDetails"
                                :key="index"
                                class="timeline-item mb-8"
                                :class="
                                    index % 2 === 0
                                        ? 'timeline-left'
                                        : 'timeline-right'
                                "
                            >
                                <div
                                    class="timeline-content bg-white p-6 rounded-lg shadow-sm"
                                >
                                    <div
                                        class="timeline-year bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold mb-4"
                                    >
                                        {{ detail.year }}
                                    </div>
                                    <h4
                                        class="text-lg font-bold text-gray-900 mb-3"
                                    >
                                        {{ detail.title }}
                                    </h4>
                                    <p class="text-gray-700">
                                        {{ detail.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Gallery if available -->
                <div
                    v-if="historyImages && historyImages.length"
                    class="row mt-12"
                    data-aos="fade-up"
                    data-aos-delay="300"
                >
                    <div class="col-12">
                        <h3
                            class="text-2xl font-bold text-gray-900 mb-8 text-center"
                        >
                            Galeri Sejarah
                        </h3>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                        >
                            <div
                                v-for="(image, index) in historyImages"
                                :key="index"
                                class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow"
                            >
                                <img
                                    :src="image.url"
                                    :alt="image.caption"
                                    class="w-full h-48 object-cover"
                                />
                                <div class="p-4">
                                    <p class="text-sm text-gray-600">
                                        {{ image.caption }}
                                    </p>
                                    <p
                                        v-if="image.year"
                                        class="text-xs text-gray-500 mt-1"
                                    >
                                        {{ image.year }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                    href="/about/profile"
                                    class="btn btn-outline-primary"
                                >
                                    Profil Fakultas
                                </Link>
                                <Link
                                    href="/about/vision-mission"
                                    class="btn btn-outline-primary"
                                >
                                    Visi & Misi
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
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    sejarah: String,
    milestones: Array,
    milestoneDetails: Array,
    historyImages: Array,
});

// Default milestones if not provided from database
const defaultMilestones = [
    { year: "1985", event: "Pendirian Fakultas Teknik Pertambangan" },
    { year: "1992", event: "Pembukaan Program Studi Teknik Perminyakan" },
    { year: "2005", event: "Pembukaan Program Studi Teknik Geologi" },
    { year: "2010", event: "Memperoleh Akreditasi A dari BAN-PT" },
    { year: "2015", event: "Pembukaan Program Magister Teknik Pertambangan" },
    { year: "2020", event: "Pembukaan Program Doktor Teknik Pertambangan" },
];
</script>

<style scoped>
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: "";
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #3b82f6;
}

.timeline-item {
    position: relative;
}

.timeline-item::before {
    content: "";
    position: absolute;
    left: -1.5rem;
    top: 1rem;
    width: 12px;
    height: 12px;
    background: #3b82f6;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px #3b82f6;
}

.timeline-content {
    margin-left: 1rem;
}

.prose {
    max-width: none;
}
</style>
