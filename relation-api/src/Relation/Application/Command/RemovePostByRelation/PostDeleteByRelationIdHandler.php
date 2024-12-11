<?php

namespace App\Relation\Application\Command\RemovePostByRelation;

use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class PostDeleteByRelationIdHandler
{
    public function __construct(private PostRepositoryInterface $repository) {
    }

    public function __invoke(PostDeleteByRelationIdCommand $command): void {
        $id = new RelationId($command->getRelationId());

        $this->repository->deleteByRelationId($id);
        echo "Processing post delete by relation {$id->value()}\n";
    }
}