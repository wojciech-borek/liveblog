<?php
declare(strict_types=1);

namespace App\Relation\Domain\ValueObject\Post;

class IsPublished
{
    private bool $value;

    public function __construct(bool $value) {
        $this->value = $value;
    }

    public function getValue(): bool {
        return $this->value;
    }

    public function equals(IsPublished $isPublished): bool {
        return $this->value === $isPublished->getValue();
    }

    public function toggle(): self {
        return new self(!$this->value);
    }

}