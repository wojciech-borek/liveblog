import ApiClient, {ApiResponse} from "./ApiClient";
import {Relation} from "../models";
import {Pagination} from "./Pagination";

export const RelationService = {
    async getRelations(page: number, limit: number): Promise<{ data: Relation[]; pagination: Pagination }> {
        const response = await ApiClient.get<ApiResponse<Relation[]>>("/relations", {
            params: {page, limit},
        });
        const {data, pagination} = response.data;
        return {data, pagination};
    }
}