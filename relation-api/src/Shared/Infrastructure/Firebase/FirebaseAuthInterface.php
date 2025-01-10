<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Firebase;

use Kreait\Firebase\Auth\UserRecord;

interface FirebaseAuthInterface
{
    public function registerUser(string $email, string $password): UserRecord;
}
