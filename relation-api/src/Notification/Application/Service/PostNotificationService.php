<?php

namespace App\Notification\Application\Service;

use App\Notification\Application\Dto\PostCreatedNotificationDto;
use App\Notification\Application\Dto\PostDeletedNotificationDto;
use App\Notification\Application\Dto\PostsRenumberedNotificationDto;
use App\Notification\Application\NotificationTopic;
use App\Notification\Domain\Enum\NotificationType;

class PostNotificationService extends AbstractNotificationService implements PostNotificationInterface
{
    public function notifyPostsRenumbered(NotificationTopic $topic, PostsRenumberedNotificationDto $postsRenumberedNotificationDto): void {
        $this->publish($topic, NotificationType::POSTS_RENUMBERED, $postsRenumberedNotificationDto);
    }

    public function notifyPostCreated(NotificationTopic $topic, PostCreatedNotificationDto $postCreatedNotificationDto): void {
        $this->publish($topic, NotificationType::POST_CREATED, $postCreatedNotificationDto);
    }

    public function notifyPostDeleted(NotificationTopic $topic, PostDeletedNotificationDto $postDeletedNotificationDto): void {
        $this->publish($topic, NotificationType::POST_DELETED, $postDeletedNotificationDto);
    }

}