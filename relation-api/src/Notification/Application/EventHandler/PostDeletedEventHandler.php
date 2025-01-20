<?php
declare(strict_types=1);

namespace App\Notification\Application\EventHandler;

use App\Notification\Application\Dto\PostDeletedNotificationDto;
use App\Notification\Application\NotificationService;
use App\Relation\Domain\Event\PostDeletedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostDeletedEventHandler
{
    public function __construct(private NotificationService $notificationService
    ) {
    }


    public function __invoke(PostDeletedEvent $event): void {

        if (null === $event->getId()) {
            return;
        }

        $notificationDto = new PostDeletedNotificationDto(
            $event->getId(),
        );

        $this->notificationService->notifyPostDeleted('/relation/' . $event->getRelationId(), $notificationDto);
    }
}
