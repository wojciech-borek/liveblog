import ApiClient, {ApiResponse} from "./ApiClient";
import {Relation, Post} from "@/models";
import {Pagination} from "./Pagination";

export const PostService = {

    async create(relationId:string, post: {
        content: string,
        isPublished: boolean,
        temporaryId: string
    }): Promise<Post> {
        try {
            await ApiClient.post('/posts', {
                relationId: relationId,
                content: post.content,
                isPublished: post.isPublished,
                temporaryId: post.temporaryId
            })
        } catch (error) {
            console.error('Failed to create post:', error);
            throw error;
        }
    },

}