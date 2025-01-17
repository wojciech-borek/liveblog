<?php
declare(strict_types=1);

namespace App\Relation\Application\Service;

use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Domain\Criteria\CriteriaInterface;

class RelationService
{
    public function __construct(
        private RelationRepositoryInterface $relationRepository,
        private PostRepositoryInterface     $postRepository
    ) {
    }

    public function getRelationByIdWithPosts(RelationId $relationId): ?Relation {
        $relation = $this->relationRepository->findById($relationId);
        if (null === $relation) {
            return null;
        }
        $posts = $this->postRepository->findByRelationId($relation->getId());
        $relation->loadPosts($posts);
        return $relation;
    }
    public function getRelation(RelationId $relationId): ?Relation {
        return $this->relationRepository->findById($relationId);
    }

    /**
     * @return array<Relation>
     */
    public function getRelations(CriteriaInterface $criteria): array {
        return $this->relationRepository->getRelations($criteria);
    }

    /**
     * @return int
     */
    public function getTotalCount(CriteriaInterface $criteria): int {
        return $this->relationRepository->getTotalCount($criteria);
    }


}