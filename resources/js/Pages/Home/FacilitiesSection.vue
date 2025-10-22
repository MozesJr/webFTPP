<!-- resources/js/Components/Home/FacilitiesSection.vue -->
<template>
    <section id="facilities" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <span
                    class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-4"
                >
                    Fasilitas
                </span>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Fasilitas yang Dimiliki FTPP
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Berbagai fasilitas modern untuk mendukung kegiatan akademik
                    dan penelitian mahasiswa
                </p>
            </div>

            <!-- Facilities Grid -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12"
            >
                <div
                    v-for="facility in facilities"
                    :key="facility.id"
                    class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 group"
                    data-aos="fade-up"
                >
                    <!-- Image -->
                    <div class="relative h-48 overflow-hidden">
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
                                class="w-16 h-16 text-white opacity-50"
                            />
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <h3
                            class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-blue-600 transition"
                        >
                            {{ facility.name }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{
                                facility.short_description ||
                                facility.description
                            }}
                        </p>
                        <Link
                            :href="route('facilities.show', facility.slug)"
                            class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold text-sm group/btn"
                        >
                            Lihat Detail
                            <ArrowRightIcon
                                class="w-4 h-4 ml-1 group-hover/btn:translate-x-1 transition-transform"
                            />
                        </Link>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center" data-aos="fade-up">
                <Link
                    :href="route('facilities.index')"
                    class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg hover:shadow-xl font-semibold"
                >
                    Lihat Semua Fasilitas
                    <ArrowRightIcon class="w-5 h-5 ml-2" />
                </Link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { BuildingOffice2Icon, ArrowRightIcon } from "@heroicons/vue/24/outline";

defineProps({
    facilities: {
        type: Array,
        default: () => [],
    },
});
</script>

<style scoped>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
