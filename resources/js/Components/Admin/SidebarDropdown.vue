<template>
    <div class="space-y-1">
        <!-- Dropdown Toggle -->
        <button
            @click="isOpen = !isOpen"
            :class="[
                'group w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200',
                active
                    ? 'bg-blue-50 text-blue-700'
                    : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
            ]"
        >
            <component
                :is="iconComponent"
                :class="[
                    'flex-shrink-0 w-5 h-5 mr-3 transition-colors',
                    active ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600'
                ]"
            />
            <span class="flex-1 text-left">{{ title }}</span>
            <ChevronDownIcon
                :class="[
                    'w-4 h-4 transition-transform duration-200',
                    isOpen ? 'rotate-180' : 'rotate-0',
                    active ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600'
                ]"
            />
        </button>

        <!-- Dropdown Content -->
        <div
            v-show="isOpen"
            class="ml-8 space-y-1 transition-all duration-200"
        >
            <slot />
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
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
    ChevronDownIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: String,
    icon: String,
    active: Boolean,
});

const isOpen = ref(false);

// Auto-open if active
onMounted(() => {
    if (props.active) {
        isOpen.value = true;
    }
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
