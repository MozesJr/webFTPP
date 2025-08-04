<template>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div
            class="px-6 py-4 border-b border-gray-200 flex justify-between items-center"
        >
            <h2 class="text-lg font-medium text-gray-900">
                {{ title }}
            </h2>
            <div class="relative">
                <input
                    type="text"
                    placeholder="Cari..."
                    v-model="search"
                    @input="debouncedSearch"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-10"
                />
                <div
                    class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                >
                    <svg
                        class="h-5 w-5 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </div>
        </div>

        <div v-if="loading" class="p-6 text-center text-gray-500">
            Memuat data...
        </div>

        <div v-else class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            v-for="header in headers"
                            :key="header.key"
                            :class="[
                                'px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider',
                                header.align === 'right'
                                    ? 'text-right'
                                    : 'text-left',
                            ]"
                        >
                            {{ header.label }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <slot name="body" :items="items">
                        <tr v-if="items.length === 0">
                            <td
                                :colspan="headers.length"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                Tidak ada data yang ditemukan.
                            </td>
                        </tr>
                    </slot>
                </tbody>
            </table>
        </div>

        <div
            class="px-6 py-4 border-t border-gray-200"
            v-if="pagination?.links.length > 3"
        >
            <Pagination :links="pagination.links" />
        </div>
    </div>
</template>

<script setup>
import { ref, watch, defineProps } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash"; // Pastikan Anda menginstal lodash (npm install lodash)
import Pagination from "./Pagination.vue"; // Import komponen Pagination

const props = defineProps({
    title: {
        type: String,
        default: "Daftar Data",
    },
    headers: {
        type: Array,
        required: true, // [{ key: 'name', label: 'Nama', align: 'left' }]
    },
    items: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({ search: "" }),
    },
    pagination: {
        type: Object,
        default: () => ({}),
    },
    routeName: {
        type: String,
        required: true, // e.g., 'admin.program-studi.index'
    },
});

const search = ref(props.filters.search);
const loading = ref(false);

const debouncedSearch = debounce(() => {
    loading.value = true;
    router.get(
        route(props.routeName),
        { search: search.value },
        {
            preserveState: true,
            replace: true,
            onSuccess: () => {
                loading.value = false;
            },
            onError: () => {
                loading.value = false;
            },
        }
    );
}, 300); // Debounce 300ms

// Watch for changes in props.filters.search to update local search ref
watch(
    () => props.filters.search,
    (newSearch) => {
        search.value = newSearch;
    }
);
</script>
