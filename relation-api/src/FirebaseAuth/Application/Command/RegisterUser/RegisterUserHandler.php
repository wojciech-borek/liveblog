<?php

namespace App\FirebaseAuth\Application\Command\RegisterUser;

use App\FirebaseAuth\Application\Service\FirebaseAuthServiceInterface;
use App\FirebaseAuth\Domain\ValueObject\Email;
use App\FirebaseAuth\Domain\ValueObject\Password;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RegisterUserHandler
{
    public function __construct(private FirebaseAuthServiceInterface $firebaseAuthService) {
    }

    public function __invoke(RegisterUserCommand $command) {
        $email = new Email($command->getEmail());
        $password = new Password($command->getPassword());
        $this->firebaseAuthService->registerUser($email, $password);
    }

}