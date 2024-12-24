<?php

namespace App\Relation\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidPostIsPublishedException extends DomainException
{
    public function __construct(string $message) {
        parent::__construct($message,400);
    }

}