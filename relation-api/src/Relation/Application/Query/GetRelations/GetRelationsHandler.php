<?php

namespace App\Relation\Application\Query\GetRelations;

use App\Relation\Application\Query\Assembler\RelationListDTOAssembler;
use App\Relation\Application\Query\Dto\RelationListDTO;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetRelationsHandler
{
    public function __construct(private RelationRepositoryInterface $repository, private RelationListDTOAssembler $relationDTOAssembler) {
    }

    /**
     * @param GetRelationsQuery $query
     * @return array<RelationListDTO>
     */
    public function __invoke(GetRelationsQuery $query): array {
        $items = $this->repository->getRelations([]);
        return $this->relationDTOAssembler->toDTOCollection($items);
    }
}
