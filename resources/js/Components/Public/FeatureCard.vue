<template>
    <div class="text-center p-6">
        <!-- Icon -->
        <div
            class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center"
        >
            <component :is="iconComponent" class="w-8 h-8 text-blue-600" />
        </div>

        <!-- Title -->
        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ title }}</h3>

        <!-- Description -->
        <p class="text-gray-600">{{ description }}</p>
    </div>
</template>

<script setup>
import { computed } from "vue";
import {
    AcademicCapIcon,
    UsersIcon,
    BuildingOfficeIcon,
    BookOpenIcon,
    GlobeAltIcon,
    SparklesIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: String,
    description: String,
    icon: String,
});

const iconComponent = computed(() => {
    const icons = {
        "academic-cap": AcademicCapIcon,
        users: UsersIcon,
        "building-office": BuildingOfficeIcon,
        "book-open": BookOpenIcon,
        "globe-alt": GlobeAltIcon,
        sparkles: SparklesIcon,
    };
    return icons[props.icon] || SparklesIcon;
});
</script>
