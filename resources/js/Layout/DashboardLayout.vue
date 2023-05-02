<template>
    <Head title="Dashboard" />

    <div class="flex">
        <Sidenav />

        <main class="w-full ml-24 md:ml-44">
            <slot />
        </main>
    </div>
</template>

<script setup>
import Sidenav from "@/Components/Navbar.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { computed, onMounted, watch } from "vue";
import { useToast } from "vue-toastification";

const flash = computed(() => usePage().props.flash);
const toast = useToast();

function triggerFlash() {
    const types = Object.keys(flash.value);
    types.forEach((type) => {
        if (flash.value[type] !== null) {
            toast(flash.value[type], { type });
            flash.value[type] = null;
        }
    });
}

onMounted(triggerFlash);
watch(flash, triggerFlash);
</script>
