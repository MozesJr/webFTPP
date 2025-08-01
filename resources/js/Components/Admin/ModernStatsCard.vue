<template>
    <div
        class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200"
    >
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div
                        :class="`bg-${color}-500 bg-gradient-to-br from-${color}-500 to-${color}-600`"
                        class="p-3 rounded-lg shadow-sm"
                    >
                        <component
                            :is="iconComponent"
                            class="w-6 h-6 text-white"
                        />
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            {{ title }}
                        </dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-bold text-gray-900">
                                {{ formattedValue }}
                            </div>
                            <div
                                v-if="trend"
                                class="ml-2 flex items-baseline text-sm font-semibold"
                                :class="
                                    trend.isUp
                                        ? 'text-green-600'
                                        : 'text-red-600'
                                "
                            >
                                <ArrowUpIcon
                                    v-if="trend.isUp"
                                    class="w-3 h-3 mr-0.5"
                                />
                                <ArrowDownIcon v-else class="w-3 h-3 mr-0.5" />
                                {{ trend.value }}%
                            </div>
                        </dd>
                        <dd
                            v-if="description"
                            class="text-xs text-gray-400 mt-1"
                        >
                            {{ description }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Progress bar (optional) -->
        <div v-if="progress" class="bg-gray-50 px-6 py-3">
            <div
                class="flex items-center justify-between text-xs text-gray-600"
            >
                <span>Progress</span>
                <span>{{ progress }}%</span>
            </div>
            <div class="mt-1 bg-gray-200 rounded-full h-1">
                <div
                    :class="`bg-${color}-500`"
                    class="h-1 rounded-full transition-all duration-300"
                    :style="`width: ${progress}%`"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import {
    AcademicCapIcon,
    UsersIcon,
    NewspaperIcon,
    EnvelopeIcon,
    ChartBarIcon,
    CalendarIcon,
    ArrowUpIcon,
    ArrowDownIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: String,
    value: [Number, String],
    icon: String,
    color: { type: String, default: "blue" },
    trend: Object,
    description: String,
    progress: Number,
});

const iconComponent = computed(() => {
    const icons = {
        "academic-cap": AcademicCapIcon,
        users: UsersIcon,
        newspaper: NewspaperIcon,
        envelope: EnvelopeIcon,
        calendar: CalendarIcon,
        "chart-bar": ChartBarIcon,
    };
    return icons[props.icon] || ChartBarIcon;
});

const formattedValue = computed(() => {
    if (typeof props.value === "number") {
        return new Intl.NumberFormat("id-ID").format(props.value);
    }
    return props.value;
});
</script>
