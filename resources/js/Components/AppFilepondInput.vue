<template>
    <file-pond
        ref="filepond_ref"
        @init="handleFilePondInit"
        @processfile="handleFilePondProcess"
        @removefile="handleFilePondRemoveFile"
    />
</template>

<script setup>
import { ref } from "vue";
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import { usePage } from "@inertiajs/vue3";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond/dist/filepond.min.css";

const props = defineProps({
    gallery: Object,
});

const handleFilePondInit = () => {
    setOptions({
        credits: false,
        server: {
            url: "/filepond",
            headers: { "X-CSRF-TOKEN": usePage().props.csrf_token },
        },
    });
};

const handleFilePondRemoveFile = (error, file) => {
    gallery = gallery.filter((item) => item.id !== file.id);
};

const handleFilePondProcess = (error, file) => {
    gallery.push({ id: file.id, serverId: file.serverId });
};
</script>
