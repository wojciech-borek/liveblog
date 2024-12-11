<?php

namespace App\Relation\Domain\ValueObject\Relation;


final readonly class RelationStatus
{
    public function __construct(private string $value) {
        $this->isValid($this->value);
    }

    private function isValid(string $value): void {

    }

    public function value(): string {
        return $this->value;
    }
}