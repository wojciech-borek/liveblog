<?php
declare(strict_types=1);

namespace App\Relation\Application\Query\Assembler;

use App\Relation\Application\Query\Dto\RelationDetailDTO;
use App\Relation\Domain\Model\Relation;

final readonly class RelationDetailDTOAssembler
{
    public function __construct(private PostListDTOAssembler $postListDTOAssembler) {
    }

    public function toDTO(Relation $relation): RelationDetailDTO {

        return new RelationDetailDTO(
            $relation->getId(),
            $relation->getTitle(),
            $relation->getStatus(),
            $relation->getCreatedAt(),
            $relation->getModifiedAt(),
            $this->postListDTOAssembler->toDTOCollection($relation->getPostsPublished()->getList()),
            $this->postListDTOAssembler->toDTOCollection($relation->getPostsUnpublished()->getList()),
        );
    }
}