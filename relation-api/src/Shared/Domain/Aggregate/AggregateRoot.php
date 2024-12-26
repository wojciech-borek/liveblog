<?php

namespace App\Shared\Domain\Aggregate;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    public function getDomainEvents(): array {
        return $this->domainEvents;
    }

    protected function raiseEvent($event): void {
        $this->domainEvents[] = $event;
    }

    public function clearDomainEvents(): void {
        $this->domainEvents = [];
    }
}