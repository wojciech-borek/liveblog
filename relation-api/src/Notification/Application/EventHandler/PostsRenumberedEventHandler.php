<?php
declare(strict_types=1);

namespace App\Notification\Application\EventHandler;

use App\Notification\Application\Dto\PostsRenumberedNotificationDto;
use App\Notification\Application\NotificationTopic;
use App\Notification\Application\Service\PostNotificationInterface;
use App\Relation\Domain\Event\PostsRenumberedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostsRenumberedEventHandler
{
    public function __construct(private PostNotificationInterface $notificationService
    ) {
    }

    public function __invoke(PostsRenumberedEvent $event): void {

        $notificationDto = new PostsRenumberedNotificationDto(
            $event->getPostsPublishedPositionMap(),
            $event->getPostsPublishedPositionMap(),
        );

        $this->notificationService->notifyPostsRenumbered(NotificationTopic::forRelation($event->getRelationId()), $notificationDto);
    }
}
