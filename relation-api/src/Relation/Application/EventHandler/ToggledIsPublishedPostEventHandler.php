<?php

namespace App\Relation\Application\EventHandler;

use App\Relation\Domain\Event\RelationDeletedEvent;
use App\Relation\Domain\Event\ToggledIsPublishedPostEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ToggledIsPublishedPostEventHandler
{
    public function __construct(private LoggerInterface $logger
    ) {
    }

    public function __invoke(ToggledIsPublishedPostEvent $command): void {
        $this->logger->info(sprintf('Toggled IsPublished to %s for Post  %s', $command->isPublished(), $command->getPostId()));
    }
}