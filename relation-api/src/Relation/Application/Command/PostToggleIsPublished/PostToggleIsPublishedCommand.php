<?php

namespace App\Relation\Application\Command\PostToggleIsPublished;

final readonly class PostToggleIsPublishedCommand
{
    public function __construct(
        private string $postId
    ) {
    }

    public function getPostId(): string {
        return $this->postId;
    }


}