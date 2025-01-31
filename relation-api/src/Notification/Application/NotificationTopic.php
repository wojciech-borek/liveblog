<?php

namespace App\Notification\Application;

final readonly class NotificationTopic
{
    private function __construct(
        private string $value
    ) {
        if (empty($value)) {
            throw new \InvalidArgumentException('Topic cannot be empty');
        }
    }

    public static function forRelation(string $relationId): self {
        return new self(sprintf('/relation/%s', $relationId));
    }

    public function getValue(): string {
        return $this->value;
    }

}