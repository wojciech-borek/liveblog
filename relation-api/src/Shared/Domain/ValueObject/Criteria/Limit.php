<?php

namespace App\Shared\Domain\ValueObject\Criteria;

final class Limit
{
    public function __construct(
        private readonly int $value = 10
    ) {
        if ($this->value < 1) {
            throw new \InvalidArgumentException('Limit must be greater than 0');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }
}