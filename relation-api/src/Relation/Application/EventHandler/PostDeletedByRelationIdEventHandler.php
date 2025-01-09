<?php

namespace App\Relation\Application\EventHandler;

use App\Relation\Domain\Event\PostDeletedByRelationIdEvent;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostDeletedByRelationIdEventHandler
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ) {
    }

    public function __invoke(PostDeletedByRelationIdEvent $command): void {
        $id = new RelationId($command->getId());
        $posts = $this->postRepository->findByRelationId($id);

        foreach ($posts->getList() as $post) {
            $this->postRepository->delete($post->getId());
        }
    }

}