<?php
declare(strict_types=1);

namespace App\Relation\Application\Query\GetRelations;

use App\Shared\Application\QueryCommandInterface;

readonly class GetRelationsQuery implements QueryCommandInterface
{
    public function __construct(private int $page, private int $limit, private ?array $filters, private ?string $sortField, private ?string $sortDirection) {
    }

    public function getPage(): int {
        return $this->page;
    }

    public function getLimit(): int {
        return $this->limit;
    }

    public function getFilters(): ?array {
        return $this->filters;
    }

    public function getSortField(): ?string {
        return $this->sortField;
    }

    public function getSortDirection(): ?string {
        return $this->sortDirection;
    }


}

