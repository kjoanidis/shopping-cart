import { defineStore } from "pinia";
import axios from "axios";
import { useStorage } from '@vueuse/core';

export const useCartStore = defineStore({
    id: 'cart',
    state: () => ({
        cart: useStorage('cart', []),
        order: {},
        customer: {},
        loading: true,
        error: null,
        products: [],
    }),
    actions: {
        async getProducts() {
            try {
                this.loading = true;
                const response = await axios.get("/api/product");
                this.products = response.data.data;
                this.loading = false;
            } catch (error) {
                this.error = error;
            }
        },
        addToCart({ product }) {
            console.log(product)
            const item = product.skus[0];
            const foundProductInCartIndex = this.cart.findIndex(
                (cartItem) => item.id === cartItem.id
            );

            if (foundProductInCartIndex > -1) {
                this.cart[foundProductInCartIndex].quantity += 1;
            } else {
                item.quantity = 1;
                this.cart.push(item);
            }
        },
        removeProductFromCart({ item }) {
            this.cart.splice(this.cart.indexOf(item), 1);
        },
        clearCart() {
            this.cart.length = 0;
        },
        clearCustomer() {
            this.customer = {};
        },
        clearOrder() {
            this.order = {};
        },
        updateCustomer(customer) {
            this.customer = customer;
        },
        updateCartItemQuantity({ item }, quantity) {
            const foundProductInCartIndex = this.cart.findIndex(
                (cartItem) => item.slug === cartItem.slug
            );

            if (foundProductInCartIndex > -1) {
                this.cart[foundProductInCartIndex].quantity = parseInt(quantity);
            }
        },
        updateOrder(order) {
            this.order = order;
        },
        getSingleProduct(slug) {
            return this.products.find((product) => product.slug === slug);
        },
    },
    getters: {
        getCartQuantity() {
            return this.cart.reduce(
                (total, product) => total + product.quantity,
                0
            );
        },
        getOrderDetails() {
            return this.order;
        },
        getCartContents() {
            return this.cart;
        },
        getCustomer() {
            return this.customer;
        },
        getCartTotal() {
            return this.cart.reduce(
                (total, product) => total + product.price * product.quantity,
                0
            );
        },
    },
    persist: true,
});
