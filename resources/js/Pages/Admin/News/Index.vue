<template>
    <AdminLayout>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Berita</h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola berita dan artikel website
                        </p>
                    </div>
                    <Link
                        href="/admin/news/create"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Berita
                    </Link>
                </div>
            </div>
        </div>

        <DataTable
            :title="'Daftar Berita'"
            :headers="tableHeaders"
            :items="news.data"
            :filters="filters"
            :pagination="news"
            :route-name="'admin.news.index'"
            :additional-filters="additionalFilters"
        >
            <template #body="{ items }">
                <tr v-if="items.length === 0">
                    <td
                        :colspan="tableHeaders.length"
                        class="px-6 py-12 text-center"
                    >
                        <DocumentTextIcon
                            class="mx-auto h-12 w-12 text-gray-400"
                        />
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Belum ada berita
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai dengan menambahkan berita pertama.
                        </p>
                        <div class="mt-6">
                            <Link
                                href="/admin/news/create"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                <PlusIcon class="w-4 h-4 mr-2" />
                                Tambah Berita
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr
                    v-for="article in items"
                    :key="article.id"
                    class="hover:bg-gray-50"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-20">
                                <img
                                    v-if="article.featured_image"
                                    :src="getImageUrl(article.featured_image)"
                                    :alt="article.title"
                                    class="h-12 w-20 rounded-lg object-cover"
                                />
                                <div
                                    v-else
                                    class="h-12 w-20 rounded-lg bg-gray-200 flex items-center justify-center"
                                >
                                    <DocumentTextIcon
                                        class="h-6 w-6 text-gray-400"
                                    />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div
                                    class="text-sm font-medium text-gray-900 max-w-xs truncate"
                                >
                                    {{ article.title }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ article.author?.name || "Admin" }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getCategoryColor(article.category)"
                        >
                            {{ article.category?.name || "Umum" }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getStatusColor(article.status)"
                        >
                            {{ getStatusLabel(article.status) }}
                        </span>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                    >
                        <div class="flex items-center">
                            <EyeIcon class="h-4 w-4 text-gray-400 mr-1" />
                            {{ article.views_count || 0 }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-1">
                            <span
                                v-if="article.is_featured"
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                            >
                                <StarIcon class="h-3 w-3 mr-1" />
                                Featured
                            </span>
                            <span
                                v-if="article.published_at"
                                class="text-xs text-gray-500"
                            >
                                {{ formatDate(article.published_at) }}
                            </span>
                        </div>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <div class="flex items-center justify-end space-x-2">
                            <Link
                                :href="`/admin/news/${article.id}/edit`"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <PencilIcon class="h-4 w-4 mr-1" />
                                Edit
                            </Link>

                            <button
                                @click="handleDelete(article)"
                                type="button"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                <TrashIcon class="h-4 w-4 mr-1" />
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            </template>
        </DataTable>
    </AdminLayout>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    DocumentTextIcon,
    EyeIcon,
    StarIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/24/outline";
import DataTable from "@/Components/DataTable.vue";

// Props
const props = defineProps({
    news: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    categories: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({ search: "", category: "", status: "" }),
    },
});

// Table Headers
const tableHeaders = ref([
    { key: "title", label: "Judul", align: "left" },
    { key: "category", label: "Kategori", align: "left" },
    { key: "status", label: "Status", align: "left" },
    { key: "views", label: "Views", align: "left" },
    { key: "info", label: "Info", align: "left" },
    { key: "actions", label: "Aksi", align: "right" },
]);

// Additional filters for DataTable
const additionalFilters = computed(() => [
    {
        key: "category",
        label: "Kategori",
        type: "select",
        options: [
            { value: "", label: "Semua Kategori" },
            ...props.categories.map((cat) => ({
                value: cat.id.toString(),
                label: cat.name,
            })),
        ],
    },
    {
        key: "status",
        label: "Status",
        type: "select",
        options: [
            { value: "", label: "Semua Status" },
            { value: "draft", label: "Draft" },
            { value: "published", label: "Published" },
            { value: "archived", label: "Archived" },
        ],
    },
]);

// Composables
const page = usePage();
const { success, error, confirmDelete } = useSwal();

// Methods
const getImageUrl = (imagePath) => {
    if (!imagePath) return null;
    if (imagePath.startsWith("http")) return imagePath;
    return `/${
        imagePath.startsWith("storage/") ? imagePath : "storage/" + imagePath
    }`;
};

const getCategoryColor = (category) => {
    if (!category) return "bg-gray-100 text-gray-800";

    const colors = {
        Berita: "bg-blue-100 text-blue-800",
        Pengumuman: "bg-green-100 text-green-800",
        Artikel: "bg-purple-100 text-purple-800",
        Event: "bg-yellow-100 text-yellow-800",
    };

    return colors[category.name] || "bg-gray-100 text-gray-800";
};

const getStatusColor = (status) => {
    const colors = {
        draft: "bg-gray-100 text-gray-800",
        published: "bg-green-100 text-green-800",
        archived: "bg-red-100 text-red-800",
    };
    return colors[status] || "bg-gray-100 text-gray-800";
};

const getStatusLabel = (status) => {
    const labels = {
        draft: "Draft",
        published: "Published",
        archived: "Archived",
    };
    return labels[status] || status;
};

const formatDate = (date) => {
    if (!date) return "-";
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const handleDelete = async (article) => {
    const result = await confirmDelete(
        "Hapus Berita?",
        `Berita "${article.title}" akan dihapus permanen!`
    );

    if (result.isConfirmed) {
        router.delete(route("admin.news.destroy", article.id), {
            preserveScroll: true,
            onSuccess: () => {
                success("Berhasil!", "Berita berhasil dihapus.");
            },
            onError: (errors) => {
                console.log("Delete errors:", errors);
                error("Error!", "Terjadi kesalahan saat menghapus data.");
            },
        });
    }
};

const handleFlashMessages = () => {
    try {
        const flash = page.props.value?.flash;
        if (flash?.message) {
            success("Berhasil!", flash.message);
        }
        if (flash?.error) {
            error("Error!", flash.error);
        }
    } catch (e) {
        console.log("Flash message error:", e);
    }
};

// Lifecycle
onMounted(() => {
    handleFlashMessages();
});
</script>
