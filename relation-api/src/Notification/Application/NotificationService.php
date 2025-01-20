<?php

namespace App\Notification\Application;

use App\Notification\Application\Dto\NotificationDataDtoInterface;
use App\Notification\Application\Dto\PostCreatedNotificationDto;
use App\Notification\Application\Dto\PostDeletedNotificationDto;
use App\Notification\Application\Dto\PostsRenumberedNotificationDto;
use App\Notification\Domain\Enum\NotificationType;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

final readonly class NotificationService
{
    public function __construct(private HubInterface $hub) {
    }

    public function notifyPostsRenumbered(string $topic, PostsRenumberedNotificationDto $postsRenumberedNotificationDto): void {
        $this->publish($topic, NotificationType::POSTS_RENUMBERED, $postsRenumberedNotificationDto);
    }

    public function notifyPostCreated(string $topic, PostCreatedNotificationDto $postCreatedNotificationDto): void {
        $this->publish($topic, NotificationType::POST_CREATED, $postCreatedNotificationDto);
    }

    public function notifyPostDeleted(string $topic, PostDeletedNotificationDto $postDeletedNotificationDto): void {
        $this->publish($topic, NotificationType::POST_DELETED, $postDeletedNotificationDto);
    }

    private function publish(string $topic, NotificationType $type, NotificationDataDtoInterface $data): void {
        $update = new Update(
            $topic,
            json_encode([
                'type' => $type->value,
                'data' => $data->toArray()
            ])
        );
        $this->hub->publish($update);
    }

}