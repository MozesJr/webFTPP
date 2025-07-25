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
        <textarea
            :id="id"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            :required="required"
            :disabled="disabled"
            :rows="rows"
            :class="textareaClasses"
            class="block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
        </textarea>
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
        <p v-else-if="help" class="mt-1 text-sm text-gray-500">{{ help }}</p>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: String,
    label: String,
    placeholder: String,
    required: Boolean,
    disabled: Boolean,
    error: String,
    help: String,
    rows: { type: Number, default: 4 },
    id: String,
});

defineEmits(["update:modelValue"]);

const textareaClasses = computed(() => [
    "border-gray-300",
    {
        "border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500":
            props.error,
        "bg-gray-50 cursor-not-allowed": props.disabled,
    },
]);
</script>
