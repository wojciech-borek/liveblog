<?php

namespace App\Notification\Application\Dto;

final readonly class PostCreatedNotificationDto implements NotificationDataDtoInterface
{
    public function __construct(
        private string  $id,
        private int     $position,
        private string  $content,
        private string  $createdAt,
        private string  $modifiedAt,
        private ?string $temporaryId = null
    ) {
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'position' => $this->position,
            'createdAt' => $this->createdAt,
            'modifiedAt' => $this->modifiedAt,
            'temporaryId' => $this->temporaryId
        ];
    }
}