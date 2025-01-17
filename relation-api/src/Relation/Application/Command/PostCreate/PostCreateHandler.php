<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\PostCreate;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Post\IsPublished;
use App\Relation\Domain\ValueObject\Post\PostContent;
use App\Relation\Domain\ValueObject\Post\PostId;
use App\Relation\Domain\ValueObject\Post\PostPosition;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Application\MessageCommandBusInterface;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use App\Shared\Infrastructure\Generator\MongoObjectIdGenerator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class PostCreateHandler
{
    public function __construct(
        private PostRepositoryInterface    $postRepository,
        private RelationService            $relationService,
        private MessageCommandBusInterface $messageBus

    ) {
    }

    public function __invoke(PostCreateCommand $command): void {
        $relationId = new RelationId($command->getRelationId());
        $relation = $this->relationService->getRelationByIdWithPosts($relationId);
        if (empty($relation)) {
            throw new RelationNotFoundException($relationId->getValue());
        }

        $post = Post::establish(
            new PostId(MongoObjectIdGenerator::generate()),
            $relationId,
            new PostContent($command->getContent()),
            new PostPosition(0),
            new CreatedAt(new \DateTimeImmutable()),
            new ModifiedAt(new \DateTimeImmutable()),
            new IsPublished($command->isPublished())
        );
        $relation->addPost($post);

        $this->postRepository->save($post);

        foreach ($relation->getDomainEvents() as $event) {
            $this->messageBus->dispatch($event);
        }
        $relation->clearDomainEvents();
    }
}
