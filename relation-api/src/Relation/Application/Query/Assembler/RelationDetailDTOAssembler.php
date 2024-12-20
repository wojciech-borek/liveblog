<?php

namespace App\Relation\Application\Query\Assembler;

use App\Relation\Application\Query\Dto\RelationDetailDTO;
use App\Relation\Domain\Model\Relation;

class RelationDetailDTOAssembler
{
    public function toDTO(Relation $relation): RelationDetailDTO {
        $relationDTO = new RelationDetailDTO(
            $relation->getId(),
            $relation->getTitle(),
            $relation->getStatus(),
            $relation->getCreatedAt(),
            $relation->getModifiedAt(),
        );

        return $relationDTO;
    }
}