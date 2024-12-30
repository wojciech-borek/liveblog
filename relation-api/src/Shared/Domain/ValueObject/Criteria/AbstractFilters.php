<?php

namespace App\Shared\Domain\ValueObject\Criteria;

abstract class AbstractFilters
{
    abstract function getAllowedFilters(): array;

    protected readonly array $value;

    private array $validators = [];

    public function __construct(
        ?array $value = null,
        array  $validators = []

    ) {
        $this->value = $value ?? [];
        $this->validators = $validators;

        foreach ($this->value as $key => $val) {
            if (!in_array($key, $this->getAllowedFilters(), true)) {
                throw new \InvalidArgumentException("Invalid filter: $key");
            }
        }
        $this->validateValues();
    }

    private function validateValues(): void {
        foreach ($this->value as $key => $value) {
            foreach ($this->validators as $validator) {
                $validator->validate($key, $value);
            }
        }
    }

    public function getValue(): array {
        return $this->value;
    }
}