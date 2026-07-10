<!-- resources/js/Pages/Facilities/Show.vue -->
<template>
    <GuestLayout>
        <!-- Hero Section -->
        <section
            class="page-title dark-background py-12"
            :style="`background-image: url(${'/theme-assets/assets/img/imgBg2.png'})`"
        >
            <div class="container mx-auto px-4">
                <nav class="mb-6" data-aos="fade-right">
                    <ol
                        class="flex items-center space-x-2 text-sm text-blue-100"
                    >
                        <li>
                            <Link
                                :href="route('home')"
                                class="hover:text-white transition"
                            >
                                Home
                            </Link>
                        </li>
                        <li>/</li>
                        <li>
                            <Link
                                :href="route('facilities.index')"
                                class="hover:text-white transition"
                            >
                                Fasilitas
                            </Link>
                        </li>
                        <li>/</li>
                        <li class="text-white font-medium">
                            {{ facility.name }}
                        </li>
                    </ol>
                </nav>

                <div class="max-w-4xl">
                    <div class="mb-4" data-aos="fade-up">
                        <span
                            :class="[
                                'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold',
                                facility.is_available
                                    ? 'bg-green-500 text-white'
                                    : 'bg-yellow-500 text-white',
                            ]"
                        >
                            {{
                                facility.is_available
                                    ? "Tersedia"
                                    : "Tidak Tersedia"
                            }}
                        </span>
                    </div>
                    <h1
                        class="text-4xl md:text-5xl font-bold text-white mb-4"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        {{ facility.name }}
                    </h1>
                    <p
                        v-if="facility.short_description"
                        class="text-xl text-blue-100"
                        data-aos="fade-up"
                        data-aos-delay="200"
                    >
                        {{ facility.short_description }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Main Image -->
                        <div
                            v-if="facility.image_url"
                            class="rounded-2xl overflow-hidden shadow-xl"
                            data-aos="fade-up"
                        >
                            <img
                                :src="facility.image_url"
                                :alt="facility.name"
                                class="w-full h-96 object-cover"
                            />
                        </div>

                        <!-- Description -->
                        <div
                            class="bg-white rounded-2xl shadow-lg p-8"
                            data-aos="fade-up"
                        >
                            <h2
                                class="text-2xl font-bold text-gray-900 mb-4 flex items-center"
                            >
                                <InformationCircleIcon
                                    class="w-6 h-6 mr-2 text-blue-600"
                                />
                                Deskripsi
                            </h2>
                            <p
                                class="text-gray-700 leading-relaxed whitespace-pre-line"
                            >
                                {{ facility.description }}
                            </p>
                        </div>

                        <!-- Features -->
                        <div
                            v-if="
                                facility.features &&
                                facility.features.length > 0
                            "
                            class="bg-white rounded-2xl shadow-lg p-8"
                            data-aos="fade-up"
                        >
                            <h2
                                class="text-2xl font-bold text-gray-900 mb-6 flex items-center"
                            >
                                <SparklesIcon
                                    class="w-6 h-6 mr-2 text-blue-600"
                                />
                                Fitur & Kelengkapan
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    v-for="(
                                        feature, index
                                    ) in facility.features"
                                    :key="index"
                                    class="flex items-start bg-blue-50 rounded-lg p-4"
                                >
                                    <CheckCircleIcon
                                        class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5"
                                    />
                                    <span class="text-gray-800">{{
                                        feature
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery -->
                        <div
                            v-if="
                                facility.gallery_urls &&
                                facility.gallery_urls.length > 0
                            "
                            class="bg-white rounded-2xl shadow-lg p-8"
                            data-aos="fade-up"
                        >
                            <h2
                                class="text-2xl font-bold text-gray-900 mb-6 flex items-center"
                            >
                                <PhotoIcon class="w-6 h-6 mr-2 text-blue-600" />
                                Galeri Foto
                            </h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <img
                                    v-for="(
                                        url, index
                                    ) in facility.gallery_urls"
                                    :key="index"
                                    :src="url"
                                    :alt="facility.name"
                                    class="w-full h-40 object-cover rounded-lg shadow-md cursor-pointer hover:scale-105 transition-transform duration-300"
                                    @click="openLightbox(index)"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Specs Card -->
                        <div
                            class="bg-white rounded-2xl shadow-lg p-6 sticky top-6"
                            data-aos="fade-left"
                        >
                            <h3
                                class="text-xl font-bold text-gray-900 mb-4 flex items-center"
                            >
                                <BuildingOffice2Icon
                                    class="w-5 h-5 mr-2 text-blue-600"
                                />
                                Informasi
                            </h3>
                            <div class="space-y-4">
                                <div v-if="facility.location">
                                    <div
                                        class="flex items-start text-gray-600 mb-2"
                                    >
                                        <MapPinIcon
                                            class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5 text-blue-600"
                                        />
                                        <div>
                                            <p
                                                class="text-xs font-medium text-gray-500 uppercase"
                                            >
                                                Lokasi
                                            </p>
                                            <p
                                                class="text-gray-900 font-medium"
                                            >
                                                {{ facility.location }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="facility.capacity">
                                    <div
                                        class="flex items-start text-gray-600 mb-2"
                                    >
                                        <UsersIcon
                                            class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5 text-blue-600"
                                        />
                                        <div>
                                            <p
                                                class="text-xs font-medium text-gray-500 uppercase"
                                            >
                                                Kapasitas
                                            </p>
                                            <p
                                                class="text-gray-900 font-medium"
                                            >
                                                {{ facility.capacity }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="facility.area">
                                    <div
                                        class="flex items-start text-gray-600 mb-2"
                                    >
                                        <Square3Stack3DIcon
                                            class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5 text-blue-600"
                                        />
                                        <div>
                                            <p
                                                class="text-xs font-medium text-gray-500 uppercase"
                                            >
                                                Luas Area
                                            </p>
                                            <p
                                                class="text-gray-900 font-medium"
                                            >
                                                {{ facility.area }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact -->
                            <div
                                v-if="
                                    facility.contact_person ||
                                    facility.contact_phone ||
                                    facility.contact_email
                                "
                                class="mt-6 pt-6 border-t border-gray-200"
                            >
                                <h4
                                    class="text-sm font-bold text-gray-900 mb-3"
                                >
                                    Kontak
                                </h4>
                                <div class="space-y-2">
                                    <p
                                        v-if="facility.contact_person"
                                        class="text-sm text-gray-700"
                                    >
                                        <span class="font-medium">Nama:</span>
                                        {{ facility.contact_person }}
                                    </p>
                                    <p v-if="facility.contact_phone">
                                        <a
                                            :href="
                                                'tel:' + facility.contact_phone
                                            "
                                            class="text-sm text-blue-600 hover:text-blue-800 flex items-center"
                                        >
                                            <PhoneIcon class="w-4 h-4 mr-2" />
                                            {{ facility.contact_phone }}
                                        </a>
                                    </p>
                                    <p v-if="facility.contact_email">
                                        <a
                                            :href="
                                                'mailto:' +
                                                facility.contact_email
                                            "
                                            class="text-sm text-blue-600 hover:text-blue-800 flex items-center"
                                        >
                                            <EnvelopeIcon
                                                class="w-4 h-4 mr-2"
                                            />
                                            {{ facility.contact_email }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <!-- Back Button -->
                            <div class="mt-6">
                                <Link
                                    :href="route('facilities.index')"
                                    class="w-full inline-flex justify-center items-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold"
                                >
                                    <ArrowLeftIcon class="w-4 h-4 mr-2" />
                                    Kembali ke Daftar
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Facilities -->
        <section v-if="relatedFacilities.length > 0" class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2
                    class="text-3xl font-bold text-gray-900 mb-8 text-center"
                    data-aos="fade-up"
                >
                    Fasilitas Lainnya
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div
                        v-for="related in relatedFacilities"
                        :key="related.id"
                        class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition"
                        data-aos="fade-up"
                    >
                        <div class="relative h-48">
                            <img
                                v-if="related.image_url"
                                :src="related.image_url"
                                :alt="related.name"
                                class="w-full h-full object-cover"
                            />
                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-indigo-500"
                            >
                                <BuildingOffice2Icon
                                    class="w-16 h-16 text-white opacity-50"
                                />
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                {{ related.name }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{
                                    related.short_description ||
                                    related.description
                                }}
                            </p>
                            <Link
                                :href="route('facilities.show', related.slug)"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold"
                            >
                                Lihat Detail
                                <ArrowRightIcon class="w-4 h-4 ml-2" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {
    BuildingOffice2Icon,
    MapPinIcon,
    UsersIcon,
    Square3Stack3DIcon,
    PhoneIcon,
    EnvelopeIcon,
    ArrowLeftIcon,
    ArrowRightIcon,
    PhotoIcon,
    InformationCircleIcon,
    SparklesIcon,
    CheckCircleIcon,
} from "@heroicons/vue/24/outline";

// Props
defineProps({
    facility: Object,
    relatedFacilities: Array,
});

// Methods
const openLightbox = (index) => {
    // Implement lightbox (e.g., using photoswipe, fslightbox, etc.)
    console.log("Open lightbox at index:", index);
};
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
