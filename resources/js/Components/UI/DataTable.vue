<template>
    <div class="bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
                <div class="flex space-x-3">
                    <!-- Search -->
                    <div class="relative">
                        <MagnifyingGlassIcon
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"
                        />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <!-- Actions -->
                    <slot name="actions" />
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            v-for="column in columns"
                            :key="column.key"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            {{ column.label }}
                        </th>
                        <th
                            v-if="actions"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                        v-for="item in filteredData"
                        :key="item.id"
                        class="hover:bg-gray-50"
                    >
                        <td
                            v-for="column in columns"
                            :key="column.key"
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                        >
                            <slot
                                :name="`cell-${column.key}`"
                                :item="item"
                                :value="getNestedValue(item, column.key)"
                            >
                                {{ getNestedValue(item, column.key) }}
                            </slot>
                        </td>
                        <td
                            v-if="actions"
                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                            <slot name="actions" :item="item" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Empty State -->
        <div v-if="filteredData.length === 0" class="text-center py-12">
            <div class="text-gray-500">
                <slot name="empty"> No data available </slot>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="pagination" class="px-6 py-3 border-t border-gray-200">
            <Pagination :links="pagination.links" />
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline";
import Pagination from "./Pagination.vue";

const props = defineProps({
    title: String,
    data: Array,
    columns: Array,
    actions: Boolean,
    pagination: Object,
});

const searchQuery = ref("");

const filteredData = computed(() => {
    if (!searchQuery.value) return props.data;

    return props.data.filter((item) =>
        props.columns.some((column) => {
            const value = getNestedValue(item, column.key);
            return String(value)
                .toLowerCase()
                .includes(searchQuery.value.toLowerCase());
        })
    );
});

function getNestedValue(obj, path) {
    return path.split(".").reduce((current, key) => current?.[key], obj);
}
</script>
