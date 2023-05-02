<template>
	<div class="md:flex md:items-center mb-6">
		<div class="flex flex-col mb-2">
			<Breadcrumb :items="breadcrumbsLinks" />

			<h1 class="flex items-center font-bold text-3xl mb-4 md:mb-0">
				<slot name="header-title" />
			</h1>
		</div>

		<div class="flex-1">
			<slot name="append" />
		</div>
	</div>
</template>

<script setup>
import Breadcrumb from "./Breadcrumb.vue";

defineProps({ breadcrumbsLinks: Array, headerTitle: String });
</script>
