<?php

namespace App\Relation\Application\Command\RelationPublish;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationPublishHandler
{
    public function __construct(
        private RelationService             $relationService,
        private RelationRepositoryInterface $relationRepository
    ) {
    }

    public function __invoke(RelationPublishCommand $command): void {
        $id = new RelationId($command->getId());
        $relation = $this->relationService->getRelationByIdWithPosts($id);

        if (empty($relation)) {
            throw new RelationNotFoundException($id->getValue());
        }
        $relation->publish();
        $this->relationRepository->save($relation);

//        foreach ($relation->getDomainEvents() as $event) {
//            $this->messageBus->dispatch($event);
//        }
//
//        $relation->clearDomainEvents();
    }
}
