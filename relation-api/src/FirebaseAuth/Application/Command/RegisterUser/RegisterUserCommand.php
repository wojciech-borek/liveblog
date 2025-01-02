<?php

namespace App\FirebaseAuth\Application\Command\RegisterUser;

final readonly class RegisterUserCommand
{
    public function __construct(private string $email, private string $password) {
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

}