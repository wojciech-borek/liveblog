<?php
declare(strict_types=1);

namespace App\Relation\Domain\ValueObject\Relation\Criteria\Validator;

use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Shared\Domain\ValueObject\Criteria\Validator\FilterValidatorInterface;

class RelationStatusFilterValidator implements FilterValidatorInterface
{
    public function validate(string $filterKey, $filterValue): void {
        if ($filterKey === 'status') {
            foreach ((array)$filterValue as $value) {
                new RelationStatus($value);
            }
        }
    }
}