<?php

namespace App\Notification\Application\Service;

use App\Notification\Application\Dto\NotificationDataDtoInterface;
use App\Notification\Application\Mercure\NotificationSenderInterface;
use App\Notification\Application\NotificationTopic;
use App\Notification\Domain\Enum\NotificationType;

abstract class AbstractNotificationService
{
    public function __construct(private NotificationSenderInterface $notificationSender
    ) {
    }

    protected function publish(NotificationTopic $topic, NotificationType $type, NotificationDataDtoInterface $data): void {
        $this->notificationSender->send($topic, $type, $data);


    }

}