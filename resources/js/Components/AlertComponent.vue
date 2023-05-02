<template>
	<div
		v-show="isVisible"
		class="alert shadow-lg z-50 mt-3"
		:class="{
			'alert-primary': variant === 'primary',
			'alert-secondary': variant === 'secondary',
			'alert-accent': variant === 'accent',
			'alert-success': variant === 'success',
			'alert-info': variant === 'info',
			'alert-warning': variant === 'warning',
			'alert-error': variant === 'error',
			'alert-default': variant === 'default',
		}"
	>
		<div class="gap-4">
			<component :is="icon" />

			<div>
				<h3 class="font-bold" v-text="title"></h3>

				<div class="text-xs" v-if="message" v-text="message"></div>
			</div>
		</div>

		<button @click="isVisible = false">
			<Close />
		</button>
	</div>
</template>

<script setup>
import { computed } from "vue";
import ExclamationTriangle from "@/Icons/ExclamationTriangle.vue";
import CheckCircle from "@/Icons/CheckCircle.vue";
import Close from "@/Icons/Close.vue";

const props = defineProps({
	isVisible: {
		type: Boolean,
		default: true,
	},
	variant: {
		type: String,
		default: "default",
	},
	title: {
		type: String,
		default: "",
	},
	message: {
		type: String,
		default: "",
	},
});

// for this
const icon_list = { success: CheckCircle, error: ExclamationTriangle };
const icon = computed(() => icon_list[props.variant]);
</script>
