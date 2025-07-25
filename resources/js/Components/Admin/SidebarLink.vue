<template>
    <Link
        :href="href"
        class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200"
        :class="
            active
                ? 'bg-gray-900 text-white'
                : 'text-gray-300 hover:bg-gray-700 hover:text-white'
        "
    >
        <slot />
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
    active: Boolean,
});
</script>
