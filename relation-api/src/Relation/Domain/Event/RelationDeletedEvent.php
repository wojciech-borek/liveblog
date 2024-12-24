<?php

namespace App\Relation\Domain\Event;

final class RelationDeletedEvent
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string {
        return $this->id;
    }


}