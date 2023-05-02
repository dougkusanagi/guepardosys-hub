<template>
	<Combobox v-model="selected">
		<div class="relative">
			<div
				class="relative w-full cursor-default overflow-hidden rounded-lg text-left border border-slate-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
			>
				<ComboboxInput
					class="w-full h-12 border-none py-2 pl-3 pr-10 text-sm leading-5 text-slate-600 focus:ring-0"
					:displayValue="(option) => option.name"
					@change="query = $event.target.value"
				/>
				<ComboboxButton
					class="absolute inset-y-0 right-0 flex items-center pr-2"
				>
					<ChevronUpDown
						class="h-5 w-5 text-gray-400"
						aria-hidden="true"
					/>
				</ComboboxButton>
			</div>
			<TransitionRoot
				leave="transition ease-in duration-100"
				leaveFrom="opacity-100"
				leaveTo="opacity-0"
				@after-leave="query = ''"
			>
				<ComboboxOptions
					class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
				>
					<div
						v-if="filteredOptionList.length === 0 && query !== ''"
						class="relative cursor-default select-none py-2 px-4 text-gray-700"
					>
						Nothing found.
					</div>

					<ComboboxOption>
						<li
							class="relative cursor-default select-none py-2 pl-10 pr-4"
						>
							<span
								class="block truncate"
								:class="{
									'font-bold': selected,
									'font-normal': !selected,
								}"
							>
								<slot />
							</span>
						</li>
					</ComboboxOption>

					<ComboboxOption
						v-for="option in filteredOptionList"
						as="template"
						:key="option.id"
						:value="option"
						v-slot="{ selected, active }"
					>
						<li
							class="relative cursor-default select-none py-2 pl-10 pr-4"
							:class="{
								'bg-indigo-600 text-white': active,
								'bg-white text-slate-600': !active,
							}"
						>
							<span
								class="block truncate"
								:class="{
									'font-bold': selected,
									'font-normal': !selected,
								}"
							>
								{{ option.name }}
							</span>
							<span
								v-if="selected"
								class="absolute inset-y-0 left-0 flex items-center pl-3"
								:class="{
									'text-white': active,
									'text-indigo-600': !active,
								}"
							>
								<Check class="h-5 w-5" aria-hidden="true" />
							</span>
						</li>
					</ComboboxOption>
				</ComboboxOptions>
			</TransitionRoot>
		</div>
	</Combobox>
</template>

<script setup>
import { ref, computed } from "vue";
import {
	Combobox,
	ComboboxInput,
	ComboboxButton,
	ComboboxOptions,
	ComboboxOption,
	TransitionRoot,
} from "@headlessui/vue";
// import { CheckIcon, ChevronUpDownIcon } from "@heroicons/vue/20/solid";
import MagnifyingGlass from "@/Icons/MagnifyingGlass.vue";
import ChevronUpDown from "@/Icons/ChevronUpDown.vue";
import Check from "@/Icons/Check.vue";

const props = defineProps({ optionList: Object });

let query = ref("");
let selected = ref(props.optionList[0]);

let filteredOptionList = computed(() =>
	query.value === ""
		? props.optionList
		: props.optionList.filter((option) =>
				option.name
					.toLowerCase()
					.replace(/\s+/g, "")
					.includes(query.value.toLowerCase().replace(/\s+/g, ""))
		  )
);
</script>
