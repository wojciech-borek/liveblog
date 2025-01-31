<?php
namespace App\Notification\Application\Mercure;

use App\Notification\Application\Dto\NotificationDataDtoInterface;
use App\Notification\Application\NotificationTopic;
use App\Notification\Domain\Enum\NotificationType;

interface NotificationSenderInterface
{
    public function send(NotificationTopic $topic, NotificationType $type, NotificationDataDtoInterface $data): void;
}