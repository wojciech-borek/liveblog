<?php

namespace App\Relation\Application\Query\DTO;

use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use App\Shared\Domain\ValueObject\MongoObjectId;

readonly class RelationListDTO
{
    public function __construct(private MongoObjectId $id, private RelationTitle $title, private RelationStatus $status, private CreatedAt $createdAt, private ModifiedAt $modifiedAt) {
    }

    public function getId(): string {
        return $this->id->getValue();
    }

    public function getTitle(): string {
        return $this->title->getValue();
    }

    public function getStatus(): string {
        return $this->status->getValue();
    }

    public function getCreatedAt(): \DateTimeImmutable {
        return $this->createdAt->getValue();
    }

    public function getModifiedAt(): \DateTimeImmutable {
        return $this->modifiedAt->getValue();
    }

}