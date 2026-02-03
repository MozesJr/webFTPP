<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    questionCount: Number,
});

const form = useForm({
    name: "",
    semester: "ganjil",
    academic_year: "",
    start_date: "",
    end_date: "",
    description: "",
    instructions: "",
    is_active: false,
    require_all_courses: true,
    show_results_to_students: false,
});

const submit = () => form.post(route("admin.gpm.edom-period.store"));
</script>

<template>
    <Head title="Tambah Periode EDOM" />
    <AdminLayout>
        <div class="py-6 max-w-4xl mx-auto px-4">
            <Link
                :href="route('admin.gpm.edom-period.index')"
                class="text-sm text-gray-500 flex items-center mb-4"
            >
                <ArrowLeftIcon class="w-4 h-4 mr-1" /> Kembali
            </Link>

            <form
                @submit.prevent="submit"
                class="bg-white p-6 rounded-lg shadow-sm space-y-6"
            >
                <div class="border-b pb-4">
                    <h2 class="text-xl font-bold">Konfigurasi Periode Baru</h2>
                    <p class="text-sm text-blue-600 mt-1">
                        Saat ini terdapat {{ questionCount }} pertanyaan aktif
                        yang akan digunakan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium"
                            >Nama Periode*</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Misal: EDOM Ganjil 2025/2026"
                            class="mt-1 block w-full rounded-md border-gray-300"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium"
                            >Semester*</label
                        >
                        <select
                            v-model="form.semester"
                            class="mt-1 block w-full rounded-md border-gray-300"
                        >
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium"
                            >Tahun Akademik*</label
                        >
                        <input
                            v-model="form.academic_year"
                            type="text"
                            placeholder="2025/2026"
                            class="mt-1 block w-full rounded-md border-gray-300"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium"
                            >Tanggal Mulai*</label
                        >
                        <input
                            v-model="form.start_date"
                            type="date"
                            class="mt-1 block w-full rounded-md border-gray-300"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium"
                            >Tanggal Selesai*</label
                        >
                        <input
                            v-model="form.end_date"
                            type="date"
                            class="mt-1 block w-full rounded-md border-gray-300"
                            required
                        />
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t">
                    <label class="flex items-center">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            class="rounded text-blue-600"
                        />
                        <span class="ml-2 text-sm"
                            >Aktifkan periode ini sekarang (Akan menonaktifkan
                            periode lain)</span
                        >
                    </label>
                    <label class="flex items-center">
                        <input
                            v-model="form.require_all_courses"
                            type="checkbox"
                            class="rounded text-blue-600"
                        />
                        <span class="ml-2 text-sm text-gray-600 font-medium"
                            >Mahasiswa wajib mengisi semua mata kuliah</span
                        >
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700"
                    >
                        Simpan Periode
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
