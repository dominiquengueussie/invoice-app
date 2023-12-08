import { createRouter, createWebHistory } from "vue-router";

import Index from "../components/commandes/Index.vue";
import NotFound from "../components/NotFound.vue";
import New from "../components/commandes/New.vue";
import Show from "../components/commandes/ShowInvoice.vue";
import Edit from '../components/commandes/Edit.vue';

const routes = [
    
    { path: "/", component: Index },

    /**Afficher la page notfound si aucun paramètre ne correspond à l'url souhaité  **/
    { path: "/:pathMatch(.*)*", component: NotFound },

    { path: "/invoice/new", component: New},

    { path: "/invoice/show/:id", component: Show, props:true},

    { path: "/invoice/edit/:id", component: Edit, props:true}, 
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
