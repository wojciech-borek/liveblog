<?php

namespace App\Relation\Domain\ValueObject\Relation;

use App\Relation\Domain\Exception\InvalidRelationTitleException;

final readonly class RelationTitle
{
    public function __construct(private string $value) {
        $this->isValid($value);
    }

    private function isValid(string $value): void {
        if (trim($value) === '') {
            throw new InvalidRelationTitleException('Relation title cannot be empty.');
        }
        if (strlen($value) > 255) {
            throw new InvalidRelationTitleException('Relation title cannot exceed 255 characters.');
        }
    }

    public function getValue(): string {
        return $this->value;
    }
}