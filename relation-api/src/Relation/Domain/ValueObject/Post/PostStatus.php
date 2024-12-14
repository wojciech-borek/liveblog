<?php

namespace App\Relation\Domain\ValueObject\Post;

final readonly class PostStatus
{
    private function __construct(private string $value) {
        $this->isValid($this->value);
    }

    private function isValid(string $value): void {

    }

    public function getValue(): string {
        return $this->value;
    }
}