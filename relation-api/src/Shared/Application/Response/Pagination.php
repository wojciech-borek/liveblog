<?php
declare(strict_types=1);

namespace App\Shared\Application\Response;

final readonly class Pagination implements PaginationInterface
{

    public function __construct(private int $totalCount, private int $currentPage, private int $perPage) {
    }

    public function getTotalCount(): int {
        return $this->totalCount;
    }

    public function getTotalPages(): int {
        return (int)ceil($this->totalCount / $this->getPerPage());
    }

    public function getCurrentPage(): int {
        return $this->currentPage;
    }

    public function getPerPage(): int {
        return $this->perPage;
    }
}