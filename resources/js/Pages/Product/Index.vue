<template>
    <Head title="Produtos" />

    <DashboardLayout>
        <div class="pt-12 px-6">
            <LayoutHeader :breadcrumbs-links="breadcrumbsLinks">
                <template #header-title> Lista de Produtos </template>

                <template #append>
                    <div class="flex justify-between md:flex-1 md:justify-end">
                        <LayoutButton
                            class="mr-2"
                            :href="route('product.create')"
                        >
                            <template #before>
                                <PlusIcon />
                            </template>

                            Cadastrar Produto
                        </LayoutButton>
                    </div>
                </template>
            </LayoutHeader>

            <div class="flex mb-6 border-b border-slate-300">
                <TabsFilterByStatusLink
                    :isActive="!route().params.status"
                    :count="product_count_array.total"
                    label="Todos"
                    @click="filterByStatus(null)"
                />

                <TabsFilterByStatusLink
                    :isActive="
                        route().params.status ===
                        String(product_status_all.Active)
                    "
                    :count="product_count_array.totalActive"
                    label="Ativos"
                    @click="filterByStatus(product_status_all.Active)"
                />

                <TabsFilterByStatusLink
                    :isActive="
                        route().params.status ===
                        String(product_status_all.Inactive)
                    "
                    :count="product_count_array.totalInactive"
                    label="Inativos"
                    @click="filterByStatus(product_status_all.Inactive)"
                />

                <TabsFilterByStatusLink
                    :isActive="
                        route().params.status ===
                        String(product_status_all.Waiting)
                    "
                    :count="product_count_array.totalWaiting"
                    label="Aguardando"
                    @click="filterByStatus(product_status_all.Waiting)"
                />
            </div>

            <div class="flex gap-4 justify-between mb-6">
                <PaginationPerPage :queryParams="queryParams">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </PaginationPerPage>

                <div>
                    <PaginationPages :pages="products" />
                </div>
            </div>

            <LayoutSection class="bg-white rounded-lg divide-y">
                <div class="md:flex md:space-x-4 mb-4">
                    <div class="w-1/3 relative flex-1">
                        <FormInputText
                            placeholder="Digite o nome do produto..."
                            type="search"
                            v-model="queryParams.name"
                        />
                    </div>

                    <div class="w-1/3">
                        <FormSelect v-model="queryParams.category">
                            <option
                                v-for="option in categories_all_complete"
                                :value="option.id"
                                :key="option.id"
                            >
                                {{ option.name }}
                            </option>
                        </FormSelect>
                    </div>

                    <span
                        class="flex items-center justify-center flex-1 ml text-[#969bba] text-center"
                    >
                        {{ products.total }} encontrados
                    </span>
                </div>

                <div
                    class="flex items-center bg-slate-50 text-slate-600 border-y p-3 -ml-4 -mr-4 dark:bg-[#11183C] dark:brightness-75 dark:border-none dark:text-slate-200 px-6"
                >
                    <!-- <input class="border-slate-300" type="checkbox" name="[]" /> -->

                    <div class="w-16 h-0 opacity-0 mx-2" alt="Produto"></div>

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

                    <span
                        class="flex font-bold cursor-pointer ml-auto mr-4"
                        @click="sortBy('status')"
                    >
                        <span
                            class="mr-1"
                            :class="
                                route().params.order_by !== 'status'
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
                        Status
                    </span>

                    <div class="ml-4">
                        <button class="btn btn-square btn-xs opacity-0">
                            <Close />
                        </button>
                    </div>
                </div>

                <div
                    class="bg-white border-slate-200 overflow-hidden shadow-sm dark:bg-[#11183C] -ml-4 -mr-4 dark:border-slate-700"
                    v-for="product in products.data"
                    :key="product.id"
                >
                    <div class="flex items-center space-x-4 py-4 px-6">
                        <!-- <input class="border-slate-300" type="checkbox" name="[]" /> -->

                        <a href="#">
                            <img
                                class="w-16 h-16 object-fill rounded-full"
                                :src="getProductThumb(product)"
                                alt="Produto"
                            />
                        </a>

                        <div class="flex flex-col flex-1 justify-center">
                            <h3 class="text-xs text-slate-400">
                                {{
                                    product.category
                                        ? product.category.name
                                        : "Sem Categoria"
                                }}
                            </h3>

                            <h2 class="text-lg font-bold">
                                <Link
                                    :href="route('product.edit', product.id)"
                                    class="underline"
                                    >{{ product.name }}</Link
                                >
                            </h2>
                        </div>

                        <div class="flex">
                            <div
                                class="flex items-center mr-4 badge py-3"
                                :class="{
                                    'badge-success':
                                        product.status ==
                                        product_status_all.Active,
                                    'badge-error':
                                        product.status ==
                                        product_status_all.Inactive,
                                    'badge-warning':
                                        product.status ==
                                        product_status_all.Waiting,
                                }"
                            >
                                {{ product_status_array[product.status] }}
                            </div>

                            <div class="flex items-center ml-4">
                                <button
                                    @click="removeProduct(product.id)"
                                    class="btn btn-error btn-sm btn-outline btn-square"
                                >
                                    <Close />
                                </button>

                                <!-- <Link
                                    :href="route('product.destroy', product.id)"
                                    class="btn btn-error btn-sm btn-outline btn-square"
                                    method="delete"
                                    as="button"
                                    :onBefore="
                                        () => window.confirm('Are you sure?')
                                    "
                                >
                                    <Close />
                                </Link> -->
                            </div>
                        </div>
                    </div>
                </div>
            </LayoutSection>

            <div class="flex gap-4 justify-between mb-6">
                <PaginationPerPage :queryParams="queryParams" class>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </PaginationPerPage>

                <div>
                    <PaginationPages :pages="products" />
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { computed, reactive, watch } from "vue";
import FormInputText from "@/Components/Form/FormInputText.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import LayoutButton from "@/Components/LayoutButton.vue";
import LayoutHeader from "@/Components/LayoutHeader.vue";
import LayoutSection from "@/Components/LayoutSection.vue";
import PaginationPages from "@/Components/PaginationPages.vue";
import PaginationPerPage from "@/Components/PaginationPerPage.vue";
import TabsFilterByStatusLink from "@/Components/TabsFilterByStatusLink.vue";
import ArrowUp from "@/Icons/ArrowUp.vue";
import PlusIcon from "@/Icons/Plus.vue";
import Close from "@/Icons/Close.vue";
import DashboardLayout from "@/Layout/DashboardLayout.vue";

