<?php

namespace App\Relation\Application\EventHandler;

use App\Relation\Application\Command\RelationChangeStatus\RelationChangeStatusCommand;
use App\Relation\Domain\Event\RelationDeletedEvent;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationDeleteEventHandler
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {
    }

    public function __invoke(RelationDeletedEvent $command): void {
        $id = new RelationId($command->getId());
        $posts = $this->postRepository->findByRelationId($id);

        foreach ($posts->getList() as $post) {
            $this->postRepository->delete($post->getId());
        }
    }
}
