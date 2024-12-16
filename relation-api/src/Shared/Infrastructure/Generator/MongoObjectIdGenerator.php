<?php

namespace App\Shared\Infrastructure\Generator;

use MongoDB\BSON\ObjectId;

final readonly class MongoObjectIdGenerator
{
    public static function generate(): string {
        return (new ObjectId())->__toString();
    }

}