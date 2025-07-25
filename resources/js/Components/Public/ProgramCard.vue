<template>
    <div
        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
    >
        <!-- Image -->
        <div class="aspect-video bg-gray-200 overflow-hidden">
            <img
                :src="program.image_url"
                :alt="program.name"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
            />
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Badge -->
            <div class="flex items-center justify-between mb-3">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                >
                    {{ program.degree_level }}
                </span>
                <span
                    v-if="program.accreditation"
                    class="text-sm text-green-600 font-medium"
                >
                    {{ program.accreditation }}
                </span>
            </div>

            <!-- Title -->
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                {{ program.name }}
            </h3>

            <!-- Description -->
            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                {{ program.description }}
            </p>

            <!-- Features -->
            <div
                v-if="program.features && program.features.length"
                class="mb-4"
            >
                <div class="flex flex-wrap gap-1">
                    <span
                        v-for="feature in program.features.slice(0, 3)"
                        :key="feature.id"
                        class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-gray-700"
                    >
                        {{ feature.title }}
                    </span>
                </div>
            </div>

            <!-- Action -->
            <Link
                :href="`/program-studi/${program.code}`"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium"
            >
                Pelajari Lebih Lanjut
                <ArrowRightIcon class="w-4 h-4 ml-1" />
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ArrowRightIcon } from "@heroicons/vue/24/outline";

defineProps({
    program: {
        type: Object,
        required: true,
    },
});
</script>
