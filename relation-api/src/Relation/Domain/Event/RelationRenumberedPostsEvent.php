<?php

namespace App\Relation\Domain\Event;

final readonly class RelationRenumberedPostsEvent
{
    public function __construct(
        private string $relationId,
        private array $updatedPosts
    ) {
    }

    public function getRelationId(): string {
        return $this->relationId;
    }

    public function getUpdatedPosts(): array {
        return $this->updatedPosts;
    }

}