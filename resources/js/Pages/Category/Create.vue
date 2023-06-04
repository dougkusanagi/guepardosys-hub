<template>
    <DashboardLayout>
        <div class="pt-12 px-6">
            <LayoutHeader :breadcrumbs-links="breadcrumbsLinks">
                <template #header-title>Cadastro de Categoria</template>

                <template #append>
                    <div class="flex justify-between md:flex-1 md:justify-end">
                        <LayoutButton :href="route('category.index')" outline>
                            <template #before>
                                <ChevronLeft />
                            </template>

                            Voltar
                        </LayoutButton>

                        <ButtonSave
                            form="form_create"
                            class="w-52 flex lg:hidden ml-4"
                            :disabled="form.processing"
                        />
                    </div>
                </template>
            </LayoutHeader>

            <form
                id="form_create"
                @submit.prevent="submit"
                class="flex lg:space-x-6"
            >
                <SidenavScrollto>
                    <ButtonSave :disabled="form.processing" />

                    <SidenavScrolltoLink
                        v-for="link in sidenavScrolltoLinks"
                        :link="link"
                        :key="link.route"
                    />
                </SidenavScrollto>

                <div class="w-full">
                    <LayoutSection id="section-basic-info">
                        <template #header>Informações</template>

                        <div class="md:flex md:space-x-4">
                            <div class="w-full md:w-1/2 mb-4">
                                <FormLabel for="name">Nome</FormLabel>

                                <FormInputText
                                    placeholder="ex: Cartão de visitas"
                                    id="name"
                                    type="text"
                                    v-model="form.name"
                                />
                                <p class="text-rose-700">{{ errors.name }}</p>
                            </div>

                            <div class="w-full md:w-1/2 mb-4">
                                <FormLabel for="slug">Slug</FormLabel>

                                <FormInputText
                                    placeholder="ex: cartao-de-visitas"
                                    id="slug"
                                    type="text"
                                    v-model="form.slug"
                                />
                                <p class="text-rose-700">{{ errors.slug }}</p>
                            </div>
                        </div>
                    </LayoutSection>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>

<script setup>
import ButtonSave from "@/Components/Form/ButtonSave.vue";
import FormInputText from "@/Components/Form/FormInputText.vue";
import FormLabel from "@/Components/Form/FormLabel.vue";
import LayoutButton from "@/Components/LayoutButton.vue";
import LayoutHeader from "@/Components/LayoutHeader.vue";
import LayoutSection from "@/Components/LayoutSection.vue";
import SidenavScrollto from "@/Components/SidenavScrollto.vue";
import SidenavScrolltoLink from "@/Components/SidenavScrolltoLink.vue";
import { slugfy } from "@/Helpers/string";
import ChevronLeft from "@/Icons/ChevronLeft.vue";
import InformationCircleIcon from "@/Icons/InformationCircle.vue";
import DashboardLayout from "@/Layout/DashboardLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, watch } from "vue";

const breadcrumbsLinks = [
    {
        label: "Início",
        link: route("dashboard"),
        isHome: true,
    },
    {
        label: "Categorias",
        link: route("category.index", {
            order_by: "name",
            direction: "asc",
        }),
    },
    {
        label: "Cadastro",
    },
];

const sidenavScrolltoLinks = [
    {
        name: "Informações",
        route: "#section-basic-info",
        icon: InformationCircleIcon,
    },
];

const props = defineProps({
    category: Object,
    errors: Object,
});

const form = useForm({
    name: "",
    slug: "",
});

watch(form, (new_data) => (form.slug = slugfy(new_data.name)));

const submit = function () {
    form.post(route("category.store"));
};
</script>
