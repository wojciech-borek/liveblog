<?php

namespace App\Relation\Domain\Repository;

use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\ValueObject\Relation\RelationId;

interface RelationRepositoryInterface
{
    public function getRelations($criteria): array;
    public function save(Relation $relation): void;
    public function delete(RelationId $id): void;
    public function findById(RelationId $id): ?Relation;
}