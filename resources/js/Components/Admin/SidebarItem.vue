<template>
    <Link
        :href="href"
        :class="[
            'group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200',
            active
                ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-600'
                : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900',
        ]"
    >
        <component
            :is="iconComponent"
            :class="[
                'flex-shrink-0 w-5 h-5 mr-3 transition-colors',
                active
                    ? 'text-blue-600'
                    : 'text-gray-400 group-hover:text-gray-600',
            ]"
        />
        <span class="flex-1">
            <slot />
        </span>
        <span
            v-if="badge"
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2"
        >
            {{ badge }}
        </span>
    </Link>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    HomeIcon,
    AcademicCapIcon,
    NewspaperIcon,
    UsersIcon,
    CalendarIcon,
    PhotoIcon,
    EnvelopeIcon,
    CogIcon,
    FolderIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    href: String,
    active: Boolean,
    icon: String,
    badge: [Number, String],
});

const iconComponent = computed(() => {
    const icons = {
        HomeIcon,
        AcademicCapIcon,
        NewspaperIcon,
        UsersIcon,
        CalendarIcon,
        PhotoIcon,
        EnvelopeIcon,
        CogIcon,
        FolderIcon,
    };
    return icons[props.icon] || HomeIcon;
});
</script>
