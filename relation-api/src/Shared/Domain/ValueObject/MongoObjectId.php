<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\DomainException;

class MongoObjectId
{
    public function __construct(private readonly string $value) {
        $this->isValid($value);
    }

    private function isValid($id): void {
        if (!preg_match('/^[0-9a-f]{24}$/i', $id)) {
            throw new DomainException(sprintf('ID %s has an incorrect format .', $id));
        }
    }

    public function value(): string {
        return $this->value;
    }

    public function __toString(): string {
        return $this->value();
    }
}