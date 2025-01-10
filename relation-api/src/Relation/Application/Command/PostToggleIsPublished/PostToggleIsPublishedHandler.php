<?php

namespace App\Relation\Application\Command\PostToggleIsPublished;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\PostNotFoundException;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Post\PostId;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostToggleIsPublishedHandler
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private RelationService         $relationService,
        private MessageCommandBusInterface $messageBus

    ) {
    }

    public function __invoke(PostToggleIsPublishedCommand $command) {
        $postId = new PostId($command->getPostId());
        $post = $this->postRepository->findById($postId);
        if (empty($post)) {
            throw new PostNotFoundException($postId->getValue());
        }
        $relation = $this->relationService->getRelationByIdWithPosts($post->getRelationId());
        if (empty($relation)) {
            throw new RelationNotFoundException($post->getRelationId()->getValue());
        }
        $relation->toggleIsPublishedPost($post);
        $this->postRepository->save($post);

        foreach ($relation->getDomainEvents() as $event) {
            $this->messageBus->dispatch($event);
        }
        $relation->clearDomainEvents();

    }

}