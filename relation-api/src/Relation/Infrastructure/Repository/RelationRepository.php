<?php

namespace App\Relation\Infrastructure\Repository;

use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class RelationRepository extends DoctrineRepository implements RelationRepositoryInterface
{

    public function getRelations($criteria): array {
        $qb = $this->documentManager()->createQueryBuilder(Relation::class);

        return $qb->getQuery()->toArray();
    }

    public function findById($id): ?Relation {
        return $this->documentManager()->find(Relation::class, $id);
    }

    public function save(Relation $relation): void {
        $this->persist($relation);
    }


    public function delete(Relation $relation): void {
        $this->remove($relation);
    }
}