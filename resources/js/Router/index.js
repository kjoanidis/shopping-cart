import {createRouter, createWebHistory } from "vue-router";
import Home from "../Pages/Home.vue";
import About from "../Pages/About.vue"
import ProductShow from "../Pages/Product/Show.vue"
import CartEdit from "../Pages/Cart/Edit.vue"
import CategoryShow from "../Pages/Category/Show.vue"
import OrderCreate from "../Pages/Order/Create.vue"

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },
    {
        path: "/about",
        name: "about",
        component: About,
    },
    {
        path: "/cart",
        name: "cart",
        component: CartEdit,
    },
    {
        path: "/product",
        name: "product",
        component: ProductShow,
    },
    {
        path: "/category",
        name: "category",
        component: CategoryShow,
    },
    {
        path: "/order",
        name: "order",
        component: OrderCreate,
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 }
    },
    routes,
});

export default router;
