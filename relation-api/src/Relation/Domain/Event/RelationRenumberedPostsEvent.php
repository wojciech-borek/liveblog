<?php
declare(strict_types=1);

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final readonly class RelationRenumberedPostsEvent implements DomainEventInterface
{
    public function __construct(
        private string $relationId,
    ) {
    }

    public function getRelationId(): string {
        return $this->relationId;
    }

}