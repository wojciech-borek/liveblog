<?php
declare(strict_types=1);

namespace App\Relation\Application\Query\Assembler;

use App\Relation\Application\Query\Dto\PostDTO;
use App\Relation\Domain\Model\Post;

class PostListDTOAssembler
{
    public function toDTO(Post $post): PostDTO {
        return new PostDTO(
            $post->getId(),
            $post->getContent(),
            $post->getPosition(),
            $post->getIsPublished(),
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