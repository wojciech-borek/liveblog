<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Firebase;

use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Factory;

class FirebaseAuth implements FirebaseAuthInterface
{
    private Auth $auth;

    public function __construct(string $firebaseCredentials) {
        $factory = (new Factory())->withServiceAccount($firebaseCredentials);
        $this->auth = $factory->createAuth();
    }

    public function registerUser(string $email, string $password): UserRecord
    {
       return $this->auth->createUserWithEmailAndPassword($email, $password);
    }

}
