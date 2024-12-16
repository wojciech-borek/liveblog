<?php

namespace App\Relation\Application\Query\Assembler;

use App\Relation\Application\Query\DTO\RelationListDTO;
use App\Relation\Domain\Model\Relation;

class RelationListDTOAssembler
{
    protected function toDTO(Relation $relation): RelationListDTO {
        return new RelationListDTO(
            $relation->getId(),
            $relation->getTitle(),
            $relation->getStatus(),
            $relation->getCreatedAt(),
            $relation->getModifiedAt()
        );
    }

    /**
     * @param array $relations
     * @return array<RelationListDTO>
     */
    public function toDTOCollection(array $relations): array {
        return array_map(
            fn(Relation $relation) => $this->toDTO($relation),
            $relations
        );
    }

}