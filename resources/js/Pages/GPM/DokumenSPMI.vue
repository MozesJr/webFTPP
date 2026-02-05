<template>
    <AppLayout>
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
                        <li class="current">Dokumen SPMI</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section py-16">
            <div class="container">
                <div class="section-title text-center mb-12" data-aos="fade-up">
                    <h2>{{ pageTitle }}</h2>
                    <p>Sistem Penjaminan Mutu Internal FTPP UNIPA</p>
                </div>

                <div class="row mb-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-8 mb-3">
                        <form @submit.prevent="handleSearch">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <svg
                                        class="w-5 h-5 text-gray-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        />
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Cari dokumen SPMI..."
                                    v-model="searchQuery"
                                    @input="handleSearch"
                                />
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <select
                            class="form-select"
                            v-model="selectedCategory"
                            @change="handleFilter"
                        >
                            <option value="">Semua Kategori</option>
                            <option
                                v-for="(cat, key) in categories"
                                :key="key"
                                :value="key"
                            >
                                {{ cat.label }} ({{ cat.count }})
                            </option>
                        </select>
                    </div>
                </div>

                <div
                    class="row gy-4 mb-8"
                    data-aos="fade-up"
                    data-aos-delay="150"
                >
                    <div
                        v-for="(cat, key) in categories"
                        :key="key"
                        class="col-lg-3 col-md-6"
                    >
                        <div
                            :class="`bg-${cat.color}-50 p-6 rounded-lg text-center h-100 cursor-pointer border-${selectedCategory === key ? cat.color + '-600' : 'transparent'}`"
                            @click="filterByCategory(key)"
                            style="border-width: 2px; border-style: solid"
                        >
                            <div
                                :class="`w-16 h-16 bg-${cat.color}-100 rounded-full flex items-center justify-center mx-auto mb-3`"
                            >
                                <svg
                                    class="w-8 h-8"
                                    :class="`text-${cat.color}-600`"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <h4
                                :class="`text-lg font-bold text-${cat.color}-900 mb-2`"
                            >
                                {{ cat.label }}
                            </h4>
                            <span
                                :class="`badge bg-${cat.color}-600 text-white px-3 py-2`"
                            >
                                {{ cat.count }} Dokumen
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    v-if="dokumens.data.length > 0"
                    class="row gy-4 mb-8"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <div
                        v-for="dokumen in dokumens.data"
                        :key="dokumen.id"
                        class="col-lg-4 col-md-6"
                    >
                        <div
                            class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6 h-100 border"
                        >
                            <div
                                class="d-flex justify-content-between align-items-start mb-3"
                            >
                                <span
                                    :class="`badge bg-${dokumen.category_color}-600 text-white`"
                                >
                                    {{ dokumen.category_label }}
                                </span>
                                <span
                                    v-if="dokumen.version"
                                    class="text-sm text-gray-500"
                                >
                                    v{{ dokumen.version }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                {{ dokumen.title }}
                            </h3>

                            <p
                                v-if="dokumen.description"
                                class="text-sm text-gray-600 mb-4 line-clamp-2"
                            >
                                {{ dokumen.description }}
                            </p>

                            <div class="text-sm text-gray-500 mb-4">
                                <div class="d-flex align-items-center mb-1">
                                    <svg
                                        class="w-4 h-4 me-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    {{ dokumen.file_size_human }}
                                </div>
                                <div
                                    v-if="dokumen.published_date"
                                    class="d-flex align-items-center"
                                >
                                    <svg
                                        class="w-4 h-4 me-2"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    {{ dokumen.published_date }}
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <Link
                                    :href="`/gpm/dokumen-spmi/${dokumen.slug}`"
                                    class="btn btn-outline-primary btn-sm flex-fill"
                                >
                                    Lihat
                                </Link>
                                <a
                                    :href="`/gpm/dokumen-spmi/${dokumen.slug}/download`"
                                    class="btn btn-primary btn-sm flex-fill"
                                    target="_blank"
                                >
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="row" data-aos="fade-up" data-aos-delay="250">
                    <div class="col-12">
                        <div
                            class="bg-white p-12 rounded-lg text-center border"
                        >
                            <svg
                                class="w-24 h-24 text-gray-400 mx-auto mb-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-700 mb-2">
                                Tidak Ada Dokumen
                            </h3>
                            <p class="text-gray-500">
                                {{
                                    searchQuery || selectedCategory
                                        ? "Tidak ditemukan dokumen yang sesuai dengan filter"
                                        : "Dokumen SPMI akan ditampilkan di sini setelah dikelola melalui dashboard admin"
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    v-if="dokumens.data.length > 0 && dokumens.last_page > 1"
                    class="row mt-12"
                >
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li
                                    class="page-item"
                                    :class="{
                                        disabled: !dokumens.prev_page_url,
                                    }"
                                >
                                    <Link
                                        :href="dokumens.prev_page_url || '#'"
                                        class="page-link"
                                        :only="['dokumens']"
                                        preserve-scroll
                                        >Previous</Link
                                    >
                                </li>

                                <li
                                    v-for="page in paginationPages"
                                    :key="page"
                                    class="page-item"
                                    :class="{
                                        active: page === dokumens.current_page,
                                        disabled: page === '...',
                                    }"
                                >
                                    <span
                                        v-if="page === '...'"
                                        class="page-link"
                                        >...</span
                                    >
                                    <Link
                                        v-else
                                        :href="`?page=${page}&search=${searchQuery}&category=${selectedCategory}`"
                                        class="page-link"
                                        preserve-scroll
                                    >
                                        {{ page }}
                                    </Link>
                                </li>

                                <li
                                    class="page-item"
                                    :class="{
                                        disabled: !dokumens.next_page_url,
                                    }"
                                >
                                    <Link
                                        :href="dokumens.next_page_url || '#'"
                                        class="page-link"
                                        :only="['dokumens']"
                                        preserve-scroll
                                        >Next</Link
                                    >
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-8 bg-gray-50">
            <div class="container text-center">
                <h4 class="mb-4">Menu GPM Lainnya</h4>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <Link href="/evaluation" class="btn btn-outline-primary"
                        >GPM Home</Link
                    >
                    <Link
                        href="/gpm/struktur-organisasi"
                        class="btn btn-outline-primary"
                        >Struktur Organisasi</Link
                    >
                    <Link
                        href="/gpm/survey-kepuasan"
                        class="btn btn-outline-primary"
                        >Survey Kepuasan</Link
                    >
                    <Link
                        href="/gpm/survey-edom"
                        class="btn btn-outline-primary"
                        >Survey EDOM</Link
                    >
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, computed, watch } from "vue";
import debounce from "lodash/debounce"; // Disarankan install lodash untuk search yang lebih smooth

