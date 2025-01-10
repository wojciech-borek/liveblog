<?php
declare(strict_types=1);

namespace App\FirebaseAuth\Application\EventHandler;

use App\FirebaseAuth\Domain\Event\UserRegisteredEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UserRegisteredEventHandler
{
    public function __invoke(UserRegisteredEvent $command): void {
    }
}