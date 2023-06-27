<template>
    <DashboardLayout>
        <div class="pt-12 px-6">
            <LayoutHeader :breadcrumbs-links="breadcrumbsLinks">
                <template #header-title>Cadastro de Produto</template>

                <template #append>
                    <div class="flex justify-between md:flex-1 md:justify-end">
                        <LayoutButton :href="route('product.index')" outline>
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
                    <LayoutSection id="section-images">
                        <template #header>Imagens</template>

                        <div>
                            <FilepondInput
                                ref="filepond_images_ref"
                                label-idle="Arraste arquivos aqui..."
                                v-bind:allow-multiple="true"
                                accepted-file-types="image/jpeg, image/png, image/webp"
                                :filepond_files="form.images"
                            />
                        </div>
                    </LayoutSection>

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

                        <div class="md:flex md:space-x-4">
                            <div class="w-full md:w-1/2 mb-4">
                                <FormLabel for="category_id"
                                    >Categoria</FormLabel
                                >

                                <FormSelect
                                    id="category_id"
                                    v-model="form.category_id"
                                >
                                    <option
                                        v-for="option in categories_all_complete"
                                        :value="option.id"
                                        :key="option.id"
                                    >
                                        {{ option.name }}
                                    </option>
                                </FormSelect>
                                <p class="text-rose-700">
                                    {{ errors.category_id }}
                                </p>
                            </div>

                            <div class="w-full md:w-1/2 mb-4">
                                <FormLabel for="brand">Marca</FormLabel>

                                <FormInputText
                                    type="text"
                                    placeholder="ex: GuepardoSys"
                                    id="brand"
                                    v-model="form.brand"
                                />
                                <p class="text-rose-700">{{ errors.brand }}</p>
                            </div>
                        </div>

                        <div class="md:flex md:space-x-4">
                            <div class="w-full md:w-1/3 mb-4">
                                <FormLabel for="price">Preço</FormLabel>

                                <FormInputText
                                    type="number"
                                    placeholder="ex: 19.98"
                                    id="price"
                                    min="0"
                                    step="0.01"
                                    v-model="form.price"
                                />
                                <p class="text-rose-700">{{ errors.price }}</p>
                            </div>

                            <div class="w-full md:w-1/3 mb-4">
                                <FormLabel for="status">Status</FormLabel>

                                <FormSelect id="status" v-model="form.status">
                                    <option
                                        v-for="option in product_status_enum"
                                        :value="option.id"
                                        :key="option.id"
                                    >
                                        {{ option.name }}
                                    </option>
                                </FormSelect>

                                <p class="text-rose-700">{{ errors.status }}</p>
                            </div>

                            <div class="w-full md:w-1/3 mb-4">
                                <FormLabel for="product_model"
                                    >Modelo</FormLabel
                                >

                                <FormInputText
                                    id="product_model"
                                    v-model="form.product_model"
                                    type="number"
                                />

                                <p class="text-rose-700">
                                    {{ errors.product_model }}
                                </p>
                            </div>
                        </div>

                        <div class="md:flex md:space-x-4">
                            <div class="w-full md:w-1/2 mb-4">
                                <FormLabel for="barcode">
                                    Código de Barras

                                    <InfoCircle
                                        class="cursor-pointer ml-2"
                                        title="EAN-9 | EAN-13 | CODE39"
                                    />
                                </FormLabel>

                                <FormInputText
                                    placeholder="ex: 1876551881"
                                    id="barcode"
                                    type="number"
                                    v-model="form.barcode"
                                />
                                <p class="text-rose-700">
                                    {{ errors.barcode }}
                                </p>
                            </div>

                            <div class="w-full md:w-1/2 mb-4">
                                <FormLabel for="ncm">NCM</FormLabel>

                                <FormInputText
                                    placeholder="ex: 551881"
                                    id="ncm"
                                    type="number"
                                    v-model="form.ncm"
                                />
                                <p class="text-rose-700">{{ errors.ncm }}</p>
                            </div>

                            <div class="w-full md:w-1/2 mb-4">
                                <FormLabel for="availability"
                                    >Disponibilidade (dias)</FormLabel
                                >

                                <FormInputText
                                    placeholder="ex: 3"
                                    id="availability"
                                    type="number"
                                    v-model="form.availability"
                                />
                                <p class="text-rose-700">
                                    {{ errors.availability }}
                                </p>
                            </div>
                        </div>

                        <div class="md:flex md:space-x-4">
                            <div class="w-full md:w-1/2 mb-4">
                                <div class="form-control">
                                    <FormLabel for="description"
                                        >Descrição Simples</FormLabel
                                    >

                                    <FormTextarea
                                        placeholder="Descrição simples"
                                        id="description"
                                        rows="3"
                                        v-model="form.description"
                                    />
                                    <p class="text-rose-700">
                                        {{ errors.description }}
                                    </p>
                                </div>
                            </div>

                            <div class="w-full md:w-1/2 mb-4">
                                <div class="form-control">
                                    <FormLabel for="description_html"
                                        >Descrição HTML</FormLabel
                                    >

                                    <FormTextarea
                                        placeholder="<p>Descrição HTML</p>"
                                        id="description_html"
                                        rows="3"
                                        v-model="form.description_html"
                                    />
                                    <p class="text-rose-700">
                                        {{ errors.description_html }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="md:flex md:space-x-4">
                            <div class="w-full mb-4">
                                <div class="form-control">
                                    <FormLabel for="keywords"
                                        >Palavras chave</FormLabel
                                    >

                                    <FormTextarea
                                        placeholder="vermelho, arte, teste"
                                        id="keywords"
                                        rows="2"
                                        v-model="form.keywords"
                                    />
                                    <p class="text-rose-700">
                                        {{ errors.keywords }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </LayoutSection>

                    <LayoutSection id="section-stock">
                        <template #header>Estoque</template>

                        <div class="md:flex md:space-x-4">
                            <div class="w-full md:w-1/3 mb-4">
                                <FormLabel for="stock_local"
                                    >Estoque Local</FormLabel
                                >

                                <FormInputText
                                    type="number"
                                    placeholder="ex: 30"
                                    id="stock_local"
                                    min="0"
                                    v-model="form.stock_local"
                                />
                                <p class="text-rose-700">
                                    {{ errors.stock_local }}
                                </p>
                            </div>

                            <div class="w-full md:w-1/3 mb-4">
                                <FormLabel for="stock_local_min"
                                    >Estoque Local Mín.</FormLabel
                                >

                                <FormInputText
                                    type="number"
                                    placeholder="ex: 10"
                                    id="stock_local_min"
                                    min="0"
                                    v-model="form.stock_local_min"
                                />
                                <p class="text-rose-700">
                                    {{ errors.stock_local_min }}
                                </p>
                            </div>

                            <div class="w-full md:w-1/3 mb-4">
                                <FormLabel for="stock_virtual"
                                    >Estoque Virtual</FormLabel
                                >

                                <FormInputText
                                    type="number"
                                    placeholder="ex: 80"
                                    id="stock_virtual"
                                    min="0"
                                    v-model="form.stock_virtual"
                                />
                                <p class="text-rose-700">
                                    {{ errors.stock_virtual }}
                                </p>
                            </div>
                        </div>
                    </LayoutSection>

                    <LayoutSection id="section-sizes">
                        <template #header>Medidas</template>

                        <div class="md:flex md:space-x-4">
                            <div class="w-full lg:w-1/4 mb-4">
                                <FormLabel for="width">Largura (cm)</FormLabel>

                                <FormInputText
                                    type="number"
                                    placeholder="ex: 12"
                                    id="width"
                                    min="0"
                                    step="0.01"
                                    v-model="form.width"
                                />
                                <p class="text-rose-700">{{ errors.width }}</p>
                            </div>

                            <div class="w-full lg:w-1/4 mb-4">
                                <FormLabel for="height">Altura (cm)</FormLabel>

                                <FormInputText
                                    type="number"
                                    placeholder="ex: 18"
                                    id="height"
                                    min="0"
                                    step="0.01"
                                    v-model="form.height"
                                />
                                <p class="text-rose-700">{{ errors.height }}</p>
                            </div>

                            <div class="w-full lg:w-1/4 mb-4">
                                <FormLabel for="length"
                                    >Comprimento (cm)</FormLabel
                                >

                                <FormInputText
                                    type="number"
                                    placeholder="ex: 6"
                                    id="length"
                                    min="0"
                                    step="0.01"
                                    v-model="form.length"
                                />
                                <p class="text-rose-700">{{ errors.length }}</p>
                            </div>

                            <div class="w-full lg:w-1/4 mb-4">
                                <FormLabel for="weight">Peso (g)</FormLabel>

                                <FormInputText
                                    type="number"
                                    placeholder="ex: 678"
                                    id="weight"
                                    min="0"
                                    step="0.01"
                                    v-model="form.weight"
                                />
                                <p class="text-rose-700">{{ errors.weight }}</p>
                            </div>
                        </div>
                    </LayoutSection>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>

<script setup>
import FilepondInput from "@/Components/FilepondInput.vue";
import ButtonSave from "@/Components/Form/ButtonSave.vue";
import FormInputText from "@/Components/Form/FormInputText.vue";
import FormLabel from "@/Components/Form/FormLabel.vue";
import FormSelect from "@/Components/Form/FormSelect.vue";
import FormTextarea from "@/Components/Form/FormTextarea.vue";
import LayoutButton from "@/Components/LayoutButton.vue";
import LayoutHeader from "@/Components/LayoutHeader.vue";
import LayoutSection from "@/Components/LayoutSection.vue";
import SidenavScrollto from "@/Components/SidenavScrollto.vue";
import SidenavScrolltoLink from "@/Components/SidenavScrolltoLink.vue";
import { slugfy } from "@/Helpers/string";
import CameraIcon from "@/Icons/Camera.vue";
import ChevronLeft from "@/Icons/ChevronLeft.vue";
import InfoCircle from "@/Icons/InfoCircle.vue";
import InformationCircleIcon from "@/Icons/InformationCircle.vue";
import ScaleIcon from "@/Icons/Scale.vue";
import StackCircleIcon from "@/Icons/StackCircle.vue";
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
        label: "Produtos",
        link: route("product.index", {
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
        name: "Imagens",
        route: "#section-images",
        icon: CameraIcon,
    },
    {
        name: "Informações",
        route: "#section-basic-info",
        icon: InformationCircleIcon,
    },
    {
        name: "Estoque",
        route: "#section-stock",
        icon: StackCircleIcon,
    },
    {
        name: "Medidas",
        route: "#section-sizes",
        icon: ScaleIcon,
    },
];

const props = defineProps({
    product_status_enum: Array,
    categories_all: Array,
    product: Object,
    errors: Object,
    csrf_token: String,
});

const form = useForm({
    category_id: "",
    name: "",
    slug: "",
    price: "",
    description: "",
    description_html: "",
    availability: "",
    stock_local: "",
    stock_local_min: "",
    stock_virtual: "",
    barcode: "",
    ncm: "",
    weight: "",
    height: "",
    width: "",
    length: "",
    keywords: "",
    status: "",
    brand: "",
    product_model_prefix_id: "",
    images: [],
});

form.transform((data) => {
    console.log(data);
    return {
        ...data,
        images: data.images.map((item) => item.serverId),
    };
});

watch(form, (new_data) => (form.slug = slugfy(new_data.name)));

const categories_all_complete = computed(() => {
    console.log(props.categories_all);
    return [{ name: "Escolha a categoria", id: "" }, ...props.categories_all];
});

const submit = function () {
    form.post(route("product.store"));
};
</script>
