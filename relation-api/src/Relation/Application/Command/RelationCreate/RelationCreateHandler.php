<?php

namespace App\Relation\Application\Command\RelationCreate;

use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Shared\Infrastructure\MongoObjectId\MongoObjectIdGenerator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationCreateHandler
{
    public function __construct(private RelationRepositoryInterface $repository) {
    }

    public function __invoke(RelationCreateCommand $command): void {

        $id = new RelationId(MongoObjectIdGenerator::generate());
        $relationTitle = new RelationTitle($command->getTitle());

        $relation = new Relation(
            $id->value(),
            $relationTitle->value(),
            RelationStatusEnum::DRAFT,
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
        );

        $this->repository->save($relation);
        echo "Processing relation create {$id}\n";
        /**
         * @todo send info by socket or Mercure or FrankenPHP to frontend
         */
    }
}
