<?php


namespace App\Shared\Infrastructure\Bus\Query;


use App\Shared\Application\QueryCommandInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerQueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $messageBus) {
        $this->messageBus = $messageBus;
    }


    public function handle(QueryCommandInterface $message)
    {
        return $this->handleQuery($message);
    }

}