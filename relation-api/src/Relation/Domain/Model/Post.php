<?php

namespace App\Relation\Domain\Model;

use App\Relation\Domain\Enum\PostStatusEnum;
use App\Shared\Domain\Aggregate\AggregateRoot;

class Post extends AggregateRoot
{
    public function __construct(
        private readonly string             $id,
        private readonly string             $content,
        private readonly PostStatusEnum     $status,
        private readonly int                $positionPublished,
        private readonly int                $positionUnpublished,
        private readonly Relation           $relation,
        private readonly \DateTimeInterface $createdAt,
        private readonly \DateTimeInterface $modifiedAt
    ) {
    }

    public function getId(): string {
        return $this->id;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getStatus(): PostStatusEnum {
        return $this->status;
    }

    public function getPositionPublished(): int {
        return $this->positionPublished;
    }

    public function getPositionUnpublished(): int {
        return $this->positionUnpublished;
    }

    public function getRelation(): Relation {
        return $this->relation;
    }

    public function getCreatedAt(): \DateTimeInterface {
        return $this->createdAt;
    }

    public function getModifiedAt(): \DateTimeInterface {
        return $this->modifiedAt;
    }


}