const props = defineProps({
    pageTitle: { type: String, default: "Dokumen SPMI" },
    pageDescription: {
        type: String,
        default: "Dokumen Sistem Penjaminan Mutu Internal FTPP",
    },
    breadcrumbs: Array,
    dokumens: Object,
    categories: Object,
    filters: Object,
});

const searchQuery = ref(props.filters?.search || "");
const selectedCategory = ref(props.filters?.category || "");

// Fungsi search utama
const handleSearch = debounce(() => {
    router.get(
        route("gpm.dokumen-spmi"),
        {
            search: searchQuery.value,
            category: selectedCategory.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
}, 300);

const handleFilter = () => {
    handleSearch();
};

const filterByCategory = (category) => {
    // Toggle filter: jika klik kategori yang sama, maka reset ke "Semua"
    selectedCategory.value =
        selectedCategory.value === category ? "" : category;
    handleSearch();
};

// Logic Pagination
const paginationPages = computed(() => {
    if (!props.dokumens) return [];
    const current = props.dokumens.current_page;
    const last = props.dokumens.last_page;
    const delta = 2;
    const range = [];

    for (
        let i = Math.max(2, current - delta);
        i <= Math.min(last - 1, current + delta);
        i++
    ) {
        range.push(i);
    }
    if (current - delta > 2) range.unshift("...");
    if (current + delta < last - 1) range.push("...");

    range.unshift(1);
    if (last !== 1) range.push(last);

    return range.filter((v, i, a) => a.indexOf(v) === i);
});
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.cursor-pointer {
    cursor: pointer;
    transition: all 0.3s ease;
}

.cursor-pointer:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Custom colors for dynamic badges if not handled by Bootstrap */
.bg-blue-50 {
    background-color: #eff6ff;
}
.bg-green-50 {
    background-color: #f0fdf4;
}
.bg-purple-50 {
    background-color: #faf5ff;
}
.bg-yellow-50 {
    background-color: #fefce8;
}

.text-blue-600 {
    color: #2563eb;
}
.text-green-600 {
    color: #16a34a;
}
.text-purple-600 {
    color: #9333ea;
}
.text-yellow-600 {
    color: #ca8a04;
}
</style>
