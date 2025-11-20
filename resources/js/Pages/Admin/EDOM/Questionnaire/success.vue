<!-- Success Page -->
<template name="EvaluationSuccess">
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
        <div
            class="max-w-md w-full bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center"
        >
            <div
                class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6"
            >
                <CheckCircleIcon class="h-8 w-8 text-green-600" />
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-4">
                Evaluasi Berhasil Dikirim!
            </h1>

            <p class="text-gray-600 mb-8">
                Terima kasih atas partisipasi Anda dalam mengisi kuesioner
                evaluasi. Masukan Anda sangat berharga untuk meningkatkan
                kualitas pembelajaran.
            </p>

            <div class="space-y-3">
                <Link
                    href="/evaluation"
                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <ArrowLeftIcon class="mr-2 h-4 w-4" />
                    Kembali ke Beranda
                </Link>

                <p class="text-xs text-gray-500">
                    Evaluasi ini telah tersimpan dan tidak dapat diubah
                </p>
            </div>
        </div>
    </div>
</template>

<script setup name="EvaluationSuccessScript">
import { Link } from "@inertiajs/vue3";
import { CheckCircleIcon, ArrowLeftIcon } from "@heroicons/vue/24/outline";
</script>
