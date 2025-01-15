<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\PostDelete;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\PostNotFoundException;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Post\IsPublished;
use App\Relation\Domain\ValueObject\Post\PostContent;
use App\Relation\Domain\ValueObject\Post\PostId;
use App\Relation\Domain\ValueObject\Post\PostPosition;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use App\Shared\Infrastructure\Generator\MongoObjectIdGenerator;
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
        $this->postRepository->delete($post->getId());
    }
}
