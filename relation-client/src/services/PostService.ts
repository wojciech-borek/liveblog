import ApiClient, {ApiResponse} from "./ApiClient";
import {Relation,Post} from "@/models";
import {Pagination} from "./Pagination";

export const PostService = {

    async create(params: { relationId: string, content: string, isPublished: boolean, temporaryId: string }): Promise<Post> {
        const response = await ApiClient.post('/posts',params)
       return {
            id:"",
            content: params.content,
            temporaryId: params.temporaryId,
            status: 'in_sync',
          };
    },

}