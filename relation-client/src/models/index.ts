export interface Post {
    content: string,
}

export interface Relation {
    id: number;
    title: string;
    status: string;
    postsPublished: Post[]
    postsUnpublished: Post[],

}
