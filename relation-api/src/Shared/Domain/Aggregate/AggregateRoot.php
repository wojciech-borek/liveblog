<?php

namespace App\Shared\Domain\Aggregate;

use App\Shared\Domain\Event\DomainEventInterface;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    /**
     * @return array<DomainEventInterface>
     */
    public function getDomainEvents(): array {
        return $this->domainEvents;
    }

    protected function raiseEvent(DomainEventInterface $event): void {
        $this->domainEvents[] = $event;
    }

    public function clearDomainEvents(): void {
        $this->domainEvents = [];
    }
}