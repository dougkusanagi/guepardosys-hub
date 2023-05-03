<template>
    <file-pond
        ref="filepond_ref"
        @init="handleFilePondInit"
        @processfile="handleFilePondProcess"
        @removefile="handleFilePondRemoveFile"
    />
</template>

<script setup>
import { onMounted, ref } from "vue";
import vueFilePond, { setOptions } from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import "filepond/dist/filepond.min.css";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    form: Object,
});
const filepond_ref = ref(0);
const FilePond = vueFilePond(
    FilePondPluginFileValidateType
    // FilePondPluginImagePreview
);

defineExpose({ filepond_ref });

const handleFilePondInit = function () {
    setOptions({
        credits: false,
        server: {
            url: "/filepond",
            headers: { "X-CSRF-TOKEN": usePage().props.csrf_token },
        },
        // storeAsFile: false,
        maxParallelUploads: 5, // default is 2
        labelInvalidField: "Somente jpg, png ou webp são permitidos",
        allowReorder: true,
        onreorderfiles(files, origin, target) {
            props.form.filepond_files = [];

            files.forEach((file) =>
                props.form.filepond_files.push({
                    id: file.id,
                    serverId: file.serverId,
                    filename: file.filename,
                })
            );
        },
    });
};

const handleFilePondProcess = function (error, file) {
    props.form.filepond_files.push({
        id: file.id,
        serverId: file.serverId,
        filename: file.filename,
    });
};

const handleFilePondRemoveFile = function (error, file) {
    props.form.filepond_files = props.form.filepond_files.filter(
        (item) => item.id !== file.id
    );
};

props.form.transform((data) => {
    return {
        ...data,
        filepond_files: data.filepond_files.map((item) => item.serverId),
    };
});
</script>
