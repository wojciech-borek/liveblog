<?php

namespace App\Shared\Domain\ValueObject\Criteria;

abstract class AbstractSortField
{
    protected readonly string $field;

    abstract protected function getAllowedFields(): array;

    public function __construct(
        string $field
    ) {
        $allowedFields = $this->getAllowedFields();

        if (!in_array($field, $allowedFields, true)) {
            throw new \DomainException("Invalid sort field: $field");
        }

        $this->field = $field;
    }

    public function getValue(): string {
        return $this->field;
    }
}