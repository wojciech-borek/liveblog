<?php

namespace App\Relation\Application\Command\RelationDelete;

use App\Relation\Application\Command\RemovePostByRelation\PostDeleteByRelationIdCommand;
use App\Relation\Domain\Exception\Relation\RelationNotFoundException;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationDeleteHandler
{
    public function __construct(private RelationRepositoryInterface $repository, private MessageCommandBusInterface $messageCommandBus) {}

    public function __invoke(RelationDeleteCommand $command): void {
        $id = new RelationId($command->getId());
        $relation = $this->repository->findById($id);
        if (empty($relation)) {
            throw new RelationNotFoundException($id->value());
        }
        $this->repository->delete($relation);
        echo "Processing relation delete {$id->value()}\n";
        $this->messageCommandBus->dispatch(new PostDeleteByRelationIdCommand($id->value()));
        /**
         * @todo send info by socket or Mercure or FrankenPHP to frontend
         */
    }
}
