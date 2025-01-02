<?php

namespace App\FirebaseAuth\Domain\ValueObject;

use App\FirebaseAuth\Domain\Exception\InvalidEmailException;

final readonly class Email
{
    public function __construct(private string $value) {

        if (empty($value)) {
            throw new InvalidEmailException('Email cannot be empty.');
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('Invalid email format.');
        }
    }

    public function getValue(): string {
        return $this->value;
    }

}