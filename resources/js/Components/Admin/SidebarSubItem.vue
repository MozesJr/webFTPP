<template>
    <Link
        :href="href"
        :class="[
            'group flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200',
            active
                ? 'bg-blue-50 text-blue-700 font-medium'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
        ]"
    >
        <div class="flex items-center">
            <!-- Bullet point -->
            <div
                :class="[
                    'w-1.5 h-1.5 rounded-full mr-3 transition-colors',
                    active
                        ? 'bg-blue-600'
                        : 'bg-gray-300 group-hover:bg-gray-400',
                ]"
            ></div>
            <span>
                <slot />
            </span>
        </div>
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
    active: Boolean,
});
</script>
