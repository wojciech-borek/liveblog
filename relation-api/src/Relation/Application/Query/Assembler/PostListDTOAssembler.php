<?php

namespace App\Relation\Application\Query\Assembler;

use App\Relation\Application\Query\Dto\PostDTO;
use App\Relation\Domain\Model\Post;

class PostListDTOAssembler
{
    protected function toDTO(Post $post): PostDTO {
        return new PostDTO(
            $post->getId(),
            $post->getContent(),
            $post->getCreatedAt(),
            $post->getModifiedAt()
        );
    }

    /**
     * @param array $posts
     * @return array<PostDTO>
     */
    public function toDTOCollection(array $posts): array {
        return array_map(
            fn(Post $post) => $this->toDTO($post),
            $posts
        );
    }

}