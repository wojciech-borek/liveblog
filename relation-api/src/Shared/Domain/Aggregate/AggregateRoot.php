<?php

namespace App\Shared\Domain\Aggregate;

abstract class AggregateRoot
{
    protected array $domainEvents = [];

    public function getDomainEvents(): array {
        return $this->domainEvents;
    }

    public function clearDomainEvents(): void {
        $this->domainEvents = [];
    }
}