<?php
declare(strict_types=1);

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final class PostDeletedEvent implements DomainEventInterface
{
    public function __construct(
        private string $id,
        private string $relationId,
        private bool   $isPublished,

    ) {
    }

    public function getId(): string {
        return $this->id;
    }

    public function getRelationId(): string {
        return $this->relationId;
    }

    public function isPublished(): bool {
        return $this->isPublished;
    }

}