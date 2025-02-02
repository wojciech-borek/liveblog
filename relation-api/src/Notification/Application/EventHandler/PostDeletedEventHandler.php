<?php
declare(strict_types=1);

namespace App\Notification\Application\EventHandler;

use App\Notification\Application\Dto\PostDeletedNotificationDto;
use App\Notification\Application\NotificationTopic;
use App\Notification\Application\Service\PostNotificationInterface;
use App\Relation\Domain\Event\PostDeletedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostDeletedEventHandler
{
    public function __construct(private PostNotificationInterface $notificationService
    ) {
    }


    public function __invoke(PostDeletedEvent $event): void {

        if (empty($event->getId())) {
            return;
        }

        $notificationDto = new PostDeletedNotificationDto(
            $event->getId(),
            $event->isPublished(),

        );

        $this->notificationService->notifyPostDeleted(NotificationTopic::forRelation($event->getRelationId()), $notificationDto);
    }
}
