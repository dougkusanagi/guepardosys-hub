<template>
    <!-- Need to include paginate()->withQueryString() in laravel response -->
    <div class="btn-group">
        <Component
            class="btn border-slate"
            :class="
                link.url && !link.active
                    ? 'btn-primary'
                    : 'btn-disabled text-slate-500 dark:border-slate-800'
            "
            v-for="link in pages.links"
            :is="link.url ? 'Link' : 'span'"
            :href="link.url ? link.url : ''"
            v-html="link.label"
        />
    </div>
</template>

<script setup>
defineProps({
    pages: Object,
});
</script>
