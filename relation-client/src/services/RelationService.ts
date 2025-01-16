import ApiClient, {ApiResponse} from "./ApiClient";
import {Relation} from "@/models";
import {Pagination} from "./Pagination";

export const RelationService = {

    async getRelations(page: number, limit: number, sortField: string, sortDirection: string): Promise<{
        data: Relation[];
        pagination: Pagination
    }> {
        const params = {page, limit}
        if (sortField.length) {
            Object.assign(params, {
                sortField: sortField, sortDirection
            });
        }

        const response = await ApiClient.get<ApiResponse<Relation[]>>("/relations", {
            params: params,
        });
        return response.data
    },


    async getRelation(id: string): Promise<{
        data: Relation[];
        pagination: Pagination
    }> {
        const response = await ApiClient.get<ApiResponse<Relation>>("/relations/" + id);
        return response.data
    },

    async create(params: { title: string }): Promise<{ data: null; pagination: null }> {
        const response = await ApiClient.post('/relations', {title: params.title})
        return response.data
    },

    async update(id: string, params: { title: string }): Promise<{ data: null; pagination: null }> {
        const response = await ApiClient.put('/relations/' + id, {title: params.title})
        return response.data
    },

    async delete(id: string): Promise<{ data: null; pagination: null }> {
        const response = await ApiClient.delete('/relations/' + id)
        return response.data
    }


}