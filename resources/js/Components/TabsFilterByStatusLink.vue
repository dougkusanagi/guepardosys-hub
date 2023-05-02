<template>
	<a
		href="#"
		class="flex items-center text-xs pb-2 mr-6"
		:class="
			isActive
				? 'border-b-4 border-indigo-600'
				: 'border-b-4 border-transparent'
		"
	>
		<span
			class="font-bold"
			:class="isActive ? 'text-indigo-600' : 'text-slate-500'"
		>
			{{ label }}
		</span>

		<span
			class="px-2 py-1 ml-2 rounded-full"
			:class="isActive ? 'bg-indigo-600 text-white' : 'bg-slate-300 text-slate-500'"
		>
			{{ count }}
		</span>
	</a>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    required: true,
  },
	isActive: {
		type: Boolean,
		default: false,
	},
	count: {
		type: Number,
		default: 0,
	},
});
</script>
