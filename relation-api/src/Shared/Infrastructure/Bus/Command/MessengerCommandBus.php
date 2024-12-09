<?php

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class MessengerCommandBus implements MessageCommandBusInterface
{
    public function __construct(private MessageBusInterface $messengerBus) {}

    /**
     * @throws ExceptionInterface
     */
    public function dispatch(object $message, array $stamps = []): void {
        $this->messengerBus->dispatch($message);
    }
}