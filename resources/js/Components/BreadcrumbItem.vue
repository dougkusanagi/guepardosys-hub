<template>
	<li
  class="inline-flex items-center text-sm font-medium text-slate-500"
  >
		<House v-if="isHome" />
		<ChevronRight v-else />

		<Link
			v-if="link"
			:href="link"
			class="text-slate-500 hover:text-gray-700"
		>
			<slot />
		</Link>

		<div v-else>
			<span class="text-gray-400">
				<slot />
			</span>
		</div>
	</li>
</template>

<script setup>
import House from "@/Icons/House.vue";
import ChevronRight from "@/Icons/ChevronRight.vue";
defineProps({
	link: {
		type: String,
		default: "",
	},

	isHome: Boolean,
});
</script>
