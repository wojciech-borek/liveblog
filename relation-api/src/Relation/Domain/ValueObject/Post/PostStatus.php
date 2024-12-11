<?php

namespace App\Relation\Domain\ValueObject\Relation;

use App\Relation\Domain\Exception\Relation\InvalidRelationTitleException;
use App\Shared\Domain\Exception\DomainException;

final readonly class PostStatus
{
    private function __construct(private string $value) {
        $this->isValid($this->value);
    }

    private function isValid(string $value): void {

    }

    public function value(): string {
        return $this->value;
    }
}