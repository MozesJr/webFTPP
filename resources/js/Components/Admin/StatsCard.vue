<template>
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div :class="`bg-${color}-500`" class="p-3 rounded-md">
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
                        <dd class="text-lg font-medium text-gray-900">
                            {{ formattedValue }}
                        </dd>
                    </dl>
                </div>
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
} from "@heroicons/vue/24/outline";

const props = defineProps({
    title: String,
    value: [Number, String],
    icon: String,
    color: { type: String, default: "blue" },
});

const iconComponent = computed(() => {
    const icons = {
        "academic-cap": AcademicCapIcon,
        users: UsersIcon,
        newspaper: NewspaperIcon,
        envelope: EnvelopeIcon,
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
