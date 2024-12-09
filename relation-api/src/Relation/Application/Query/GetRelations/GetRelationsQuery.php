<?php

namespace App\Relation\Application\Query\GetRelations;

use App\Shared\Application\QueryCommandInterface;

readonly class GetRelationsQuery implements QueryCommandInterface
{
    public function __construct(private int $page, private ?int $limit) {}

    public function getPage(): int {
        return $this->page;
    }

    public function getLimit(): ?int {
        return $this->limit;
    }


}

