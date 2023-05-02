<template>
	<div
		class="w-64 h-max hidden flex-col lg:flex rounded-lg space-y-1 sticky top-8"
	>
	<slot />
	</div>
</template>

<script setup>
const props = defineProps({ links: Array });
</script>
