<?php

namespace App\Relation\Application\EventHandler;

use App\Relation\Domain\Event\RelationDeletedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class RelationDeletedEventHandler
{
    public function __construct(
    ) {
    }

    public function __invoke(RelationDeletedEvent $command): void {

    }
}
