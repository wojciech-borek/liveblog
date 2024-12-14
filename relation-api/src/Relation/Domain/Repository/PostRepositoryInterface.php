<?php

namespace App\Relation\Domain\Repository;

use App\Relation\Domain\Model\Post;

interface PostRepositoryInterface
{
    public function save(Post $post): void;


}