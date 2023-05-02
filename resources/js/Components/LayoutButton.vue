<template>
    <component
        class="btn text-xs gap-2 border-2 rounded-br-none"
        :class="{
            'btn-primary': variant === 'primary',
            'btn-secondary': variant === 'secondary',
            'btn-accent': variant === 'accent',
            'btn-success': variant === 'success',
            'btn-info': variant === 'info',
            'btn-warning': variant === 'warning',
            'btn-error': variant === 'error',
            'btn-default': variant === 'default',
            'btn-outline': outline,
            'btn-link': link,
        }"
        :is="tag"
        :type="type"
        :href="href"
    >
        <div class="ml-[-0.2rem]" v-if="slots.before">
            <slot name="before" />
        </div>

        <span
            :class="{
                'dark:text-white': variant === 'primary',
                'text-white': variant === 'primary' && !outline,
            }"
        >
            <slot />
        </span>

        <slot name="after" />
    </component>
</template>

<script setup>
import { computed, useSlots } from "vue";

const props = defineProps({
    href: {
        type: String,
        default: "",
    },
    variant: {
        type: String,
        default: "primary",
    },
    outline: {
        type: Boolean,
        default: false,
    },
    link: {
        type: Boolean,
        default: false,
    },
    submit: {
        type: Boolean,
        default: false,
    },
});

const slots = useSlots();

const tag = computed(() => (props.submit ? "button" : "Link"));
const type = computed(() => (props.submit ? "submit" : ""));
</script>
