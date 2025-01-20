<?php
declare(strict_types=1);

namespace App\Notification\Application\EventHandler;

use App\Notification\Application\Dto\PostCreatedNotificationDto;
use App\Notification\Application\NotificationService;
use App\Relation\Domain\Event\PostCreatedEvent;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostCreatedEventHandler
{
    public function __construct(private NotificationService $notificationService
    ) {
    }

    public function __invoke(PostCreatedEvent $event): void {
        if (null === $event->getTemporaryId()) {
            return;
        }

        $notificationDto = new PostCreatedNotificationDto(
            $event->getId(),
            $event->getPosition(),
            $event->getContent(),
            $event->getCreatedAt(),
            $event->getModifiedAt(),
            $event->getTemporaryId()
        );

        $this->notificationService->notifyPostCreated('/relation/' . $event->getRelationId(), $notificationDto);
    }
}
