<?php

namespace App\Relation\Infrastructure\Persistence\Repository;

use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Infrastructure\Persistence\MongoDB\Document\RelationDocument;
use App\Relation\Infrastructure\Persistence\MongoDB\Mapper\RelationMapper;
use App\Shared\Domain\Criteria\CriteriaInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\ODM\MongoDB\MongoDBException;

class RelationRepository extends DoctrineRepository implements RelationRepositoryInterface
{

    /**
     * @param $criteria
     * @return array<Relation>
     * @throws MongoDBException
     */
    public function getRelations(CriteriaInterface $criteria): array {
        $qb = $this->repository(RelationDocument::class)->createQueryBuilder();
        $relations = [];
        $qb->limit($criteria->getLimit());
        if (!empty($criteria->getSortField())) {
            $qb->sort($criteria->getSortField(), $criteria->getSortDirection());
        }
        $filters = $criteria->getFilters();
        if (!empty($filters['status'])) {
            $qb->field('status')->in((array)$filters['status']);
        }
        $qb->skip($criteria->getSkip());
        foreach ($qb->getQuery()->execute() as $relation) {
            $relations[] = RelationMapper::toDomain($relation);
        }
        return $relations;
    }
    public function getTotalCount(CriteriaInterface $criteria): int {
        $qb = $this->repository(RelationDocument::class)->createQueryBuilder();
        $filters = $criteria->getFilters();
        if (!empty($filters['status'])) {
            $qb->field('status')->in((array)$filters['status']);
        }
        return $qb->count()->getQuery()->execute();
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

    public function delete(RelationId $id): void {
        $document = $this->documentManager()->find(RelationDocument::class, $id->getValue());
        $this->remove($document);
    }
}