<template>
	<label
		class="flex items-center mb-2 text-sm"
		:for="id"
		:class="
			(classes,
			{
				'text-slate-500 dark:text-[#7480BC]': !variant.length,
				'text-emerald-700': variant === 'success',
				'text-rose-700': variant === 'danger',
			})
		"
	>
		<slot />
	</label>
</template>

<script setup>
defineProps({
	text: String,
	id: String,
	classes: { type: String, default: "" },
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
