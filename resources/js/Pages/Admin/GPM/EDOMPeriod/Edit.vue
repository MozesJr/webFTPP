<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    period: Object,
    questionCount: Number,
});

const form = useForm({
    name: props.period.name,
    semester: props.period.semester,
    academic_year: props.period.academic_year,
    start_date: props.period.start_date,
    end_date: props.period.end_date,
    description: props.period.description,
    is_active: Boolean(props.period.is_active),
    is_published: Boolean(props.period.is_published),
    require_all_courses: Boolean(props.period.require_all_courses),
});

const submit = () =>
    form.put(route("admin.gpm.edom-period.update", props.period.id));
</script>

<template>
    <Head title="Edit Periode EDOM" />
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
                <h2 class="text-xl font-bold border-b pb-4">
                    Edit Periode: {{ period.name }}
                </h2>

                <div class="flex justify-end gap-3 pt-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700"
                    >
                        Perbarui Periode
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
