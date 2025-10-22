<!-- resources/js/Pages/Admin/Facility/Index.vue -->
<template>
    <AdminLayout>
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Kelola Fasilitas
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            Kelola fasilitas yang dimiliki FTPP UNIPA
                        </p>
                    </div>
                    <Link
                        :href="route('admin.facilities.create')"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="w-4 h-4 mr-2" />
                        Tambah Fasilitas
                    </Link>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label
                            for="search"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Cari Fasilitas
                        </label>
                        <div class="relative">
                            <input
                                id="search"
                                v-model="searchForm.search"
                                type="text"
                                placeholder="Cari nama, deskripsi, lokasi..."
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                @input="debounceSearch"
                            />
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                            >
                                <MagnifyingGlassIcon
                                    class="h-5 w-5 text-gray-400"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Status
                        </label>
                        <select
                            id="status"
                            v-model="searchForm.status"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            @change="search"
                        >
                            <option value="all">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- Availability Filter -->
                    <div>
                        <label
                            for="availability"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Ketersediaan
                        </label>
                        <select
                            id="availability"
                            v-model="searchForm.availability"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            @change="search"
                        >
                            <option value="all">Semua</option>
                            <option value="available">Tersedia</option>
                            <option value="unavailable">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facilities List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <!-- Empty State -->
            <div
                v-if="facilities.data.length === 0"
                class="px-6 py-12 text-center"
            >
                <BuildingOffice2Icon class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-4 text-lg font-medium text-gray-900">
                    {{
                        filters.search
                            ? "Fasilitas tidak ditemukan"
                            : "Belum Ada Fasilitas"
                    }}
                </h3>
                <p class="mt-2 text-sm text-gray-600">
                    {{
                        filters.search
                            ? "Coba gunakan kata kunci lain"
                            : "Mulai dengan menambahkan fasilitas baru"
                    }}
                </p>
            </div>

            <!-- Facilities Grid -->
            <div v-else class="p-6">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        v-for="facility in facilities.data"
                        :key="facility.id"
                        class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300"
                    >
                        <!-- Image -->
                        <div class="relative h-48 bg-gray-200">
                            <img
                                v-if="facility.image_url"
                                :src="facility.image_url"
                                :alt="facility.name"
                                class="w-full h-full object-cover"
                            />
                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center bg-gray-100"
                            >
                                <PhotoIcon class="w-16 h-16 text-gray-400" />
                            </div>

                            <!-- Badges -->
                            <div
                                class="absolute top-2 left-2 flex flex-col gap-2"
                            >
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        facility.is_active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800',
                                    ]"
                                >
                                    {{
                                        facility.is_active
                                            ? "Aktif"
                                            : "Tidak Aktif"
                                    }}
                                </span>
                                <span
                                    :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        facility.is_available
                                            ? 'bg-blue-100 text-blue-800'
                                            : 'bg-yellow-100 text-yellow-800',
                                    ]"
                                >
                                    {{
                                        facility.is_available
                                            ? "Tersedia"
                                            : "Tidak Tersedia"
                                    }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1"
                            >
                                {{ facility.name }}
                            </h3>

                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                {{
                                    facility.short_description ||
                                    facility.description
                                }}
                            </p>

                            <!-- Info Grid -->
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                <div
                                    v-if="facility.location"
                                    class="flex items-center text-xs text-gray-500"
                                >
                                    <MapPinIcon class="w-4 h-4 mr-1" />
                                    <span class="truncate">{{
                                        facility.location
                                    }}</span>
                                </div>
                                <div
                                    v-if="facility.capacity"
                                    class="flex items-center text-xs text-gray-500"
                                >
                                    <UsersIcon class="w-4 h-4 mr-1" />
                                    <span class="truncate">{{
                                        facility.capacity
                                    }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <Link
                                    :href="
                                        route(
                                            'admin.facilities.show',
                                            facility.id
                                        )
                                    "
                                    class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    <EyeIcon class="w-4 h-4 mr-1" />
                                    Detail
                                </Link>
                                <Link
                                    :href="
                                        route(
                                            'admin.facilities.edit',
                                            facility.id
                                        )
                                    "
                                    class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    <PencilIcon class="w-4 h-4 mr-1" />
                                    Edit
                                </Link>
                                <button
                                    @click="confirmDeleteFacility(facility)"
                                    class="inline-flex justify-center items-center px-3 py-2 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                >
                                    <TrashIcon class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div
                    v-if="facilities.last_page > 1"
                    class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6"
                >
                    <div class="flex-1 flex justify-between sm:hidden">
                        <Link
                            v-if="facilities.prev_page_url"
                            :href="facilities.prev_page_url"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Previous
                        </Link>
                        <Link
                            v-if="facilities.next_page_url"
                            :href="facilities.next_page_url"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                        >
                            Next
                        </Link>
                    </div>
                    <div
                        class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{
                                    facilities.from
                                }}</span>
                                sampai
                                <span class="font-medium">{{
                                    facilities.to
                                }}</span>
                                dari
                                <span class="font-medium">{{
                                    facilities.total
                                }}</span>
                                fasilitas
                            </p>
                        </div>
                        <div>
                            <nav
                                class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            >
                                <Link
                                    v-for="link in facilities.links"
                                    :key="link.label"
                                    :href="link.url"
                                    :class="[
                                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                        link.active
                                            ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                        link.url
                                            ? ''
                                            : 'cursor-not-allowed opacity-50',
                                    ]"
                                    v-html="link.label"
                                />
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive, watch } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useSwal } from "@/Composables/useSwal";
import {
    PlusIcon,
    PencilIcon,
    TrashIcon,
    EyeIcon,
    MagnifyingGlassIcon,
    PhotoIcon,
    BuildingOffice2Icon,
    MapPinIcon,
    UsersIcon,
} from "@heroicons/vue/24/outline";

// Props
const props = defineProps({
    facilities: Object,
    filters: Object,
});

// Composables
const { props: pageProps } = usePage();
const { success, error, warning, confirmDelete } = useSwal();

// Search Form
const searchForm = reactive({
    search: props.filters?.search || "",
    status: props.filters?.status || "all",
    availability: props.filters?.availability || "all",
});

// Debounce timer
let debounceTimer = null;

// Methods
const debounceSearch = () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        search();
    }, 500);
};

const search = () => {
    router.get(
        route("admin.facilities.index"),
        {
            search: searchForm.search,
            status: searchForm.status,
            availability: searchForm.availability,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const confirmDeleteFacility = async (facility) => {
    const result = await confirmDelete(
        "Hapus Fasilitas?",
        `Fasilitas "${facility.name}" akan dihapus secara permanen!`
    );

    if (result.isConfirmed) {
        deleteFacility(facility);
    }
};

const deleteFacility = (facility) => {
    router.delete(route("admin.facilities.destroy", facility.id));
};

const handleFlashMessages = () => {
    const flashProps = pageProps.flash || {};

    if (flashProps.message) {
        success("Berhasil!", flashProps.message);
    }

    if (flashProps.error) {
        error("Error!", flashProps.error);
    }

    if (flashProps.warning) {
        warning("Peringatan!", flashProps.warning);
    }
};

// Watchers
watch(
    () => pageProps.flash,
    () => {
        handleFlashMessages();
    },
    { deep: true }
);

// Lifecycle
handleFlashMessages();
</script>

<style scoped>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
