<template>
    <component
        :is="tag"
        :href="href"
        :type="type"
        :disabled="disabled || loading"
        :class="buttonClasses"
        @click="$emit('click')"
    >
        <svg
            v-if="loading"
            class="animate-spin -ml-1 mr-3 h-5 w-5"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
        >
            <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
            ></circle>
            <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
        </svg>
        <slot />
    </component>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    variant: { type: String, default: "primary" },
    size: { type: String, default: "md" },
    href: String,
    type: { type: String, default: "button" },
    disabled: Boolean,
    loading: Boolean,
    block: Boolean,
});

defineEmits(["click"]);

const tag = computed(() => (props.href ? "a" : "button"));

const buttonClasses = computed(() => [
    "inline-flex items-center justify-center font-medium rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2",
    {
        // Variants
        "bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500":
            props.variant === "primary",
        "bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-blue-500":
            props.variant === "secondary",
        "bg-red-600 text-white hover:bg-red-700 focus:ring-red-500":
            props.variant === "danger",
        "text-blue-600 hover:text-blue-800 hover:bg-blue-50 focus:ring-blue-500":
            props.variant === "ghost",

        // Sizes
        "px-3 py-2 text-sm": props.size === "sm",
        "px-4 py-2 text-sm": props.size === "md",
        "px-6 py-3 text-base": props.size === "lg",

        // States
        "opacity-50 cursor-not-allowed": props.disabled || props.loading,
        "w-full": props.block,
    },
]);
</script>
