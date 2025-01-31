<?php

namespace App\Notification\Application\Dto;

final readonly class PostDeletedNotificationDto implements NotificationDataDtoInterface
{
    public function __construct(
        private string  $id,
    ) {
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
        ];
    }
}