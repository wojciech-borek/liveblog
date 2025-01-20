<?php
declare(strict_types=1);

namespace App\Notification\Application\EventHandler;

use App\Notification\Application\Dto\PostCreatedNotificationDto;
use App\Notification\Application\NotificationTopic;
use App\Notification\Application\Service\PostNotificationInterface;
use App\Relation\Domain\Event\PostCreatedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostCreatedEventHandler
{
    public function __construct(private PostNotificationInterface $notificationService
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


        $this->notificationService->notifyPostCreated(NotificationTopic::forRelation($event->getRelationId()), $notificationDto);
    }
}
