<?php
declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

interface CriteriaInterface
{
    public function getPage(): int;

    public function getLimit(): int;

    public function getSortField(): ?string;

    public function getSortDirection(): int;

    public function getFilters(): ?array;

    public function getSkip(): int;

}