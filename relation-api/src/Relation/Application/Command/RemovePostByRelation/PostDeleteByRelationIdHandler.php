<?php

namespace App\Relation\Application\Command\RemovePostByRelation;

use App\Relation\Domain\Repository\PostRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class PostDeleteByRelationIdHandler
{
    public function __construct(private PostRepositoryInterface $repository) {
    }

    public function __invoke(PostDeleteByRelationIdCommand $command): void {
        $this->repository->deleteByRelationId($command->getRelationId());
        echo "Processing post delete by relation {$command->getRelationId()}\n";
    }
}