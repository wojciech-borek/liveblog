import ApiClient, {ApiResponse} from "./ApiClient";
import {Relation} from "@/models";
import {Pagination} from "./Pagination";

export const RelationService = {

    async getRelations(page: number, limit: number, sortBy: string[]): Promise<{
        data: Relation[];
        pagination: Pagination
    }> {
        const params = {page, limit}
        if (sortBy.length) {
            Object.assign(params, {
                sortField: sortBy[0].key, sortDirection: sortBy[0].order
            });
        }

        const response = await ApiClient.get<ApiResponse<Relation[]>>("/relations", {
            params: params,
        });
        return response.data
    },

    async create(params: { title: string }): Promise<{ data: null; pagination: null }> {
        const response = await ApiClient.post('/relations', {title: params.title})
        return response.data
    },

    async delete(id: string): Promise<{ data: null; pagination: null }> {
        const response = await ApiClient.delete('/relations/' + id)
        return response.data
    }


}