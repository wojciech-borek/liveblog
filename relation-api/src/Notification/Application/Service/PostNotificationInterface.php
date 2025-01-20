<?php

namespace App\Notification\Application\Service;


use App\Notification\Application\Dto\PostCreatedNotificationDto;
use App\Notification\Application\Dto\PostDeletedNotificationDto;
use App\Notification\Application\Dto\PostsRenumberedNotificationDto;
use App\Notification\Application\NotificationTopic;

interface PostNotificationInterface
{

    public function notifyPostsRenumbered(NotificationTopic $topic, PostsRenumberedNotificationDto $postsRenumberedNotificationDto): void;

    public function notifyPostCreated(NotificationTopic $topic, PostCreatedNotificationDto $postCreatedNotificationDto): void;

    public function notifyPostDeleted(NotificationTopic $topic, PostDeletedNotificationDto $postDeletedNotificationDto): void;
}