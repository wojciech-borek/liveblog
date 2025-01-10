<?php
declare(strict_types=1);

namespace App\Relation\Domain\Repository;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Model\PostCollection;
use App\Relation\Domain\ValueObject\Post\PostId;
use App\Relation\Domain\ValueObject\Relation\RelationId;

interface PostRepositoryInterface
{
    public function save(Post $post): void;

    public function delete(PostId $id): void;

    public function findById(PostId $id): ?Post;

    public function findByRelationId(RelationId $relationId): PostCollection;


}