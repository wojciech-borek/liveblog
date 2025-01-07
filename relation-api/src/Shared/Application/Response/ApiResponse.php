<?php

namespace App\Shared\Application\Response;

final readonly class ApiResponse implements ApiResponseInterface
{
    public function __construct(
        private bool                 $success,
        private ?string              $message = null,
        private mixed                $data = null,
        private ?PaginationInterface $pagination = null
    ) {
    }

    public function getSuccess(): bool {
        return $this->success;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function getData(): mixed {
        return $this->data;
    }

    public function getPagination(): ?PaginationInterface {
        return $this->pagination;
    }
}