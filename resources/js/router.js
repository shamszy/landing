import { createWebHistory, createRouter } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("./views/Home.vue"),
    },
    {
        path: "/login",
        component: () => import("./views/auth/Login.vue"),
    },
    {
        path: "/register",
        component: () => import("./views/auth/Register.vue"),
    },
    {
        path: "/dashboard",
        component: () => import("./views/Dashboard.vue"),
    },
    {
        path: "/verify-otp",
        component: () => import("./views/auth/Otp.vue"),
    },
    {
        path: "/companies",
        component: () => import("./views/Companies.vue"),
    },
    {
        path: "/documents",
        component: () => import("./views/Documents.vue"),
    },
    {
        path: "/UpdateCompany",
        component: () => import("./views/UpdateCompant.vue"),
    },
    {
        path: "/:pathMatch(.*)*",
        component: () => import("./views/Notfound.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const publicPages = ['/','/verify-email', '/forget-password', '/login', '/register', '/contact', '/dashboard'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('token');

    if (authRequired && !loggedIn) {
        return next('/');
    }else {
        next();
    }
});

export default router;
