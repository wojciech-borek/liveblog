<?php

namespace App\Relation\Infrastructure\Persistence\Repository;

use App\Relation\Domain\Model\PostCollection;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Relation\Infrastructure\Persistence\MongoDB\Document\RelationDocument;
use App\Relation\Infrastructure\Persistence\MongoDB\Mapper\RelationMapper;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class RelationRepository extends DoctrineRepository implements RelationRepositoryInterface
{

    public function getRelations($criteria): array {
        $qb = $this->documentManager()->createQueryBuilder(RelationDocument::class);
        $relations = [];
        foreach ($qb->getQuery()->execute() as $relation) {
            $relations[] = RelationMapper::toDomain($relation);
        }
        return $relations;
    }

    public function findById($id): ?Relation {
        $document = $this->documentManager()->find(RelationDocument::class, $id);
        if (!$document) {
            return null;
        }
        return RelationMapper::toDomain($document);
    }

    public function save(Relation $relation): void {
        $relationDocument = RelationMapper::toDocument($relation);
        $this->persist($relationDocument);
    }

    public function delete(Relation $relation): void {
        $relationDocument = RelationMapper::toDocument($relation);
        $this->remove($relationDocument);
    }
}