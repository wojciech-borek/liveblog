<?php

namespace App\Relation\Application\Query\GetOneRelation;

use App\Relation\Application\Query\Assembler\RelationDetailDTOAssembler;
use App\Relation\Application\Query\DTO\RelationDetailDTO;
use App\Relation\Application\Service\AssignPostToRelation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetOneRelationHandler
{
    public function __construct(
        private RelationRepositoryInterface $repository,
        private AssignPostToRelation        $assignPostToRelation,
        private RelationDetailDTOAssembler  $relationDetailDTOAssembler,
    ) {
    }

    public function __invoke(GetOneRelationQuery $query): RelationDetailDTO {
        $relationId = new RelationId($query->getId());
        $relation = $this->repository->findById($relationId);

        $this->assignPostToRelation->execute($relation);

        return $this->relationDetailDTOAssembler->toDTO($relation);
    }
}
