<?php
declare(strict_types=1);

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final class RelationDeletedEvent implements DomainEventInterface
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string {
        return $this->id;
    }


}