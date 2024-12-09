<?php

namespace App\Relation\Application\Command\RelationDelete;

use App\Relation\Application\Command\RemovePostByRelation\PostDeleteByRelationIdCommand;
use App\Relation\Domain\Exception\Relation\RelationNotFoundException;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationDeleteHandler
{
    public function __construct(private RelationRepositoryInterface $repository, private MessageCommandBusInterface $messageCommandBus) {}

    public function __invoke(RelationDeleteCommand $command): void {
        $relation = $this->repository->findById($command->getId());
        if (empty($relation)) {
            throw new RelationNotFoundException($command->getId());
        }
        $this->repository->delete($relation);
        echo "Processing relation delete {$command->getId()}\n";
        $this->messageCommandBus->dispatch(new PostDeleteByRelationIdCommand($relation->getId()));
        /**
         * @todo send info by socket or Mercure or FrankenPHP to frontend
         */
    }
}
