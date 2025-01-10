<?php
declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

final class ModifiedAt
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