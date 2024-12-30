<?php

namespace App\Relation\Application\Query\GetRelations;

use App\Relation\Application\Query\Assembler\RelationListDTOAssembler;
use App\Relation\Application\Query\Criteria\RelationCriteria;
use App\Relation\Application\Query\Dto\RelationListDTO;
use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\ValueObject\Relation\Criteria\RelationFilters;
use App\Relation\Domain\ValueObject\Relation\Criteria\RelationSortField;
use App\Shared\Domain\ValueObject\Criteria\Limit;
use App\Shared\Domain\ValueObject\Criteria\Page;
use App\Shared\Domain\ValueObject\Criteria\SortDirection;
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

        $criteria = new RelationCriteria(
            new Page($query->getPage()),
            new Limit($query->getLimit()),
            $query->getSortField() !== null ? new RelationSortField($query->getSortField()) : null,
            $query->getSortDirection() !== null ? new SortDirection($query->getSortDirection()) : null,
            $query->getFilters() !== null ? new RelationFilters($query->getFilters()) : []
        );

        $items = $this->relationService->getRelations(
            $criteria
        );
        return $this->relationDTOAssembler->toDTOCollection($items);
    }
}
