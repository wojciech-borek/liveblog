<?php

namespace App\Shared\Domain\ValueObject;

final class CreatedAt
{
    private \DateTimeImmutable $value;

    public function __construct(\DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    public function getValue(): \DateTimeImmutable
    {
        return $this->value;
    }

}