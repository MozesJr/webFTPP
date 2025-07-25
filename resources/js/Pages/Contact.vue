<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-800">
            <div class="container mx-auto px-4 text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Hubungi Kami
                </h1>
                <p class="text-xl md:text-2xl opacity-90 max-w-3xl mx-auto">
                    Kami siap membantu Anda dengan informasi yang dibutuhkan
                </p>
            </div>
        </section>

        <!-- Contact Content -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">
                            Informasi Kontak
                        </h2>

                        <div class="space-y-6">
                            <div
                                v-for="(contacts, type) in contactInfos"
                                :key="type"
                            >
                                <h3
                                    class="text-lg font-semibold text-gray-900 mb-4 capitalize"
                                >
                                    {{ type }}
                                </h3>
                                <div class="space-y-3">
                                    <div
                                        v-for="contact in contacts"
                                        :key="contact.id"
                                        class="flex items-start"
                                    >
                                        <div
                                            class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3"
                                        >
                                            <component
                                                :is="
                                                    getContactIcon(contact.type)
                                                "
                                                class="w-4 h-4 text-blue-600"
                                            />
                                        </div>
                                        <div>
                                            <div
                                                class="font-medium text-gray-900"
                                            >
                                                {{ contact.label }}
                                            </div>
                                            <div class="text-gray-600">
                                                <a
                                                    v-if="
                                                        contact.type === 'email'
                                                    "
                                                    :href="`mailto:${contact.value}`"
                                                    class="hover:text-blue-600"
                                                >
                                                    {{ contact.value }}
                                                </a>
                                                <a
                                                    v-else-if="
                                                        contact.type === 'phone'
                                                    "
                                                    :href="`tel:${contact.value}`"
                                                    class="hover:text-blue-600"
                                                >
                                                    {{ contact.value }}
                                                </a>
                                                <a
                                                    v-else-if="
                                                        contact.type ===
                                                        'social_media'
                                                    "
                                                    :href="contact.value"
                                                    target="_blank"
                                                    class="hover:text-blue-600"
                                                >
                                                    {{ contact.value }}
                                                </a>
                                                <span v-else>{{
                                                    contact.value
                                                }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Map placeholder -->
                        <div class="mt-8">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-4"
                            >
                                Lokasi
                            </h3>
                            <div
                                class="bg-gray-200 rounded-lg h-64 flex items-center justify-center"
                            >
                                <span class="text-gray-500"
                                    >Google Maps Integration</span
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div>
                        <div class="bg-white rounded-lg shadow-lg p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                Kirim Pesan
                            </h2>

                            <form @submit.prevent="submitForm">
                                <div class="space-y-6">
                                    <Input
                                        v-model="form.name"
                                        label="Nama Lengkap"
                                        required
                                        :error="errors.name"
                                    />

                                    <Input
                                        v-model="form.email"
                                        type="email"
                                        label="Email"
                                        required
                                        :error="errors.email"
                                    />

                                    <Input
                                        v-model="form.phone"
                                        type="tel"
                                        label="Nomor Telepon"
                                        :error="errors.phone"
                                    />

                                    <Input
                                        v-model="form.subject"
                                        label="Subjek"
                                        required
                                        :error="errors.subject"
                                    />

                                    <TextArea
                                        v-model="form.message"
                                        label="Pesan"
                                        rows="6"
                                        required
                                        :error="errors.message"
                                    />

                                    <Button
                                        type="submit"
                                        :loading="form.processing"
                                        block
                                        class="btn-lg"
                                    >
                                        Kirim Pesan
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Input from "@/Components/UI/Input.vue";
import TextArea from "@/Components/UI/TextArea.vue";
import Button from "@/Components/UI/Button.vue";
import {
    MapPinIcon,
    PhoneIcon,
    EnvelopeIcon,
    GlobeAltIcon,
} from "@heroicons/vue/24/outline";

defineProps({
    contactInfos: Object,
});

const form = useForm({
    name: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
});

const errors = {};

function submitForm() {
    form.post("/contact", {
        onSuccess: () => {
            form.reset();
        },
    });
}

function getContactIcon(type) {
    const icons = {
        address: MapPinIcon,
        phone: PhoneIcon,
        email: EnvelopeIcon,
        website: GlobeAltIcon,
        social_media: GlobeAltIcon,
    };
    return icons[type] || GlobeAltIcon;
}
</script>

<style scoped>
.btn-lg {
    @apply px-8 py-4 text-lg;
}
</style>
