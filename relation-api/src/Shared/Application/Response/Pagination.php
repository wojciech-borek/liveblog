<?php

namespace App\Shared\Application\Response;

class Pagination implements PaginationInterface {
    private int $totalCount;
    private int $totalPages;
    private int $currentPage;
    private int $perPage;

    public function __construct(int $totalCount, int $totalPages, int $currentPage, int $perPage)
    {
        $this->totalCount = $totalCount;
        $this->totalPages = $totalPages;
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}