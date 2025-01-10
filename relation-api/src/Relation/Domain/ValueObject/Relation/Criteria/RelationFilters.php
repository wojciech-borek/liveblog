<?php
declare(strict_types=1);

namespace App\Relation\Domain\ValueObject\Relation\Criteria;

use App\Relation\Domain\ValueObject\Relation\Criteria\Validator\RelationStatusFilterValidator;
use App\Shared\Domain\ValueObject\Criteria\AbstractFilters;

class RelationFilters extends AbstractFilters
{
    protected const ALLOWED_FILTERS = ['status'];

    public function __construct(?array $value = null) {
        $validators = [
            new RelationStatusFilterValidator(),
        ];
        parent::__construct($value, $validators);
    }

    function getAllowedFilters(): array {
        return self::ALLOWED_FILTERS;
    }
}