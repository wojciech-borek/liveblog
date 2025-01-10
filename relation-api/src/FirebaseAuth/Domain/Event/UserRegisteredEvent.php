<?php
declare(strict_types=1);

namespace App\FirebaseAuth\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final readonly class UserRegisteredEvent implements DomainEventInterface
{
    public function __construct(private string $email) {
    }

    public function getEmail(): string {
        return $this->email;
    }
}