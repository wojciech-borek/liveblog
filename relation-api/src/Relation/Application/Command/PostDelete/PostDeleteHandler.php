<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\PostDelete;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\PostNotFoundException;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Post\PostId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class PostDeleteHandler
{
    public function __construct(
        private PostRepositoryInterface     $postRepository,
        private RelationService             $relationService
    ) {
    }

    public function __invoke(PostDeleteCommand $command): void {
        $postId = new PostId($command->getPostId());
        $post = $this->postRepository->findById($postId);
        if (empty($post)) {
            throw new PostNotFoundException($postId->getValue());
        }
        $relation = $this->relationService->getRelationByIdWithPosts($post->getRelationId());
        if (empty($relation)) {
            throw new RelationNotFoundException($post->getRelationId()->getValue());
        }
        $relation->removePost($post);
        $this->postRepository->updatePositions($relation->getPostsPublished());
        $this->postRepository->updatePositions($relation->getPostsUnpublished());
        $this->postRepository->save($post);
        $this->postRepository->delete($post->getId());
    }
}
