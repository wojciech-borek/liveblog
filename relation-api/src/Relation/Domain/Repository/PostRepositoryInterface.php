<?php

namespace App\Relation\Domain\Repository;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\ValueObject\Relation\RelationId;

interface PostRepositoryInterface
{
    public function delete(Post $post): void;
    public function deleteByRelationId(RelationId $relationId): void;
    public function findById(RelationId $id): ?Post ;

}