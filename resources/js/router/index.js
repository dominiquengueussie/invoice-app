import { createRouter, createWebHistory } from "vue-router";

import Index from "../components/commandes/Index.vue";
import NotFound from "../components/NotFound.vue";
import New from "../components/commandes/New.vue"

const routes = [
    { path: "/", component: Index },

    /**Afficher la page notfound si aucun paramètre ne correspond à l'url souhaité  **/
    { path: "/:pathMatch(.*)*", component: NotFound },

    { path: "/invoice/new", component: New},
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
