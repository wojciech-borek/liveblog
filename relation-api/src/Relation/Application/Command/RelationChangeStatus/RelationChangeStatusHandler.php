<?php

namespace App\Relation\Application\Command\RelationChangeStatus;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class RelationChangeStatusHandler
{
    public function __construct(
        private RelationService             $relationService,
        private RelationRepositoryInterface $relationRepository
    ) {
    }

    public function __invoke(RelationChangeStatusCommand $command): void {
        $id = new RelationId($command->getId());
        $relation = $this->relationService->getRelationByIdWithPosts($id);

        if (empty($relation)) {
            throw new RelationNotFoundException($id->getValue());
        }

        $relation->changeStatus($command->getStatus());
        $this->relationRepository->save($relation);
    }
}
