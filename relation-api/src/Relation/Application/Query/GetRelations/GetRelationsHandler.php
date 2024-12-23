<?php

namespace App\Relation\Application\Query\GetRelations;

use App\Relation\Application\Query\Assembler\RelationListDTOAssembler;
use App\Relation\Application\Query\Dto\RelationListDTO;
use App\Relation\Application\Service\RelationService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetRelationsHandler
{
    public function __construct(private RelationService $relationService, private RelationListDTOAssembler $relationDTOAssembler) {
    }

    /**
     * @param GetRelationsQuery $query
     * @return array<RelationListDTO>
     */
    public function __invoke(GetRelationsQuery $query): array {
        $items = $this->relationService->getRelations([]);
        return $this->relationDTOAssembler->toDTOCollection($items);
    }
}
