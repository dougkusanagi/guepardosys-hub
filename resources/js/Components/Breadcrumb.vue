<template>
	<nav class="flex" aria-label="Breadcrumb">
		<ol class="inline-flex items-center">
			<BreadcrumbItem
        v-for="item in items"
        :link="item.link"
        :isHome="item.isHome"
				:key="item.link"
      >
        {{ item.label }}
      </BreadcrumbItem>
		</ol>
	</nav>
</template>

<script setup>
import BreadcrumbItem from "./BreadcrumbItem.vue";

defineProps({
  items: Array
})
</script>
