import ApiClient, {ApiResponse} from "./ApiClient";
import {Relation, Post} from "@/models";
import {Pagination} from "./Pagination";

export const PostService = {

    async create(relationId: string, post: {
        content: string,
        isPublished: boolean,
        temporaryId: string
    }): Promise<{ data: null; pagination: null }> {
        try {
            const respone = await ApiClient.post('/posts', {
                relationId: relationId,
                content: post.content,
                isPublished: post.isPublished,
                temporaryId: post.temporaryId
            })
            return respone.data
        } catch (error) {
            console.error('Failed to create post:', error);
            throw error;
        }
    },

}