import { createRouter, createWebHistory } from "vue-router";

import ServiceForm from "../pages/services/ServiceForm.vue";
import ServiceList from "../pages/services/ServiceList.vue";

const routes = [
    { path: "/services", component: ServiceList },
    { path: "/services/create", component: ServiceForm },

    { path: "/", redirect: "/services" },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
