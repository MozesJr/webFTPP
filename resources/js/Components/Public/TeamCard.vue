<template>
    <div
        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
    >
        <!-- Photo -->
        <div
            :class="size === 'compact' ? 'aspect-square' : 'aspect-[4/3]'"
            class="bg-gray-200 overflow-hidden"
        >
            <img
                :src="member.photo_url"
                :alt="member.name"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
            />
        </div>

        <!-- Content -->
        <div :class="size === 'compact' ? 'p-4' : 'p-6'">
            <h3
                :class="size === 'compact' ? 'text-lg' : 'text-xl'"
                class="font-semibold text-gray-900 mb-2"
            >
                {{ member.name }}
            </h3>

            <p class="text-blue-600 font-medium mb-2">
                {{ member.position.name }}
            </p>

            <p
                v-if="member.program_studi && size !== 'compact'"
                class="text-sm text-gray-600 mb-3"
            >
                {{ member.program_studi.name }}
            </p>

            <p
                v-if="member.bio && size !== 'compact'"
                class="text-gray-600 text-sm mb-4 line-clamp-3"
            >
                {{ member.bio }}
            </p>

            <!-- Contact Info -->
            <div class="space-y-1">
                <p
                    v-if="member.email"
                    class="text-sm text-gray-500 flex items-center"
                >
                    <EnvelopeIcon class="w-4 h-4 mr-2" />
                    <a
                        :href="`mailto:${member.email}`"
                        class="hover:text-blue-600"
                        >{{ member.email }}</a
                    >
                </p>
                <p
                    v-if="member.phone && size !== 'compact'"
                    class="text-sm text-gray-500 flex items-center"
                >
                    <PhoneIcon class="w-4 h-4 mr-2" />
                    {{ member.phone }}
                </p>
            </div>

            <!-- Expertise Tags -->
            <div v-if="member.expertise && size !== 'compact'" class="mt-4">
                <div class="flex flex-wrap gap-1">
                    <span
                        v-for="skill in member.expertise.split(',').slice(0, 3)"
                        :key="skill"
                        class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-gray-700"
                    >
                        {{ skill.trim() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { EnvelopeIcon, PhoneIcon } from "@heroicons/vue/24/outline";

defineProps({
    member: {
        type: Object,
        required: true,
    },
    size: {
        type: String,
        default: "default", // 'default' or 'compact'
    },
});
</script>
