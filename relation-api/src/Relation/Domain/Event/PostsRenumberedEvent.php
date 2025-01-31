<?php
declare(strict_types=1);

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final readonly class PostsRenumberedEvent implements DomainEventInterface
{
    public function __construct(
        private string $relationId,
        private array $postsPublishedPositionMap,
        private array $postsUnpublishedPositionMap
    ) {
    }

    public function getRelationId(): string {
        return $this->relationId;
    }

    public function getPostsPublishedPositionMap(): array {
        return $this->postsPublishedPositionMap;
    }

    public function getPostsUnpublishedPositionMap(): array {
        return $this->postsUnpublishedPositionMap;
    }


}