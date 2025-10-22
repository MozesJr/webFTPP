<!-- resources/js/Components/Home/DeanGreetingSection.vue -->
<template>
    <section
        v-if="greeting && greeting.is_active"
        id="dean-greeting"
        class="features section"
    >
        <!-- Section Header -->
        <div class="container section-title" data-aos="fade-up">
            <h2>{{ greeting.section_title }}</h2>
            <p>{{ greeting.section_subtitle }}</p>
        </div>

        <!-- Content -->
        <div class="container">
            <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
                <div class="tab-pane fade active show">
                    <div class="row">
                        <!-- Text Content -->
                        <div
                            class="col-lg-9 order-2 order-lg-1"
                            data-aos="fade-right"
                        >
                            <p class="fst-italic greeting-text">
                                {{ greeting.greeting_text }}
                            </p>
                            <h3 class="dean-name">
                                {{ greeting.full_dean_name }}
                            </h3>
                        </div>

                        <!-- Photo -->
                        <div
                            v-if="greeting.dean_photo_url"
                            class="col-lg-3 order-1 order-lg-2 text-center"
                            data-aos="fade-left"
                        >
                            <img
                                :src="greeting.dean_photo_url"
                                :alt="greeting.full_dean_name"
                                class="img-fluid dean-photo"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
defineProps({
    greeting: {
        type: Object,
        default: null,
    },
});
</script>

<style scoped>
.greeting-text {
    text-align: justify;
    line-height: 1.8;
    margin-bottom: 2rem;
}

.dean-name {
    font-weight: 600;
    color: #2c3e50;
    margin-top: 1.5rem;
}

.dean-photo {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.dean-photo:hover {
    transform: scale(1.05);
}

@media (max-width: 991px) {
    .dean-photo {
        max-width: 300px;
        margin: 0 auto 2rem;
    }
}
</style>
