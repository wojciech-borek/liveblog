<?php

namespace App\Relation\Infrastructure\Persistence\Repository;

use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Infrastructure\Persistence\MongoDB\Document\RelationDocument;
use App\Relation\Infrastructure\Persistence\MongoDB\Mapper\RelationMapper;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class RelationRepository extends DoctrineRepository implements RelationRepositoryInterface
{

    public function getRelations($criteria): array {
        $qb = $this->repository(RelationDocument::class)->createQueryBuilder();
        $relations = [];
        foreach ($qb->getQuery()->execute() as $relation) {
            $relations[] = RelationMapper::toDomain($relation);
        }
        return $relations;
    }

    public function findById(RelationId $id): ?Relation {
        $document = $this->documentManager()->find(RelationDocument::class, $id->getValue());

        if (!$document) {
            return null;
        }
        return RelationMapper::toDomain($document);
    }

    public function save(Relation $relation): void {
        $document = RelationMapper::toDocument($relation);
        $this->persist($document);
    }

    public function delete(Relation $relation): void {
        $document = RelationMapper::toDocument($relation);
        $this->remove($document);
    }
}