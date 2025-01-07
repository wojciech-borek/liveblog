<?php

namespace App\Shared\Application\Response;

interface ApiResponseInterface
{
    public function getSuccess(): bool;
    public function getMessage(): ?string;
    public function getData(): mixed;
    public function getPagination(): ?PaginationInterface;
}