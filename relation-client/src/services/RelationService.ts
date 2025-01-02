import ApiClient, {ApiResponse} from "./ApiClient";
import {Relation} from "../models";

export const RelationService = {
    async getRelations(page: number, limit: number): Promise<Relation> {
        const response = await ApiClient.get<ApiResponse<Relation[]>>("/relations", {
            params: {page, limit},
        });
        return response.data;
    }
}