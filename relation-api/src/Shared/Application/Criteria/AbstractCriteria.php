<?php
declare(strict_types=1);

namespace App\Shared\Application\Criteria;

use App\Shared\Domain\Criteria\CriteriaInterface;
use App\Shared\Domain\ValueObject\Criteria\AbstractFilters;
use App\Shared\Domain\ValueObject\Criteria\AbstractSortField;
use App\Shared\Domain\ValueObject\Criteria\Limit;
use App\Shared\Domain\ValueObject\Criteria\Page;
use App\Shared\Domain\ValueObject\Criteria\SortDirection;

abstract class AbstractCriteria implements CriteriaInterface
{
    public Page $page;
    public Limit $limit;
    public ?AbstractSortField $sortField;
    public ?SortDirection $sortDirection;
    public ?AbstractFilters $filters;

    public function __construct(
        Page               $page,
        Limit              $limit,
        ?AbstractSortField $sortField = null,
        ?SortDirection     $sortDirection = null,
        ?AbstractFilters $filters = null
    ) {
        $this->page = $page;
        $this->limit = $limit;
        $this->sortField = $sortField ?? null;
        $this->sortDirection = $sortDirection ?? new SortDirection('ASC');
        $this->filters = $filters ?? null;
    }

    public function getPage(): int {
        return $this->page->getValue();
    }

    public function getLimit(): int {
        return $this->limit->getValue();
    }

    public function getSortField(): ?string {
        return $this->sortField?->getValue();
    }

    public function getSortDirection(): int {
        return $this->sortDirection->getValue();
    }

    public function getFilters(): ?array {
        return $this->filters?->getValue();
    }

    public function getSkip(): int {
        return ($this->getPage() - 1) * $this->getLimit();
    }

}