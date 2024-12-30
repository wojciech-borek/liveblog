<?php

namespace App\Shared\Domain\ValueObject\Criteria\Validator;

interface FilterValidatorInterface
{
    public function validate(string $filterKey, $filterValue): void;
}