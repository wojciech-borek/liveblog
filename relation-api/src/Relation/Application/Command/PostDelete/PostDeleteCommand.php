<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\PostDelete;

readonly class PostDeleteCommand
{
    public function __construct(
        private string $postId,
    ) {
    }

    public function getPostId(): string {
        return $this->postId;
    }


}