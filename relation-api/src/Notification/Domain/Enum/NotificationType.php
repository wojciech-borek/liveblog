<?php

namespace App\Notification\Domain\Enum;

enum NotificationType : string
{
    case POST_CREATED = 'post_created';
    case POST_DELETED = 'post_deleted';
    case POSTS_RENUMBERED = 'posts_renumbered';

}