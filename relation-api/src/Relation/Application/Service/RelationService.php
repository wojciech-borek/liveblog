<?php

namespace App\Relation\Application\Service;

use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;

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
        foreach ($posts->getList() as $post) {
            $relation->addPost($post);
        }
        return $relation;
    }

    public function getRelations($criteria): array {
        return $this->relationRepository->getRelations($criteria);
    }


}