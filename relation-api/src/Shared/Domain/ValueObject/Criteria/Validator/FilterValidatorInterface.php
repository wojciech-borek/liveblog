<?php
declare(strict_types=1);

namespace App\Shared\Domain\ValueObject\Criteria\Validator;

interface FilterValidatorInterface
{
    public function validate(string $filterKey, $filterValue): void;
}