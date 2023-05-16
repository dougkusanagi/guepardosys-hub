import "../css/app.css";
import "./bootstrap";
import "vue-toastification/dist/index.css";

import { Head, Link, createInertiaApp, router } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import NProgress from "nprogress";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import Toast from "vue-toastification";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

router.on("start", () => NProgress.start());
router.on("finish", () => NProgress.done());

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast, {
                position: "bottom-right",
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: true,
                hideProgressBar: false,
                closeButton: "button",
                icon: true,
                rtl: false,
            })
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
    progress: {
        color: "#4338ca",
        showSpinner: true,
    },
});
