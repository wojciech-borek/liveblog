<?php
declare(strict_types=1);

namespace App\Relation\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class InvalidRelationStatusException extends DomainException
{
    public function __construct(string $message) {
        parent::__construct($message,400);
    }

}