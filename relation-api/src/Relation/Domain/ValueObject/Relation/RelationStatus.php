<?php

namespace App\Relation\Domain\ValueObject\Relation;

use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Exception\InvalidRelationStatusException;

final readonly class RelationStatus
{
    public function __construct(private string $value) {
        $this->isValid($this->value);
    }

    private function isValid(string $value): void {
        if (!in_array($value, array_column(RelationStatusEnum::cases(), 'value'))) {
            throw new InvalidRelationStatusException('Relation status is invalid.');
        }
    }

    public function getValue(): string {
        return $this->value;
    }

    public function isPublished(): bool {
        return $this->value === RelationStatusEnum::PUBLISHED->value;
    }

    public function isDraft(): bool {
        return $this->value === RelationStatusEnum::DRAFT->value;
    }
}