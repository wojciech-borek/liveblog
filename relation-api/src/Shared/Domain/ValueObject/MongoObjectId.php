<?php

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Exception\DomainException;
use MongoDB\BSON\ObjectId;

class MongoObjectId
{
    private string $value;

    public function __construct(string $value) {
        if (!$this->isValid($value)) {
            throw new DomainException(sprintf('ID %s has an incorrect format .', $value));
        }

        $this->value = $value;
    }

    public static function generate(): self {
        return new self((string)new ObjectId());
    }

    public function value(): string {
        return $this->value;
    }


    private function isValid(string $value): bool {
        return preg_match('/^[a-f0-9]{24}$/', $value) === 1;
    }
}