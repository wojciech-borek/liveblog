<?php

namespace App\Relation\Domain\Repository;

use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Domain\Criteria\CriteriaInterface;

interface RelationRepositoryInterface
{
    public function getRelations(CriteriaInterface $criteria): array;
    public function getTotalCount(CriteriaInterface $criteria): int;
    public function save(Relation $relation): void;
    public function delete(RelationId $id): void;
    public function findById(RelationId $id): ?Relation;
}