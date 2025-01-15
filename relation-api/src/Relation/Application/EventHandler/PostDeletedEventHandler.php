<?php
declare(strict_types=1);

namespace App\Relation\Application\EventHandler;

use App\Relation\Domain\Event\RelationDeletedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostDeletedEventHandler
{
    public function __construct(private LoggerInterface $logger
    ) {
    }

    public function __invoke(RelationDeletedEvent $command): void {
        $this->logger->info(sprintf('Post %s was deleted', $command->getId()));
    }
}
