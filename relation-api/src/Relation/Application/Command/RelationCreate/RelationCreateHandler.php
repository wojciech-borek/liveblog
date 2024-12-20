<?php

namespace App\Relation\Application\Command\RelationCreate;

use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Exception\InvalidRelationTitleException;
use App\Relation\Domain\Model\PostCollection;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use App\Shared\Infrastructure\Generator\MongoObjectIdGenerator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationCreateHandler
{
    public function __construct(private RelationRepositoryInterface $repository) {
    }

    public function __invoke(RelationCreateCommand $command): void {
        try {
            $relation = Relation::establish(
                new RelationId(MongoObjectIdGenerator::generate()),
                new RelationTitle($command->getTitle()),
                new RelationStatus(RelationStatusEnum::DRAFT->value),
                new CreatedAt(new \DateTimeImmutable()),
                new ModifiedAt(new \DateTimeImmutable()));

            $this->repository->save($relation);

        }catch (InvalidRelationTitleException $e){
throw new InvalidRelationTitleException($e->getMessage()) ;
        }
    }
}
