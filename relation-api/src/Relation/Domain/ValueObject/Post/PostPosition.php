<?php
declare(strict_types=1);

namespace App\Relation\Domain\ValueObject\Post;

final readonly class PostPosition
{
    private int $value;

    public function __construct(int $value) {
        if ($value < 0) {
            throw new \InvalidArgumentException('Position must be a non-negative integer.');
        }
        $this->value = $value;
    }

    public function getValue(): int {
        return $this->value;
    }

    public function increment(): self {
        return new self($this->value + 1);
    }
}