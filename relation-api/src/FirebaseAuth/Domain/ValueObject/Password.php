<?php
declare(strict_types=1);

namespace App\FirebaseAuth\Domain\ValueObject;

use App\FirebaseAuth\Domain\Exception\InvalidPasswordException;

final readonly class Password
{
    public function __construct(private string $value) {

        if (strlen($value) < 8) {
            throw new InvalidPasswordException("Password must be at least 8 characters long.");
        }
    }

    public function getValue(): string {
        return $this->value;
    }

}