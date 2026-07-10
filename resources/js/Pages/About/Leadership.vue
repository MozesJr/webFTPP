<template>
    <AppLayout>
        <div
            class="page-title dark-background"
            data-aos="fade"
            style="background-image: url(/theme-assets/assets/img/imgBg3.png)"
        >
            <div class="container position-relative">
                <h1>Pimpinan & Staff</h1>
                <p>Tim Kepemimpinan dan Tenaga Pengajar Berkualitas</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><Link href="/about">Tentang Fakultas</Link></li>
                        <li class="current">Pimpinan & Staff</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Leadership Team -->
        <section
            v-if="leadership && Object.keys(leadership).length > 0"
            class="section py-16"
        >
            <div class="container mx-auto px-4">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Pimpinan Fakultas
                    </h2>
                    <p class="text-lg text-gray-600">
                        Tim kepemimpinan yang berpengalaman dan berdedikasi
                    </p>
                </div>

                <div
                    v-for="(members, position) in leadership"
                    :key="position"
                    class="mb-16"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <h3
                        class="text-2xl font-semibold text-gray-900 mb-8 text-center"
                    >
                        {{ position }}
                    </h3>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                    >
                        <div
                            v-for="member in members"
                            :key="member.id"
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                        >
                            <!-- Member Photo -->
                            <div
                                class="aspect-square overflow-hidden bg-gray-100"
                            >
                                <img
                                    v-if="member.photo_url"
                                    :src="member.photo_url"
                                    :alt="member.name"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center"
                                >
                                    <svg
                                        class="w-20 h-20 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <!-- Member Info -->
                            <div class="p-6">
                                <h4
                                    class="text-xl font-bold text-gray-900 mb-2"
                                >
                                    {{ member.name }}
                                </h4>

                                <p class="text-blue-600 font-medium mb-2">
                                    {{ member.position?.name }}
                                </p>

                                <div
                                    v-if="member.education"
                                    class="text-sm text-gray-600 mb-3"
                                >
                                    {{ member.education }}
                                </div>

                                <div
                                    v-if="member.expertise"
                                    class="text-sm text-gray-600 mb-3"
                                >
                                    <strong>Keahlian:</strong>
                                    {{ member.expertise }}
                                </div>

                                <div
                                    v-if="member.email"
                                    class="text-sm text-gray-600 mb-2"
                                >
                                    <strong>Email:</strong>
                                    <a
                                        :href="`mailto:${member.email}`"
                                        class="text-blue-600 hover:text-blue-800"
                                    >
                                        {{ member.email }}
                                    </a>
                                </div>

                                <div
                                    v-if="member.phone"
                                    class="text-sm text-gray-600"
                                >
                                    <strong>Telepon:</strong> {{ member.phone }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Faculty Members -->
        <section
            v-if="faculty && Object.keys(faculty).length > 0"
            class="section py-16 bg-gray-50"
        >
            <div class="container mx-auto px-4">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Dosen & Staff
                    </h2>
                    <p class="text-lg text-gray-600">
                        Tim pengajar yang berkualitas per program studi
                    </p>
                </div>

                <div
                    v-for="(members, prodi) in faculty"
                    :key="prodi"
                    class="mb-16"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <h3
                        class="text-xl font-semibold text-gray-900 mb-8 text-center border-b border-gray-200 pb-4"
                    >
                        {{ prodi }}
                    </h3>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                    >
                        <div
                            v-for="member in members"
                            :key="member.id"
                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
                        >
                            <!-- Compact Member Photo -->
                            <div
                                class="aspect-square overflow-hidden bg-gray-100"
                            >
                                <img
                                    v-if="member.photo_url"
                                    :src="member.photo_url"
                                    :alt="member.name"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="w-full h-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center"
                                >
                                    <svg
                                        class="w-12 h-12 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <!-- Compact Member Info -->
                            <div class="p-4">
                                <h4
                                    class="text-lg font-bold text-gray-900 mb-1 line-clamp-2"
                                >
                                    {{ member.name }}
                                </h4>

                                <p
                                    class="text-blue-600 font-medium text-sm mb-2"
                                >
                                    {{ member.position?.name }}
                                </p>

                                <div
                                    v-if="member.education"
                                    class="text-xs text-gray-600 mb-2 line-clamp-2"
                                >
                                    {{ member.education }}
                                </div>

                                <div
                                    v-if="member.expertise"
                                    class="text-xs text-gray-600 line-clamp-2"
                                >
                                    <strong>Keahlian:</strong>
                                    {{ member.expertise }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-16">
            <div class="container">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Statistik Tim
                    </h3>
                </div>
                <div
                    class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <div class="stat-item">
                        <div class="text-4xl font-bold text-blue-600 mb-2">
                            {{ stats?.total_lecturers || 0 }}
                        </div>
                        <div class="text-gray-600">Total Dosen</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-4xl font-bold text-green-600 mb-2">
                            {{ getLeadershipCount() }}
                        </div>
                        <div class="text-gray-600">Pimpinan</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-4xl font-bold text-purple-600 mb-2">
                            {{ getFacultyCount() }}
                        </div>
                        <div class="text-gray-600">Dosen Program Studi</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-4xl font-bold text-orange-600 mb-2">
                            {{ faculty ? Object.keys(faculty).length : 0 }}
                        </div>
                        <div class="text-gray-600">Program Studi</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Empty State -->
        <section
            v-if="
                (!leadership || Object.keys(leadership).length === 0) &&
                (!faculty || Object.keys(faculty).length === 0)
            "
            class="py-16"
        >
            <div class="container">
                <div class="text-center">
                    <svg
                        class="w-24 h-24 mx-auto text-gray-300 mb-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM9 9a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-500 mb-2">
                        Belum Ada Data Tim
                    </h3>
                    <p class="text-gray-400">
                        Data pimpinan dan staff akan segera diperbarui.
                    </p>
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

const props = defineProps({
    leadership: {
        type: Object,
        default: () => ({}),
    },
    faculty: {
        type: Object,
        default: () => ({}),
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
});

function getLeadershipCount() {
    if (!props.leadership) return 0;
    let count = 0;
    Object.values(props.leadership).forEach((members) => {
        if (Array.isArray(members)) {
            count += members.length;
        }
    });
    return count;
}

function getFacultyCount() {
    if (!props.faculty) return 0;
    let count = 0;
    Object.values(props.faculty).forEach((members) => {
        if (Array.isArray(members)) {
            count += members.length;
        }
    });
    return count;
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
