import {createRouter, createWebHistory } from "vue-router";
import Home from "../Pages/Home.vue";
import ProductShow from "../Pages/Product/Show.vue"
import CartEdit from "../Pages/Cart/Edit.vue"
import CategoryShow from "../Pages/Category/Show.vue"
import OrderCreate from "../Pages/Order/Create.vue"
import OrderShow from "../Pages/Order/Create.vue"

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },
    {
        path: "/cart",
        name: "cart",
        component: CartEdit,
    },
    {
        path: "/product/:slug",
        name: "product.show",
        component: ProductShow,
    },
    {
        path: "/category/:slug",
        name: "category.show",
        component: CategoryShow,
    },
    {
        path: "/checkout",
        name: "order.create",
        component: OrderCreate,
    },
    {
        path: "/confirmation",
        name: "order.show",
        component: OrderShow,
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
