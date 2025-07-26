<template>
    <AppLayout>
        <!-- Hero Section -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(storage/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Program Studi</h1>
                <p>
                    Pilih program studi yang sesuai dengan minat dan bakat Anda
                </p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Profil Fakultas</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Program List by Degree Level -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div
                    v-for="(programs, level) in programStudis"
                    :key="level"
                    class="mb-16"
                >
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            {{ getDegreeTitle(level) }}
                        </h2>
                        <p class="text-lg text-gray-600">
                            {{ getDegreeDescription(level) }}
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                    >
                        <ProgramCard
                            v-for="program in programs"
                            :key="program.id"
                            :program="program"
                        />
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import ProgramCard from "@/Components/Public/ProgramCard.vue";

defineProps({
    programStudis: Object,
});

function getDegreeTitle(level) {
    const titles = {
        D3: "Program Diploma III",
        S1: "Program Sarjana (S1)",
        S2: "Program Magister (S2)",
        S3: "Program Doktor (S3)",
    };
    return titles[level] || level;
}

function getDegreeDescription(level) {
    const descriptions = {
        D3: "Program vokasi 3 tahun dengan fokus pada keahlian praktis",
        S1: "Program sarjana 4 tahun dengan keseimbangan teori dan praktik",
        S2: "Program magister 2 tahun untuk spesialisasi lanjutan",
        S3: "Program doktor untuk penelitian dan pengembangan ilmu pengetahuan",
    };
    return descriptions[level] || "";
}
</script>

<style scoped>
.btn-lg {
    @apply px-8 py-4 text-lg;
}
</style>
