<?php

namespace App\Relation\Domain\Repository;

use App\Relation\Domain\Model\Relation;

interface RelationRepositoryInterface
{
    public function getRelations($criteria): array;
    public function save(Relation $relation): void;
    public function delete(Relation $relation): void;
    public function findById($id): ?Relation ;
}