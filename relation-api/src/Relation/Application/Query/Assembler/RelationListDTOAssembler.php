<?php

namespace App\Relation\Application\Query\Assembler;

use App\Relation\Application\Query\DTO\RelationListDTO;
use App\Relation\Domain\Model\Relation;

class RelationListDTOAssembler
{
    public function toDTO(Relation $relation): RelationListDTO {
        return new RelationListDTO(
            $relation->getId(),
            $relation->getTitle(),
            $relation->getStatus(),
            $relation->getCreatedAt(),
            $relation->getModifiedAt()
        );
    }

    public function toDTOCollection(array $relations): array {
        return array_map(
            fn(Relation $relation) => $this->toDTO($relation),
            $relations
        );
    }

}