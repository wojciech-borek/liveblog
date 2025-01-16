import {RelationService} from "../services/RelationService";
import {Relation} from "../models";
import {Pagination} from "../services/Pagination";
import {defineStore} from "pinia";
import {ref} from "vue";
import {DataTableOptions} from "../services/DataTableOptions";
export const useRelationStore = defineStore('relationStore', () => {
    const relations = ref<Relation[]>([]);
    const pagination = ref<Pagination>({
        totalCount: 0,
        totalPages: 0,
        currentPage: 1,
        perPage: 10,
    });
    const isLoading = ref<boolean>(false);
    const error = ref<string | null>(null);
    const fetchRelations = async (options: DataTableOptions) => {
        isLoading.value = true;
        error.value = null;

        const sortField = options.sortBy?.[0] || '';
        const sortDirection = options.sortDesc?.[0] ? 'desc' : 'asc';

        try {
            const response = await RelationService.getRelations(
                options.page,
                options.itemsPerPage,
                sortField,
                sortDirection
            );

            relations.value = response.data;
            pagination.value.totalCount = response.pagination.totalCount;
            pagination.value.totalPages = response.pagination.totalPages;
            pagination.value.currentPage = options.page;
            pagination.value.perPage = options.itemsPerPage;
        } catch (err) {
            console.error('Error:', err);
            error.value = 'Failed to fetch relations';
        } finally {
            isLoading.value = false;
        }
    };

    const deleteRelation = async (id: string) => {
        isLoading.value = true;
        try {
            await RelationService.delete(id);
            relations.value = relations.value.filter(relation => relation.id !== id);
        } catch (err) {
            console.error('Error:', error);
            error.value = 'Failed to delete relation';
        } finally {
            isLoading.value = false;
        }
    };

    return {
        relations,
        pagination,
        isLoading,
        error,
        fetchRelations,
        deleteRelation
    };
});
