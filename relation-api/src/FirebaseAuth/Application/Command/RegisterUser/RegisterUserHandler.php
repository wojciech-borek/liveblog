<?php
declare(strict_types=1);

namespace App\FirebaseAuth\Application\Command\RegisterUser;

use App\FirebaseAuth\Domain\Exception\UserRegistrationEmailExistsException;
use App\FirebaseAuth\Domain\Exception\UserRegistrationException;
use App\FirebaseAuth\Domain\ValueObject\Email;
use App\FirebaseAuth\Domain\ValueObject\Password;
use App\Shared\Infrastructure\Firebase\FirebaseAuthInterface;
use Kreait\Firebase\Exception\Auth\EmailExists;
use App\FirebaseAuth\Domain\Model\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
readonly class RegisterUserHandler
{
    public function __construct(private FirebaseAuthInterface $firebaseAuth, private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void {
        $email = new Email($command->getEmail());
        $password = new Password($command->getPassword());

        $user = User::establish($email, $password);
        try {
            $this->firebaseAuth->registerUser($email->getValue(), $password->getValue());
            $user->register();

            foreach ($user->getDomainEvents() as $event) {
                $this->messageBus->dispatch($event);
            }
            $user->clearDomainEvents();

        } catch (EmailExists $e) {
            throw new UserRegistrationEmailExistsException();
        } catch (\Exception $e) {
            throw new UserRegistrationException($e->getMessage());
        }
    }

}