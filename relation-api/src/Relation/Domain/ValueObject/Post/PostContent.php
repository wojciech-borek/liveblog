<?php

namespace App\Relation\Domain\ValueObject\Post;

final readonly class PostContent
{
    public function __construct(private string $value) {
        $this->isValid($value);
    }

    private function isValid(string $value): void {
        if (trim($value) === '') {
        }
    }

    public static function fromString(string $value): self {
        return new self($value);
    }

    public function getValue(): string {
        return $this->value;
    }
}