<template>
    <section
        class="relative h-screen flex items-center justify-center overflow-hidden"
    >
        <!-- Background Video/Image -->
        <div class="absolute inset-0 z-0">
            <video
                v-if="hero.background_video_url"
                autoplay
                muted
                loop
                class="w-full h-full object-cover"
            >
                <source :src="hero.background_video_url" type="video/mp4" />
            </video>
            <img
                v-else-if="hero.background_image_url"
                :src="hero.background_image_url"
                alt="Hero Background"
                class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                {{ hero.title }}
            </h1>
            <p
                v-if="hero.subtitle"
                class="text-xl md:text-xl mb-8 max-w-3xl mx-auto"
            >
                {{ hero.subtitle }}
            </p>
            <div class="space-x-4">
                <Link href="/program-studi" class="btn btn-primary btn-lg">
                    Jelajahi Program
                </Link>
                <button
                    v-if="hero.explanation_video_url"
                    @click="showVideo = true"
                    class="btn btn-outline btn-white btn-lg"
                >
                    <PlayIcon class="w-5 h-5 mr-2" />
                    Tonton Video
                </button>
            </div>
        </div>

        <!-- Video Modal -->
        <Modal v-if="showVideo" @close="showVideo = false">
            <div class="aspect-video">
                <iframe
                    :src="hero.explanation_video_url"
                    class="w-full h-full rounded-lg"
                    frameborder="0"
                    allowfullscreen
                >
                </iframe>
            </div>
        </Modal>
    </section>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { PlayIcon } from "@heroicons/vue/24/solid";
import Modal from "@/Components/UI/Modal.vue";

defineProps({
    hero: {
        type: Object,
        required: true,
    },
});

const showVideo = ref(false);
</script>

<style scoped>
.btn-lg {
    @apply px-8 py-4 text-lg;
}
</style>
