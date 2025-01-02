<?php

namespace App\FirebaseAuth\Application\Service;

use App\FirebaseAuth\Domain\ValueObject\Email;
use App\FirebaseAuth\Domain\ValueObject\Password;

interface FirebaseAuthServiceInterface
{
    public function registerUser(Email $email, Password $password): void;

}