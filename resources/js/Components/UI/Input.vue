<template>
    <div>
        <label
            v-if="label"
            :for="id"
            class="block text-sm font-medium text-gray-700 mb-1"
        >
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input
                :id="id"
                :type="type"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                :placeholder="placeholder"
                :required="required"
                :disabled="disabled"
                :class="inputClasses"
                class="block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            />
            <div
                v-if="error"
                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
            >
                <ExclamationCircleIcon class="h-5 w-5 text-red-500" />
            </div>
        </div>
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
        <p v-else-if="help" class="mt-1 text-sm text-gray-500">{{ help }}</p>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: [String, Number],
    label: String,
    placeholder: String,
    required: Boolean,
    disabled: Boolean,
    error: String,
    help: String,
    options: Array,
    id: String,
});

defineEmits(["update:modelValue"]);

const selectClasses = computed(() => [
    "border-gray-300",
    {
        "border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500":
            props.error,
        "bg-gray-50 cursor-not-allowed": props.disabled,
    },
]);
</script>
