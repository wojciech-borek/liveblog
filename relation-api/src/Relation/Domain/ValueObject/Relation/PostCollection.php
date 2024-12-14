<?php

namespace App\Relation\Domain\ValueObject\Relation;

use App\Relation\Domain\Model\Post;

final class PostCollection
{
    /** @var Post[] */
    private array $list = [];

    public function add(Post $post): void {
        $this->list[] = $post;
    }

    public function count(): int {
        return count($this->list);
    }

}