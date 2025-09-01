<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <AcademicCapIcon class="h-8 w-8 text-indigo-600" />
                        </div>
                        <div class="ml-3">
                            <h1 class="text-xl font-semibold text-gray-900">
                                Evaluasi Dosen Oleh Mahasiswa (EDOM)
                            </h1>
                            <p class="text-sm text-gray-600">
                                Sistem evaluasi kinerja dosen
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Welcome Section -->
            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8"
            >
                <div class="px-6 py-6">
                    <div class="text-center">
                        <DocumentTextIcon
                            class="mx-auto h-12 w-12 text-indigo-600 mb-4"
                        />
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            Selamat Datang di Portal EDOM
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">
                            Partisipasi Anda dalam mengisi kuesioner evaluasi
                            sangat berharga untuk meningkatkan kualitas
                            pembelajaran dan pengajaran di program studi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Available Questionnaires -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Kuesioner yang Tersedia
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Pilih kuesioner yang ingin Anda isi
                    </p>
                </div>

                <div
                    v-if="questionnaires.length === 0"
                    class="px-6 py-12 text-center"
                >
                    <ClockIcon class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-4 text-lg font-medium text-gray-900">
                        Belum Ada Kuesioner Aktif
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Saat ini belum ada kuesioner evaluasi yang tersedia.
                        Silakan cek kembali nanti.
                    </p>
                </div>

                <div v-else class="divide-y divide-gray-200">
                    <div
                        v-for="questionnaire in questionnaires"
                        :key="questionnaire.id"
                        class="px-6 py-6 hover:bg-gray-50 transition-colors duration-150"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        {{ questionnaire.title }}
                                    </h4>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                    >
                                        Aktif
                                    </span>
                                </div>

                                <div class="space-y-2">
                                    <div
                                        class="flex items-center text-sm text-gray-600"
                                    >
                                        <BuildingOfficeIcon
                                            class="h-4 w-4 mr-2"
                                        />
                                        <span>{{
                                            questionnaire.program_studi?.name
                                        }}</span>
                                    </div>

                                    <div
                                        class="flex items-center text-sm text-gray-600"
                                    >
                                        <CalendarIcon class="h-4 w-4 mr-2" />
                                        <span
                                            >{{ questionnaire.semester }} -
                                            {{
                                                questionnaire.academic_year
                                            }}</span
                                        >
                                    </div>

                                    <div
                                        v-if="questionnaire.end_date"
                                        class="flex items-center text-sm text-gray-600"
                                    >
                                        <ClockIcon class="h-4 w-4 mr-2" />
                                        <span
                                            >Berakhir:
                                            {{
                                                formatDate(
                                                    questionnaire.end_date
                                                )
                                            }}</span
                                        >
                                    </div>

                                    <div
                                        v-if="questionnaire.description"
                                        class="text-sm text-gray-600 mt-2"
                                    >
                                        {{ questionnaire.description }}
                                    </div>
                                </div>
                            </div>

                            <div class="ml-6">
                                <Link
                                    :href="`/evaluation/${questionnaire.id}/create`"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Isi Kuesioner
                                    <ArrowRightIcon class="ml-2 h-4 w-4" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Panel -->
            <div class="mt-8 bg-blue-50 rounded-lg border border-blue-200">
                <div class="px-6 py-4">
                    <div class="flex">
                        <InformationCircleIcon
                            class="h-5 w-5 text-blue-400 mt-0.5"
                        />
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Informasi Penting
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>
                                        Setiap mahasiswa hanya dapat mengisi
                                        satu kali untuk setiap kuesioner
                                    </li>
                                    <li>
                                        Pastikan NIM dan email yang Anda
                                        masukkan sesuai dengan data yang
                                        terdaftar
                                    </li>
                                    <li>
                                        Jawaban yang Anda berikan bersifat
                                        rahasia dan hanya digunakan untuk
                                        evaluasi
                                    </li>
                                    <li>
                                        Harap isi dengan jujur dan objektif
                                        untuk membantu meningkatkan kualitas
                                        pembelajaran
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import {
    AcademicCapIcon,
    DocumentTextIcon,
    ClockIcon,
    BuildingOfficeIcon,
    CalendarIcon,
    ArrowRightIcon,
    InformationCircleIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    questionnaires: {
        type: Array,
        default: () => [],
    },
});

// Methods
const formatDate = (date) => {
    return new Date(date).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};
</script>
