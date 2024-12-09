<?php

namespace App\Relation\Domain\Enum;

enum RelationStatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
}