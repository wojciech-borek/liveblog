<?php

namespace App\Relation\Application\Command\PostCreate;

use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
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
readonly class PostCreateHandler
{
    public function __construct(
        private RelationRepositoryInterface $relationRepository,
    ) {
    }

    public function __invoke(PostCreateCommand $command): void {
        $relationId = new RelationId($command->getRelationId());
        $relation = $this->relationRepository->findById($relationId);
        if (empty($relation)) {
            throw new RelationNotFoundException($relationId->getValue());
        }
        var_dump($relation);
        die;
//        $postPositionUnpublished = new PostPosition($relation->getPostsUnpublished()->count());
//        $postPositionPublished = new PostPosition($relation->getPostsPublished()->count());
//
//        $post = Post::establish(
//            new PostId(MongoObjectIdGenerator::generate()),
//            $relationId,
//            new PostContent($command->getContent()),
//            new CreatedAt(new \DateTimeImmutable()),
//            new ModifiedAt(new \DateTimeImmutable()),
//            new IsPublished(false),
//            $postPositionPublished,
//            $postPositionUnpublished->increment()
//        );
//
//        $relation->addUnpublishedPost($post);
//        $this->repository->save($post);

    }
}
