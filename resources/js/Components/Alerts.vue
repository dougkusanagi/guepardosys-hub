<template>
    <div
        v-if="alerts.length"
        class="fixed flex flex-col justify-end bottom-0 right-0 px-6 py-4 overflow-y-auto"
    >
        <AlertComponent
            v-for="alert in alerts"
            :key="alert.id"
            :variant="alert.type"
            :title="alert.title"
            :message="alert.message"
        />
    </div>
</template>

<script setup>
import AlertComponent from "@/Components/AlertComponent.vue";
import useAlerts from "@/Composables/useAlerts";
import { usePage } from "@inertiajs/vue3";
import { computed, watch } from "vue";

const { alerts, addAlert } = useAlerts();

const alert = computed(() => {
    const _alert = usePage().props.flash.alert;
    return _alert;
});

watch(alert, (new_alert) => {
    if (!new_alert) return;

    if (new_alert instanceof Array) {
        new_alert.forEach((alert) => addAlert(alert));
        return;
    }

    addAlert(new_alert);
});
</script>
