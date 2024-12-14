<?php

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

    public function toggle(): self {
        return new self(!$this->value);
    }

}