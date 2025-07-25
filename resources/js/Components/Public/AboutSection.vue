<template>
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">
                        {{ about.title }}
                    </h2>
                    <p v-if="about.subtitle" class="text-xl text-gray-600 mb-6">
                        {{ about.subtitle }}
                    </p>
                    <div
                        class="prose prose-lg text-gray-700 mb-8"
                        v-html="about.description"
                    ></div>

                    <!-- Vision & Mission -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div
                            v-if="about.vision"
                            class="bg-blue-50 p-6 rounded-lg"
                        >
                            <h3
                                class="text-lg font-semibold text-blue-900 mb-3"
                            >
                                Visi
                            </h3>
                            <p class="text-blue-800">{{ about.vision }}</p>
                        </div>
                        <div
                            v-if="about.mission"
                            class="bg-green-50 p-6 rounded-lg"
                        >
                            <h3
                                class="text-lg font-semibold text-green-900 mb-3"
                            >
                                Misi
                            </h3>
                            <p class="text-green-800">{{ about.mission }}</p>
                        </div>
                    </div>

                    <!-- Video Button -->
                    <div class="flex space-x-4">
                        <Link href="/about" class="btn btn-primary">
                            Pelajari Lebih Lanjut
                        </Link>
                        <button
                            v-if="about.video_url"
                            @click="showVideo = true"
                            class="btn btn-outline"
                        >
                            <PlayIcon class="w-5 h-5 mr-2" />
                            {{ about.video_title || "Tonton Video" }}
                        </button>
                    </div>
                </div>

                <!-- Image -->
                <div class="relative">
                    <img
                        :src="about.image_url"
                        :alt="about.title"
                        class="w-full h-96 object-cover rounded-lg shadow-lg"
                    />

                    <!-- Play button overlay for video -->
                    <div
                        v-if="about.video_url"
                        class="absolute inset-0 flex items-center justify-center"
                    >
                        <button
                            @click="showVideo = true"
                            class="bg-white bg-opacity-90 hover:bg-opacity-100 rounded-full p-4 shadow-lg transition-all duration-200"
                        >
                            <PlayIcon class="w-12 h-12 text-blue-600" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Modal -->
        <!-- <Modal v-if="showVideo" @close="showVideo = false">
            <div class="aspect-video">
                <iframe
                    :src="about.video_url"
                    class="w-full h-full rounded-lg"
                    frameborder="0"
                    allowfullscreen
                >
                </iframe>
            </div>
        </Modal> -->
    </section>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { PlayIcon } from "@heroicons/vue/24/solid";
import Modal from "@/Components/UI/Modal.vue";

defineProps({
    about: {
        type: Object,
        required: true,
    },
});

const showVideo = ref(false);
</script>
