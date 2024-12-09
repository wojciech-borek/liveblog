<?php

namespace App\Relation\Domain\Enum;

enum PostStatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
}