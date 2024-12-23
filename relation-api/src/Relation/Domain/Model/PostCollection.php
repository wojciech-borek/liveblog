<?php

namespace App\Relation\Domain\Model;

class PostCollection
{
    /** @var Post[] */
    private array $list = [];

    public function add(Post $post): void {
        $this->list[] = $post;
    }

    /**
     *
     * @return Post[]
     */
    public function getList(): array
    {
        return $this->list;
    }

    public function count(): int {
        return count($this->list);
    }

}