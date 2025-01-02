<?php

namespace App\FirebaseAuth\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class UserRegistrationEmailExistsException  extends DomainException
{
    public function __construct() {
        parent::__construct('User already exists', 400);

    }

}