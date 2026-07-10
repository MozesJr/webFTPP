<template>
    <AppLayout>
        <!-- Page Title -->
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>{{ dokumen.title }}</h1>
                <p>{{ dokumen.category_label }}</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/evaluation">GPM</Link></li>
                        <li>
                            <Link href="/gpm/dokumen-spmi">Dokumen SPMI</Link>
                        </li>
                        <li class="current">{{ dokumen.title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Document Detail Section -->
        <section class="section py-16">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="bg-white rounded-lg shadow-sm p-8 mb-6">
                            <div
                                class="d-flex justify-content-between align-items-start mb-4"
                            >
                                <span
                                    :class="`badge bg-${dokumen.category_color}-600 text-white px-3 py-2`"
                                >
                                    {{ dokumen.category_label }}
                                </span>
                                <span
                                    v-if="dokumen.version"
                                    class="text-gray-600"
                                >
                                    Version:
                                    <strong>{{ dokumen.version }}</strong>
                                </span>
                            </div>

                            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                                {{ dokumen.title }}
                            </h2>

                            <div
                                v-if="dokumen.description"
                                class="text-gray-700 mb-6"
                            >
                                {{ dokumen.description }}
                            </div>

                            <!-- Document Metadata -->
                            <div class="border-t border-b py-4 mb-6">
                                <div class="row gy-3">
                                    <div
                                        v-if="dokumen.document_code"
                                        class="col-md-6"
                                    >
                                        <div class="text-sm text-gray-500">
                                            Kode Dokumen
                                        </div>
                                        <div class="font-semibold">
                                            {{ dokumen.document_code }}
                                        </div>
                                    </div>
                                    <div
                                        v-if="dokumen.published_date"
                                        class="col-md-6"
                                    >
                                        <div class="text-sm text-gray-500">
                                            Tanggal Publikasi
                                        </div>
                                        <div class="font-semibold">
                                            {{ dokumen.published_date }}
                                        </div>
                                    </div>
                                    <div
                                        v-if="dokumen.effective_date"
                                        class="col-md-6"
                                    >
                                        <div class="text-sm text-gray-500">
                                            Tanggal Efektif
                                        </div>
                                        <div class="font-semibold">
                                            {{ dokumen.effective_date }}
                                        </div>
                                    </div>
                                    <div
                                        v-if="dokumen.review_date"
                                        class="col-md-6"
                                    >
                                        <div class="text-sm text-gray-500">
                                            Tanggal Review
                                        </div>
                                        <div class="font-semibold">
                                            {{ dokumen.review_date }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Download Button -->
                            <div class="text-center">
                                <a
                                    :href="`/gpm/dokumen-spmi/${dokumen.slug}/download`"
                                    class="btn btn-primary btn-lg px-6"
                                    target="_blank"
                                >
                                    <svg
                                        class="w-5 h-5 me-2"
                                        style="
                                            display: inline-block;
                                            vertical-align: middle;
                                        "
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    Download Dokumen
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- File Info Card -->
                        <div class="bg-white rounded-lg shadow-sm p-6 mb-4">
                            <h3 class="text-lg font-bold mb-4">
                                Informasi File
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-gray-500">
                                        Nama File
                                    </div>
                                    <div
                                        class="font-semibold text-sm break-all"
                                    >
                                        {{ dokumen.file_name }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">
                                        Ukuran
                                    </div>
                                    <div class="font-semibold">
                                        {{ dokumen.file_size_human }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">
                                        Tipe
                                    </div>
                                    <div class="font-semibold uppercase">
                                        {{ dokumen.file_type }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">
                                        Total Download
                                    </div>
                                    <div class="font-semibold">
                                        {{ dokumen.download_count }} kali
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">
                                        Total Dilihat
                                    </div>
                                    <div class="font-semibold">
                                        {{ dokumen.view_count }} kali
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <Link
                            href="/gpm/dokumen-spmi"
                            class="btn btn-outline-secondary w-100"
                        >
                            <svg
                                class="w-4 h-4 me-2"
                                style="
                                    display: inline-block;
                                    vertical-align: middle;
                                "
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Kembali ke Daftar Dokumen
                        </Link>
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
    pageTitle: String,
    pageDescription: String,
    dokumen: Object,
    breadcrumbs: Array,
});
</script>

<style scoped>
.space-y-3 > * + * {
    margin-top: 0.75rem;
}
</style>
