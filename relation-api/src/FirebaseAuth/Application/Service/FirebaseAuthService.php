<?php

namespace App\FirebaseAuth\Application\Service;


use App\FirebaseAuth\Domain\Exception\UserRegistrationException;
use App\FirebaseAuth\Domain\ValueObject\Email;
use App\FirebaseAuth\Domain\ValueObject\Password;
use App\Shared\Infrastructure\Firebase\FirebaseAuthInterface;
use Kreait\Firebase\Exception\AuthException;

readonly class FirebaseAuthService implements FirebaseAuthServiceInterface
{
    public function __construct(private FirebaseAuthInterface $firebaseAuth) {}

    public function registerUser(Email $email, Password $password): void {
        try {
            $this->firebaseAuth->registerUser($email->getValue(), $password->getValue());
        } catch (AuthException $e) {
            throw new UserRegistrationException('Failed to register user with Firebase: ' . $e->getMessage());
        } catch (\Exception $e) {
            throw new UserRegistrationException('An unexpected error occurred: ' . $e->getMessage());
        }
    }

}