<template>
    <select
        class="select w-full px-3 py-2 transition duration-100 ease-in-out rounded-lg shadow-sm focus:ring-2 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed h-12 dark:bg-[#0D0C22] border"
        :class="
            (classes,
            {
                'bg-white border-gray-300 text-slate-700 dark:border-slate-800 dark:text-slate-100 dark:placeholder-gray-500':
                    !variant.length,
                'text-emerald-700 placeholder-emerald-400 border-emerald-300 focus:ring-emerald-600 focus:border-emerald-600':
                    variant === 'success',
                'text-rose-700 placeholder-rose-400 border-rose-300 focus:ring-rose-600 focus:border-rose-600':
                    variant === 'danger',
            })
        "
        @input="(e) => $emit('update:modelValue', e.target.value)"
        @change="(e) => $emit('change:modelValue', e.target.value)"
        :value="modelValue"
        :id="id"
        :name="name"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        :required="required"
    >
        <slot />
    </select>
</template>

<script setup>
const props = defineProps({
    autofocus: Boolean,
    classes: { type: String, default: "" },
    disabled: Boolean,
    id: { type: String, default: null },
    label: { type: String, default: "" },
    modelValue: [String, Number],
    name: { type: String, default: "" },
    placeholder: { type: String, default: "" },
    readonly: Boolean,
    required: Boolean,
    type: String,
    variant: {
        type: String,
        default: "",
        validator(value) {
            // The value must match one of these strings
            return ["", "success", "danger"].includes(value);
        },
    },
});
</script>
