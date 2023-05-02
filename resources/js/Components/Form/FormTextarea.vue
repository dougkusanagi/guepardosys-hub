<template>
	<textarea
		class="textarea textarea-bordered dark:bg-[#0D0C22] border"
		:class="
			(classes,
			{
				'text-slate-700 placeholder-gray-400 border-gray-300 focus:ring-indigo-600 focus:border-indigo-600 dark:border-slate-800 dark:text-slate-100 dark:placeholder-gray-600':
					!variant.length,
				'text-emerald-700 placeholder-emerald-400 border-emerald-300 focus:ring-emerald-600 focus:border-emerald-600':
					variant === 'success',
				'text-rose-700 placeholder-rose-400 border-rose-300 focus:ring-rose-600 focus:border-rose-600':
					variant === 'danger',
				'resize-none': !resize
			})
		"
		@input="(e) => $emit('update:modelValue', e.target.value)"
		@change="(e) => $emit('change:modelValue', e.target.value)"
		:value="modelValue"
		:id="id"
		:name="name"
		:max="max"
		:min="min"
		:maxlength="maxlength"
		:minlength="minlength"
		:placeholder="placeholder"
		:disabled="disabled"
		:readonly="readonly"
		:required="required"
		:autocomplete="autocomplete"
		:rows="rows"
		:cols="cols"
	/>
</template>

<script setup>
const props = defineProps({
	autocomplete: { type: String, default: "on" }, // on|off
	autofocus: Boolean,
	rows: {
		type: [String, Number],
		default: 8
	},
	cols: [String, Number],
	classes: { type: String, default: "" },
	disabled: Boolean,
	id: { type: String, default: "" },
	label: { type: String, default: "" },
	max: [String, Number],
	maxlength: [String, Number],
	min: [String, Number],
	minlength: [String, Number],
	modelValue: String,
	name: { type: String, default: "" },
	placeholder: { type: String, default: "" },
	readonly: Boolean,
	resize: { type: Boolean, default: false},
	required: Boolean,
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
