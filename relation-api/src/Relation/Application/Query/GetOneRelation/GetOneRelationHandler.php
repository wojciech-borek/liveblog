<?php

namespace App\Relation\Application\Query\GetOneRelation;

use App\Relation\Application\Query\Assembler\RelationDetailDTOAssembler;
use App\Relation\Application\Query\Dto\RelationDetailDTO;
use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetOneRelationHandler
{
    public function __construct(
        private RelationService            $relationService,
        private RelationDetailDTOAssembler $relationDetailDTOAssembler,
    ) {
    }

    public function __invoke(GetOneRelationQuery $query): RelationDetailDTO {
        $relationId = new RelationId($query->getId());
        $relation = $this->relationService->getRelationByIdWithPosts($relationId);
        if (null === $relation) {
            throw new RelationNotFoundException($relationId->getValue());
        }
        return $this->relationDetailDTOAssembler->toDTO($relation);
    }
}
