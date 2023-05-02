<template>
	<div class="flex mb-6 border-b border-slate-300">
		<TabsFilterByStatusLink
			v-for="link in links"
			:isActive="link.isActive"
			:count="link.count"
			:label="link.label"
		/>
	</div>
</template>

<script setup>
import TabsFilterByStatusLink from "@/Components/TabsFilterByStatusLink.vue";

defineProps({ links: Array })
</script>
