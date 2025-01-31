<?php

namespace App\Notification\Application\Dto;

final readonly class PostsRenumberedNotificationDto implements NotificationDataDtoInterface
{
    public function __construct(
        private array $postsPublishedPositionMap,
        private array $postsUnpublishedPositionMap,
    ) {
    }

    public function toArray(): array {
        return [
            'postsPublishedPositionMap' => $this->postsPublishedPositionMap,
            'postsUnpublishedPositionMap' => $this->postsUnpublishedPositionMap,
        ];
    }
}