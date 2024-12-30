<?php

namespace App\Shared\Domain\ValueObject\Criteria;

final class Page
{
    public function __construct(
        private readonly int $value = 1
    ) {
        if ($this->value < 1) {
            throw new \InvalidArgumentException('Page must be greater than 0');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }
}