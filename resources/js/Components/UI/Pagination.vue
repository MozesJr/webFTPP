<template>
    <nav class="flex items-center justify-between">
        <div class="flex flex-1 justify-between sm:hidden">
            <!-- Mobile pagination -->
            <Link
                v-if="links.prev"
                :href="links.prev"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
            >
                Previous
            </Link>
            <Link
                v-if="links.next"
                :href="links.next"
                class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
            >
                Next
            </Link>
        </div>

        <div
            class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
        >
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ from }}</span> to
                    <span class="font-medium">{{ to }}</span> of
                    <span class="font-medium">{{ total }}</span> results
                </p>
            </div>
            <div>
                <nav
                    class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                >
                    <!-- Previous -->
                    <Link
                        v-if="links.prev"
                        :href="links.prev"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                        <ChevronLeftIcon class="h-5 w-5" />
                    </Link>

                    <!-- Page numbers -->
                    <template v-for="(link, index) in pageLinks" :key="index">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                            :class="
                                link.active
                                    ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                            "
                        >
                            {{ link.label }}
                        </Link>
                        <span
                            v-else
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
                        >
                            {{ link.label }}
                        </span>
                    </template>

                    <!-- Next -->
                    <Link
                        v-if="links.next"
                        :href="links.next"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                        <ChevronRightIcon class="h-5 w-5" />
                    </Link>
                </nav>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    links: Object,
});

const pageLinks = computed(() => {
    return props.links.data || [];
});

const from = computed(() => props.links.from || 0);
const to = computed(() => props.links.to || 0);
const total = computed(() => props.links.total || 0);
</script>
