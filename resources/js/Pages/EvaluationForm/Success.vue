<template>
    <AppLayout>
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Form Evaluasi EDOM</h1>
                <p>{{ questionnaire.title }}</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>
                            <Link :href="route('evaluation.index')">EDOM</Link>
                        </li>
                        <li class="current">Evaluasi</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="min-vh-100 d-flex align-items-center bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="text-center">
                            <!-- Success Icon -->
                            <div class="mb-4">
                                <div class="success-icon mx-auto mb-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>

                            <!-- Success Message -->
                            <h1 class="display-6 text-success mb-3">
                                Evaluasi Berhasil Dikirim!
                            </h1>

                            <p class="lead text-muted mb-4">
                                Terima kasih atas partisipasi Anda dalam
                                evaluasi dosen. Masukan Anda sangat berharga
                                untuk peningkatan kualitas pendidikan.
                            </p>

                            <!-- Information Cards -->
                            <div class="row g-3 mb-5">
                                <div class="col-md-4">
                                    <div
                                        class="card border-0 bg-white shadow-sm h-100"
                                    >
                                        <div class="card-body text-center py-4">
                                            <i
                                                class="bi bi-shield-check text-primary mb-2"
                                                style="font-size: 2rem"
                                            ></i>
                                            <h6 class="mb-1">Anonim</h6>
                                            <small class="text-muted"
                                                >Data Anda aman dan
                                                terjaga</small
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div
                                        class="card border-0 bg-white shadow-sm h-100"
                                    >
                                        <div class="card-body text-center py-4">
                                            <i
                                                class="bi bi-clock text-success mb-2"
                                                style="font-size: 2rem"
                                            ></i>
                                            <h6 class="mb-1">Tersimpan</h6>
                                            <small class="text-muted"
                                                >Evaluasi telah terekam</small
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div
                                        class="card border-0 bg-white shadow-sm h-100"
                                    >
                                        <div class="card-body text-center py-4">
                                            <i
                                                class="bi bi-graph-up text-warning mb-2"
                                                style="font-size: 2rem"
                                            ></i>
                                            <h6 class="mb-1">Berdampak</h6>
                                            <small class="text-muted"
                                                >Membantu peningkatan
                                                mutu</small
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="d-flex flex-column flex-sm-row gap-3 justify-content-center"
                            >
                                <Link
                                    :href="route('evaluation.index')"
                                    class="btn btn-primary btn-lg px-4"
                                >
                                    <i class="bi bi-list-check me-2"></i>
                                    Lihat Evaluasi Lainnya
                                </Link>

                                <Link
                                    href="/"
                                    class="btn btn-outline-secondary btn-lg px-4"
                                >
                                    <i class="bi bi-house me-2"></i>
                                    Kembali ke Beranda
                                </Link>
                            </div>

                            <!-- Additional Info -->
                            <div class="mt-5 p-4 bg-light rounded">
                                <h6 class="text-muted mb-2">
                                    Informasi Penting:
                                </h6>
                                <ul class="list-unstyled text-muted small mb-0">
                                    <li class="mb-1">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Evaluasi Anda akan digunakan untuk
                                        perbaikan kualitas pengajaran
                                    </li>
                                    <li class="mb-1">
                                        <i class="bi bi-eye-slash me-2"></i>
                                        Identitas Anda tidak akan diungkapkan
                                        kepada dosen yang dievaluasi
                                    </li>
                                    <li>
                                        <i class="bi bi-envelope me-2"></i>
                                        Jika ada pertanyaan, hubungi bagian
                                        akademik
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<style scoped>
.success-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    animation: scaleIn 0.5s ease-out;
}

.success-icon i {
    font-size: 4rem;
    color: white;
    animation: bounceIn 0.8s ease-out 0.2s both;
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes bounceIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>
