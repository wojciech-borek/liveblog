<?php
declare(strict_types=1);

namespace App\Notification\Application\EventHandler;

use App\Relation\Domain\Event\PostCreatedEvent;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostCreatedEventHandler
{
    public function __construct(private HubInterface $hub
    ) {
    }

    public function __invoke(PostCreatedEvent $event): void {
        if (null !== $event->getTemporaryId()) {
            return;
        }

        $update = new Update(
            '/relation/' . $event->getRelationId(),
            json_encode([
                "temporaryId" => $event->getTemporaryId(),
                "id" => $event->getId(),
                "position" => $event->getPosition(),
                "content" => $event->getContent(),
                "createdAt" => $event->getCreatedAt(),
                "modifiedAt" => $event->getModifiedAt(),
            ])
        );

        $this->hub->publish($update);
    }
}
