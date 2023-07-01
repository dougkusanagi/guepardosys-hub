<template>
    <aside class="h-[100vh] w-28 md:w-[12rem] p-4 fixed">
        <div
            class="h-full flex flex-col md:items-end bg-[#11183C] text-blue-200 rounded-[60px] text-xs dark:bg-[#11183C] dark:text-blue-200"
        >
            <div class="w-16 md:w-24 mt-10 mx-auto rounded-2xl hover:shadow-xl">
                <Link :href="route('dashboard')">
                    <LogoGuepardoSys class="hidden md:flex" />
                    <LogoGuepardoSysSm class="md:hidden" />
                </Link>
            </div>

            <div class="flex flex-col mt-6 items-center md:items-end">
                <NavbarItem
                    v-for="item in navbarItems"
                    :label="item.label"
                    :link="item.link"
                    :active="$page.component.startsWith(item.starts_with)"
                    :method="item.method"
                    :key="item.id"
                    :as="item.as"
                >
                    <component :is="item.icon" />
                </NavbarItem>
            </div>
        </div>
    </aside>
</template>

<script setup>
import NavbarItem from "@/Components/NavbarItem.vue";
import ArrowRightOnRectangle from "@/Icons/ArrowRightOnRectangle.vue";
import Bag from "@/Icons/Bag.vue";
import InboxStack from "@/Icons/InboxStack.vue";
import LogoGuepardoSys from "@/Icons/LogoGuepardoSys.vue";
import LogoGuepardoSysSm from "@/Icons/LogoGuepardoSysSm.vue";
import { Link } from "@inertiajs/vue3";

const navbarItems = [
    // {
    // 	id: 0,
    // 	label: "Dashboard",
    // 	link: route("dashboard"),
    // 	icon: Chart,
    // 	starts_with: "Dashboard",
    // },
    {
        id: 1,
        label: "Produtos",
        link: route("product.index"),
        // link: route("product.index", { order_by: "name" }),
        icon: Bag,
        starts_with: "Product/",
    },
    {
        id: 2,
        label: "Categorias",
        link: route("category.index"),
        icon: InboxStack,
        starts_with: "Category/",
    },
    {
        id: 3,
        label: "Deslogar",
        link: route("logout"),
        icon: ArrowRightOnRectangle,
        method: "post",
        as: "button",
    },
];
</script>
