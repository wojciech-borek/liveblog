<?php

namespace App\Relation\Domain\Repository;

use App\Relation\Domain\Model\Post;

interface PostRepositoryInterface
{
    public function delete(Post $post): void;
    public function deleteByRelationId(string $relationId): void;
    public function findById($id): ?Post ;

}