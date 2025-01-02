<?php

namespace App\FirebaseAuth\Domain\Exception;


use App\Shared\Domain\Exception\DomainException;

class InvalidPasswordException extends DomainException
{
    public function __construct(string $message) {
        parent::__construct($message, 400);

    }

}