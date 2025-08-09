<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Detail Dokumen Penjaminan Mutu
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Informasi lengkap dokumen penjaminan mutu
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <Link
                            href="/admin/penjaminan-mutu"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <ArrowLeftIcon class="w-4 h-4 mr-2" />
                            Kembali
                        </Link>
                        <Link
                            :href="`/admin/penjaminan-mutu/${penjaminanMutu.id}/edit`"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <PencilIcon class="w-4 h-4 mr-2" />
                            Edit
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Document Info -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Informasi Dokumen
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Judul Dokumen
                            </label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ penjaminanMutu.title }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Program Studi
                                </label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{
                                        penjaminanMutu.program_studi?.name ||
                                        "-"
                                    }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Jenis Dokumen
                                </label>
                                <span
                                    class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800"
                                >
                                    {{ penjaminanMutu.document_type }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Versi
                                </label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ penjaminanMutu.version }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Status
                                </label>
                                <span
                                    :class="
                                        getStatusClass(penjaminanMutu.status)
                                    "
                                >
                                    {{ getStatusLabel(penjaminanMutu.status) }}
                                </span>
                            </div>
                        </div>

                        <div v-if="penjaminanMutu.description">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Deskripsi
                            </label>
                            <p
                                class="mt-1 text-sm text-gray-900 whitespace-pre-wrap"
                            >
                                {{ penjaminanMutu.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Document File -->
                <div
                    v-if="penjaminanMutu.document_url"
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            File Dokumen
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div
                            class="flex items-center p-4 bg-gray-50 rounded-lg border"
                        >
                            <DocumentTextIcon
                                class="h-10 w-10 text-blue-600 mr-4"
                            />
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ penjaminanMutu.title }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    File dokumen tersedia untuk diunduh
                                </p>
                            </div>
                            <a
                                :href="`/admin/penjaminan-mutu/${penjaminanMutu.id}/download`"
                                target="_blank"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                                Download
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Tanggal Penting
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Efektif
                                </label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{
                                        formatDate(
                                            penjaminanMutu.effective_date
                                        )
                                    }}
                                </p>
                            </div>

                            <div v-if="penjaminanMutu.review_date">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Review
                                </label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ formatDate(penjaminanMutu.review_date) }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Dibuat Pada
                                </label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{
                                        formatDateTime(
                                            penjaminanMutu.created_at
                                        )
                                    }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Terakhir Diperbarui
                                </label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{
                                        formatDateTime(
                                            penjaminanMutu.updated_at
                                        )
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Aksi Cepat
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <Link
                            :href="`/admin/penjaminan-mutu/${penjaminanMutu.id}/edit`"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <PencilIcon class="h-4 w-4 mr-2" />
                            Edit Dokumen
                        </Link>

                        <button
                            v-if="penjaminanMutu.document_url"
                            @click="downloadDocument"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-green-300 shadow-sm text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
                            Download File
                        </button>

                        <button
                            @click="handleDelete"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            <TrashIcon class="h-4 w-4 mr-2" />
                            Hapus Dokumen
                        </button>
                    </div>
                </div>

                <!-- Document Details -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">
                            Detail Tambahan
                        </h2>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Dibuat Oleh
                            </label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ penjaminanMutu.created_by || "-" }}
                            </p>
                        </div>

                        <div v-if="penjaminanMutu.approved_by">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Disetujui Oleh
                            </label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ penjaminanMutu.approved_by }}
                            </p>
                        </div>

                        <div v-if="penjaminanMutu.approved_at">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Tanggal Persetujuan
                            </label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ formatDateTime(penjaminanMutu.approved_at) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    ArrowLeftIcon,
    PencilIcon,
    DocumentTextIcon,
    ArrowDownTrayIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    penjaminanMutu: {
        type: Object,
        required: true,
    },
});

// Composables
const { success, error, confirmDelete } = useSwal();

// Methods
const getStatusClass = (status) => {
    const classes = {
        draft: "mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800",
        active: "mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800",
        obsolete:
            "mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800",
    };
    return classes[status] || classes.draft;
};

const getStatusLabel = (status) => {
    const labels = {
        draft: "Draft",
        active: "Active",
        obsolete: "Obsolete",
    };
    return labels[status] || status;
};

const formatDate = (dateString) => {
    if (!dateString) return "-";
    return new Date(dateString).toLocaleDateString("id-ID");
};

const formatDateTime = (dateString) => {
    if (!dateString) return "-";
    return new Date(dateString).toLocaleString("id-ID");
};

const downloadDocument = () => {
    window.open(
        route("admin.penjaminan-mutu.download", props.penjaminanMutu.id),
        "_blank"
    );
};

const handleDelete = async () => {
    const result = await confirmDelete(
        "Hapus Dokumen?",
        `Dokumen "${props.penjaminanMutu.title}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(`/admin/penjaminan-mutu/${props.penjaminanMutu.id}`, {
            onSuccess: () => {
                success("Berhasil!", "Dokumen berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus dokumen.");
            },
        });
    }
};
</script>
