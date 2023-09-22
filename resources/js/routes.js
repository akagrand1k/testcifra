import { createRouter, createWebHistory } from "vue-router";
import Product from "./components/ProductTable.vue";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import AddProductForm from "./components/AddProductForm.vue";

const routes = [
    {
        path: "/",
        name: "Product",
        component: Product,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        beforeEnter: (to, from, next) => {
            if (isLoggedIn()) {
                next("/");
            } else {
                next();
            }
        },
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        beforeEnter: (to, from, next) => {
            if (isLoggedIn()) {
                next("/");
            } else {
                next();
            }
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

function isLoggedIn() {
    const token = localStorage.getItem("authToken");
    return !!token;
}

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !isLoggedIn()) {
        next({ name: "Login" });
    } else {
        next();
    }
});

export default router;
