<template>
    <Link
        :href="href"
        class="relative group bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md hover:border-gray-300 transition-all duration-200 block"
    >
        <div class="flex items-center">
            <div
                :class="`bg-${color}-100 text-${color}-600 group-hover:bg-${color}-200`"
                class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-colors"
            >
                <component :is="iconComponent" class="w-5 h-5" />
            </div>
            <div class="ml-4 flex-1">
                <h3
                    class="text-sm font-medium text-gray-900 group-hover:text-gray-700"
                >
                    {{ title }}
                </h3>
                <p class="text-xs text-gray-500 mt-1">{{ description }}</p>
            </div>
            <div v-if="badge" class="flex-shrink-0">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"
                >
                    {{ badge }}
                </span>
            </div>
        </div>
    </Link>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    PlusIcon,
    AcademicCapIcon,
    EnvelopeIcon,
    CogIcon,
    EyeIcon,
    DocumentTextIcon,
    CalendarIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: String,
    description: String,
    icon: String,
    color: { type: String, default: "blue" },
    href: String,
    badge: [Number, String],
});

const iconComponent = computed(() => {
    const icons = {
        PlusIcon,
        AcademicCapIcon,
        EnvelopeIcon,
        CogIcon,
        EyeIcon,
        DocumentTextIcon,
        CalendarIcon,
    };
    return icons[props.icon] || PlusIcon;
});
</script>
