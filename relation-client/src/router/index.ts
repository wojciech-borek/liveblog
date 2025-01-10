import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Relations from '@/views/Relation/Relations.vue'
import RelationCreate from "@/views/Relation/RelationCreate.vue";

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'relations',
        component: Relations
    },
    {
        path: '/relation-create',
        name: 'relation-create',
        component: RelationCreate
    }
]
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router
