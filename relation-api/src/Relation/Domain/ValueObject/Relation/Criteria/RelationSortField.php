<?php

namespace App\Relation\Domain\ValueObject\Relation\Criteria;

use App\Shared\Domain\ValueObject\Criteria\AbstractSortField;

class RelationSortField extends AbstractSortField
{

    protected function getAllowedFields(): array {
        return ['title', 'createdAt'];
    }
}