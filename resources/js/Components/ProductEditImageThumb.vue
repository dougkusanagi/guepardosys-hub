<template>
    <div>
        <div
            class="flex flex-col w-20 h-20 absolute divide-y divide-slate-400 rounded-lg"
        >
            <Link
                class="flex items-center justify-center w-full text-center bg-rose-700/70 rounded-t-lg"
                :href="
                    route('image.delete', {
                        media_item: image.id,
                    })
                "
                method="delete"
                as="button"
            >
                <CloseCircle />
            </Link>
            <a
                class="flex items-center justify-center w-full h-full rounded-b-lg text-center bg-blue-900/0 hover:bg-blue-900/90 opacity-0 hover:opacity-100 transition-all"
                href="#"
                @click.prevent="in_dev"
            >
                <Eye />
            </a>
        </div>

        <img class="w-20 h-20 object-cover rounded-lg" :src="image.url" />
    </div>
</template>

<script setup>
import CloseCircle from "@/Icons/CloseCircle.vue";
import Eye from "@/Icons/Eye.vue";

defineProps({
    image: Object,
    product: Object,
});

const in_dev = () => alert("Em desenvolvimento");
</script>
