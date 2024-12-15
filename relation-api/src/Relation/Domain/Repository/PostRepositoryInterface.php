<?php

namespace App\Relation\Domain\Repository;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\ValueObject\Relation\PostCollection;
use App\Relation\Domain\ValueObject\Relation\RelationId;

interface PostRepositoryInterface
{
    public function save(Post $post): void;

    public function findByRelationId(RelationId $relationId): PostCollection;


}