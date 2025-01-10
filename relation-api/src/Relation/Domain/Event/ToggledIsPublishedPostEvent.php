<?php

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final readonly class ToggledIsPublishedPostEvent implements DomainEventInterface
{
    public function __construct(
        private string $postId,
        private bool $isPublished
    ) {
    }

    public function getPostId(): string {
        return $this->postId;
    }

    public function isPublished(): bool {
        return $this->isPublished;
    }

}