<template>
	<LayoutButton :href="link.route" outline>
		<template #before>
			<component :is="link.icon"></component>
		</template>

		{{ link.name }}

		<template #after>
			<ChevronRight class="ml-auto" />
		</template>
	</LayoutButton>
</template>

<script setup>
import ChevronRight from "@/Icons/ChevronRight.vue";
import LayoutButton from "./LayoutButton.vue";
const props = defineProps({
	link: Object,
});
</script>
