<?php

namespace App\Relation\Application\EventHandler;

use App\Relation\Domain\Event\RelationDeletedEvent;
use App\Relation\Domain\Event\RelationRenumberedPostsEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class RelationRenumberedPostsEventHandler
{
    public function __construct(private LoggerInterface $logger
    ) {
    }

    public function __invoke(RelationRenumberedPostsEvent $command): void {
        $this->logger->info(sprintf('Relation %s renumbered posts', $command->getRelationId()));
    }
}
