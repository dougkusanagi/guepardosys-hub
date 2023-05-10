<template>
    <div class="flex items-center">
        <div class="min-w-max px-3">Exibir</div>

        <FormSelect v-model="queryParams.per_page" class="w-24">
            <slot />
        </FormSelect>

        <div class="min-w-max px-3">por página</div>
    </div>
</template>

<script setup>
import FormSelect from "./Form/FormSelect.vue";
defineProps({
    queryParams: Object,
});
</script>
