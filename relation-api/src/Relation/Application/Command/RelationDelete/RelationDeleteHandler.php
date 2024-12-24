<?php

namespace App\Relation\Application\Command\RelationDelete;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class RelationDeleteHandler
{
    public function __construct(
        private RelationRepositoryInterface $relationRepository,
        private RelationService             $relationService,
        private MessageBusInterface         $messageBus,

    ) {
    }

    public function __invoke(RelationDeleteCommand $command): void {
        $id = new RelationId($command->getId());
        $relation = $this->relationService->getRelation($id);

        if (empty($relation)) {
            throw new RelationNotFoundException($id->getValue());
        }
        $relation->delete();
        $this->relationRepository->delete($relation->getId());

        foreach ($relation->getDomainEvents() as $event) {
            $this->messageBus->dispatch($event);
        }
        $relation->clearDomainEvents();

    }

}