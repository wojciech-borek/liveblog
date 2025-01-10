<?php
declare(strict_types=1);

namespace App\Shared\Application\Response;

interface PaginationInterface
{
    public function getTotalCount(): int;

    public function getTotalPages(): int;

    public function getCurrentPage(): int;

    public function getPerPage(): int;
}