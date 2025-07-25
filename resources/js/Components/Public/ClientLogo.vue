<template>
    <div class="flex items-center justify-center p-4">
        <img
            :src="client.logo_url"
            :alt="client.name"
            class="max-h-12 w-auto opacity-60 hover:opacity-100 transition-opacity duration-300 filter grayscale hover:grayscale-0"
        />
    </div>
</template>

<script setup>
defineProps({
    client: {
        type: Object,
        required: true,
    },
});
</script>
