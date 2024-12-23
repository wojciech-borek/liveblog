<?php

namespace App\Relation\Application\Command\RelationPublish;

use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationPublishHandler
{
    public function __construct(private RelationRepositoryInterface $repository) {
    }

    public function __invoke(RelationPublishCommand $command): void {
        $id = new RelationId($command->getId());
        $relation = $this->repository->findById($id);
        if (empty($relation)) {
            throw new RelationNotFoundException($id->getValue());
        }
        $relation->publish();
        $this->repository->save($relation);

//        foreach ($relation->getDomainEvents() as $event) {
//            $this->messageBus->dispatch($event);
//        }
//
//        $relation->clearDomainEvents();
    }
}
