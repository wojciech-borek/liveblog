<?php
namespace App\FirebaseAuth\Domain\Model;

use App\FirebaseAuth\Domain\Event\UserRegisteredEvent;
use App\FirebaseAuth\Domain\ValueObject\Email;
use App\FirebaseAuth\Domain\ValueObject\Password;
use App\Shared\Domain\Aggregate\AggregateRoot;

class User extends AggregateRoot
{
    private function __construct(private Email $email, private Password $password) {
    }

    static function establish(
        Email    $email,
        Password $password,
    ): User {
        return new self(
            $email,
            $password,
        );
    }

    public function register(): void {
        $this->raiseEvent(new UserRegisteredEvent($this->getEmail()->getValue()));
    }

    public function getEmail(): Email {
        return $this->email;
    }

    public function getPassword(): Password {
        return $this->password;
    }


}