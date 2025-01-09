<?php

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

class PostDeletedByRelationIdEvent implements DomainEventInterface
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string {
        return $this->id;
    }


}