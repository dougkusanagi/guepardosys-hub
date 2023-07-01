<template>
    <Head title="Categorias" />

    <DashboardLayout>
        <div class="pt-12 px-6">
            <LayoutHeader :breadcrumbs-links="breadcrumbsLinks">
                <template #header-title> Lista de Categorias </template>

                <template #append>
                    <div class="flex justify-between md:flex-1 md:justify-end">
                        <LayoutButton
                            class="mr-2"
                            :href="route('category.create')"
                        >
                            <template #before>
                                <PlusIcon />
                            </template>

                            Cadastrar Categoria
                        </LayoutButton>
                    </div>
                </template>
            </LayoutHeader>

            <div class="flex gap-4 justify-between mb-6">
                <PaginationPerPage :queryParams="queryParams">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </PaginationPerPage>

                <div>
                    <PaginationPages :pages="props.categories" />
                </div>
            </div>

            <LayoutSection class="bg-white rounded-lg divide-y">
                <div class="md:flex md:space-x-4 mb-4">
                    <div class="w-1/3 relative flex-1">
                        <FormInputText
                            placeholder="Digite o nome da categoria..."
                            type="search"
                            v-model="queryParams.name"
                        />
                    </div>

                    <span
                        class="flex items-center justify-center flex-1 ml text-[#969bba] text-center"
                    >
                        {{ props.categories.total }} encontrados
                    </span>
                </div>

                <div
                    class="flex items-center bg-slate-50 text-slate-600 border-y p-3 -ml-4 -mr-4 dark:bg-[#11183C] dark:brightness-75 dark:border-none dark:text-slate-200 px-6"
                >
                    <!-- <input class="border-slate-300" type="checkbox" name="[]" /> -->

                    <div class="w-16 h-0 opacity-0 mx-2" alt="Categoria"></div>

                    <span
                        class="flex font-bold cursor-pointer"
                        @click="sortBy('name')"
                    >
                        <span
                            class="mr-1"
                            :class="
                                route().params.order_by !== 'name'
                                    ? 'hidden'
                                    : ''
                            "
                        >
                            <ArrowUp
                                :class="
                                    route().params.direction === 'desc'
                                        ? 'rotate-180'
                                        : ''
                                "
                            />
                        </span>
                        Nome
                    </span>

                    <div class="ml-4">
                        <button class="btn btn-square btn-xs opacity-0">
                            <Close />
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white border-slate-200 overflow-hidden shadow-sm dark:bg-[#11183C] -ml-4 -mr-4 dark:border-slate-700"
                    v-for="category in props.categories.data"
                    :key="category.id"
                >
                    <div class="flex items-center space-x-4 py-4 px-6">
                        <!-- <input class="border-slate-300" type="checkbox" name="[]" /> -->

                        <div class="flex flex-col flex-1 justify-center">
                            <h3 class="text-xs text-slate-400">
                                {{ category.name }}
                            </h3>

                            <h2 class="text-lg font-bold">
                                <Link
                                    :href="route('category.edit', category.id)"
                                    class="underline"
                                    >{{ category.name }}</Link
                                >
                            </h2>
                        </div>

                        <div class="flex">
                            <div class="flex items-center ml-4">
                                <button
                                    @click="removeCategory(category.id)"
                                    class="btn btn-error btn-sm btn-outline btn-square"
                                >
                                    <Close />
                                </button>

                                <!-- <Link
                                    :href="
                                        route('category.destroy', category.id)
                                    "
                                    class="btn btn-error btn-sm btn-outline btn-square"
                                    method="delete"
                                    as="button"
                                >
                                    <Close />
                                </Link> -->
                            </div>
                        </div>
                    </div>
                </div>
            </LayoutSection>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { Head, router } from "@inertiajs/vue3";
import { reactive, watch } from "vue";
import DashboardLayout from "@/Layout/DashboardLayout.vue";
import LayoutSection from "@/Components/LayoutSection.vue";
import LayoutHeader from "@/Components/LayoutHeader.vue";
import LayoutButton from "@/Components/LayoutButton.vue";
import FormInputText from "@/Components/Form/FormInputText.vue";
import PaginationPerPage from "@/Components/PaginationPerPage.vue";
import PlusIcon from "@/Icons/Plus.vue";
import ArrowUp from "@/Icons/ArrowUp.vue";
import Close from "@/Icons/Close.vue";
import PaginationPages from "@/Components/PaginationPages.vue";

const props = defineProps({
    categories: Object,
    per_page: String,
});

const breadcrumbsLinks = [
    {
        label: "Início",
        link: route("dashboard"),
        isHome: true,
    },
    {
        label: "Categorias",
    },
    {
        label: "Listar",
    },
];

const queryParams = reactive({
    name: "",
    order_by: "name",
    direction: "asc",
    per_page: props.per_page,
});

watch(
    queryParams,
    () => {
        router.get(route("category.index"), queryParams, {
            replace: true,
            preserveState: true,
        });
    },
    { deep: true }
);

function removeCategory(category_id) {
    router.visit(route("category.destroy", category_id), {
        method: "delete",
        onBefore: () => confirm("Tem certeza que deseja deletar a categoria?"),
    });
}
</script>
