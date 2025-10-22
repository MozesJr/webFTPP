<!-- resources/js/Pages/Facilities/Index.vue -->
<template>
    <GuestLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-blue-600 to-indigo-700 py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto text-center">
                    <h1
                        class="text-4xl md:text-5xl font-bold text-white mb-4"
                        data-aos="fade-up"
                    >
                        Fasilitas FTPP UNIPA
                    </h1>
                    <p
                        class="text-xl text-blue-100 mb-8"
                        data-aos="fade-up"
                        data-aos-delay="100"
                    >
                        Berbagai fasilitas modern untuk mendukung kegiatan
                        akademik dan penelitian
                    </p>

                    <!-- Search Bar -->
                    <div
                        class="max-w-2xl mx-auto"
                        data-aos="fade-up"
                        data-aos-delay="200"
                    >
                        <form @submit.prevent="searchFacilities">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari fasilitas..."
                                    class="w-full px-6 py-4 pr-12 rounded-full text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg"
                                />
                                <button
                                    type="submit"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 p-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition"
                                >
                                    <MagnifyingGlassIcon class="w-5 h-5" />
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Facilities Grid Section -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <!-- Results Info -->
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <p class="text-gray-600">
                            Menampilkan
                            <span class="font-semibold">{{
                                facilities.from
                            }}</span>
                            -
                            <span class="font-semibold">{{
                                facilities.to
                            }}</span>
                            dari
                            <span class="font-semibold">{{
                                facilities.total
                            }}</span>
                            fasilitas
                        </p>
                    </div>
                    <button
                        v-if="search"
                        @click="clearSearch"
                        class="text-sm text-blue-600 hover:text-blue-800 flex items-center"
                    >
                        <XMarkIcon class="w-4 h-4 mr-1" />
                        Hapus Filter
                    </button>
                </div>

                <!-- Empty State -->
                <div
                    v-if="facilities.data.length === 0"
                    class="text-center py-16"
                >
                    <BuildingOffice2Icon
                        class="mx-auto h-16 w-16 text-gray-400"
                    />
                    <h3 class="mt-4 text-xl font-medium text-gray-900">
                        Fasilitas tidak ditemukan
                    </h3>
                    <p class="mt-2 text-gray-600">
                        Coba gunakan kata kunci pencarian yang berbeda
                    </p>
                </div>

                <!-- Facilities Grid -->
                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="facility in facilities.data"
                        :key="facility.id"
                        class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 group"
                        data-aos="fade-up"
                    >
                        <!-- Image -->
                        <div class="relative h-56 overflow-hidden">
                            <img
                                v-if="facility.image_url"
                                :src="facility.image_url"
                                :alt="facility.name"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            />
                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-indigo-500"
                            >
                                <BuildingOffice2Icon
                                    class="w-20 h-20 text-white opacity-50"
                                />
                            </div>

                            <!-- Availability Badge -->
                            <div class="absolute top-3 right-3">
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
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3
                                class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition"
                            >
                                {{ facility.name }}
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{
                                    facility.short_description ||
                                    facility.description
                                }}
                            </p>

                            <!-- Info Tags -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    v-if="facility.location"
                                    class="inline-flex items-center text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded"
                                >
                                    <MapPinIcon class="w-3 h-3 mr-1" />
                                    {{ facility.location }}
                                </span>
                                <span
                                    v-if="facility.capacity"
                                    class="inline-flex items-center text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded"
                                >
                                    <UsersIcon class="w-3 h-3 mr-1" />
                                    {{ facility.capacity }}
                                </span>
                            </div>

                            <!-- Button -->
                            <Link
                                :href="route('facilities.show', facility.slug)"
                                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold group/btn"
                            >
                                Lihat Detail
                                <ArrowRightIcon
                                    class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform"
                                />
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div
                    v-if="facilities.last_page > 1"
                    class="mt-12 flex justify-center"
                >
                    <nav
                        class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                    >
                        <Link
                            v-for="link in facilities.links"
                            :key="link.label"
                            :href="link.url"
                            :class="[
                                'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                link.active
                                    ? 'z-10 bg-blue-600 border-blue-600 text-white'
                                    : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50',
                                !link.url
                                    ? 'cursor-not-allowed opacity-50'
                                    : '',
                            ]"
                            v-html="link.label"
                        />
                    </nav>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {
    MagnifyingGlassIcon,
    BuildingOffice2Icon,
    MapPinIcon,
    UsersIcon,
    ArrowRightIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    facilities: Object,
    search: String,
});

// State
const searchQuery = ref(props.search || "");

// Methods
const searchFacilities = () => {
    router.get(
        route("facilities.index"),
        { search: searchQuery.value },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const clearSearch = () => {
    searchQuery.value = "";
    router.get(route("facilities.index"));
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