const props = defineProps({
    products: Object,
    product_count_array: Object,
    categories_all: Array,
    product_status_array: Array,
    product_status_all: Object,
    per_page: String,
});

const breadcrumbsLinks = [
    {
        label: "Início",
        link: route("dashboard"),
        isHome: true,
    },
    {
        label: "Produtos",
    },
    {
        label: "Listar",
    },
];

const queryParams = reactive({
    name: "",
    category: "",
    status: "",
    order_by: "name",
    direction: "",
    per_page: props.per_page,
});

watch(
    queryParams,
    () => {
        router.get(route("product.index"), queryParams, {
            replace: true,
            preserveState: true,
        });
    },
    { deep: true }
);

const sortBy = (field) => {
    if (queryParams.order_by === field) {
        console.log(queryParams.direction);
        queryParams.direction =
            queryParams.direction === "asc" ? "desc" : "asc";
    } else {
        queryParams.direction = "asc";
    }

    queryParams.order_by = field;
};

const filterByStatus = (status) => (queryParams.status = status);

const categories_all_complete = computed(() => {
    return [{ name: "Todas as categorias", id: "" }, ...props.categories_all];
});

const getProductThumb = (product) => {
    return product.images.length ? product.images[0] : "/img/no-image.png";
};

function removeProduct(product_id) {
    router.visit(route("product.destroy", product_id), {
        method: "delete",
        onBefore: () => confirm("Tem certeza que deseja deletar o produto?"),
    });
}
</script>
