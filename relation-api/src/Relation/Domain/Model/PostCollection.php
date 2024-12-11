<?php

namespace App\Relation\Domain\Model;

final class PostCollection
{
    public function __construct(private array $posts = []) {
    }

    public function getAll(): array {
        return $this->posts;
    }

}