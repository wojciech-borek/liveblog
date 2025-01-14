import ApiClient, {ApiResponse} from "./ApiClient";
import {Relation} from "@/models";
import {Pagination} from "./Pagination";

export const PostService = {

    async create(params: { relationId: string, content: string, isPublished: boolean }): Promise<{
        data: null;
        pagination: null
    }> {
        const response = await ApiClient.post('/posts', {
            relationId: params.relationId, content: params.content, isPublished: params.isPublished
        })
        return response.data
    },

}