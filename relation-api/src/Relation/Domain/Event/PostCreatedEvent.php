<?php
declare(strict_types=1);

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final  readonly class PostCreatedEvent implements DomainEventInterface
{
    public function __construct(
        private string $id,
        private string $relationId,
    ) {
    }

    public function getId(): string {
        return $this->id;
    }

    public function getRelationId(): string {
        return $this->relationId;
    }


}