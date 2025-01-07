import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Relations from "../views/Relations.vue";

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'relations',
        component: Relations
    }
]
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router
