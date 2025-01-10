<?php
declare(strict_types=1);

namespace App\Relation\Application\Query\GetOneRelation;

use App\Shared\Application\QueryCommandInterface;

readonly class GetOneRelationQuery implements QueryCommandInterface
{
    public function __construct(private string $id) {
    }

    public function getId(): string {
        return $this->id;
    }

}

