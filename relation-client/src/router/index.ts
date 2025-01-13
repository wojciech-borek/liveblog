import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Relations from '@/views/Relation/Relations.vue'
import RelationCreate from "@/views/Relation/RelationCreate.vue";
import RelationEdit from '@/views/Relation/RelationEdit.vue';
import {RelationService} from "../services/RelationService";

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
    },
    {
        path: '/relation-edit/:id',
        name: 'relation-edit',
        component: RelationEdit,
        beforeEnter: async (to, from, next) => {
            try {
                const relation = await RelationService.getRelation(to.params.id as string);
                to.params.relationData = relation.data;
                next();
            } catch (error) {
                console.error('Error fetching relation:', error);
                next({ name: 'relations' });
            }
        },
    }
]
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router
