<?php

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final readonly class RelationRenumberedPostsEvent implements DomainEventInterface
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