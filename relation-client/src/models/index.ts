export interface Post {
    id: string;
    status: string,
    position: number,
    content: string,
    temporaryId: string
}

export interface Relation {
    id: string;
    title: string;
    status: string;
    postsPublished: Post[]
    postsUnpublished: Post[],

}
