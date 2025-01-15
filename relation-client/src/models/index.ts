export interface Post {
    id: string;
    content: string,
}

export interface Relation {
    id: string;
    title: string;
    status: string;
    postsPublished: Post[]
    postsUnpublished: Post[],

}
