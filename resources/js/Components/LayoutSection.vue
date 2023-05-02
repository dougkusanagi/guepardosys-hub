<template>
	<div class="bg-white dark:bg-[#11183C] rounded-lg p-4 mb-8">
		<h2 v-if="showHeader()" class="text-lg font-bold mb-6">
			<slot name="header"></slot>
		</h2>

		<slot />
	</div>
</template>

<script setup>
import { useSlots } from 'vue';

const slots = useSlots();
const showHeader = () => {  return !!slots.header};
</script>
