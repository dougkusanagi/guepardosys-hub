<template>
	<div>
		<FormLabel>
			<slot name="label" />
		</FormLabel>

		<FormInputText>
			<slot name="input" />
		</FormInputText>
	</div>
</template>

<script setup>
import FormLabel from "./FormLabel.vue";
import FormInputText from "./FormInputText.vue";
</script>
