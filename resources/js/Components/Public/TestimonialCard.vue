<template>
    <div
        class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300"
    >
        <!-- Rating -->
        <div class="flex items-center mb-4">
            <div class="flex space-x-1">
                <StarIcon
                    v-for="i in 5"
                    :key="i"
                    :class="
                        i <= testimonial.rating
                            ? 'text-yellow-400'
                            : 'text-gray-300'
                    "
                    class="w-4 h-4 fill-current"
                />
            </div>
        </div>

        <!-- Content -->
        <blockquote class="text-gray-700 mb-6 italic">
            "{{ testimonial.content }}"
        </blockquote>

        <!-- Author -->
        <div class="flex items-center">
            <img
                :src="testimonial.photo_url"
                :alt="testimonial.name"
                class="w-12 h-12 rounded-full object-cover mr-4"
            />
            <div>
                <div class="font-semibold text-gray-900">
                    {{ testimonial.name }}
                </div>
                <div class="text-sm text-gray-600">
                    {{ testimonial.position }}
                    <span v-if="testimonial.company">
                        - {{ testimonial.company }}</span
                    >
                </div>
                <div
                    v-if="testimonial.program_studi"
                    class="text-xs text-blue-600"
                >
                    {{ testimonial.program_studi.name }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { StarIcon } from "@heroicons/vue/24/solid";

defineProps({
    testimonial: {
        type: Object,
        required: true,
    },
});
</script>
