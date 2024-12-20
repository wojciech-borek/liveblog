<?php

namespace App\Relation\Application\Query\Dto;

use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use App\Shared\Domain\ValueObject\MongoObjectId;

readonly class RelationListDTO implements \JsonSerializable
{
    public function __construct(
        private MongoObjectId $id,
        private RelationTitle $title,
        private RelationStatus $status,
        private CreatedAt $createdAt,
        private ModifiedAt $modifiedAt
    ) {
    }
    public function jsonSerialize(): array {
        return [
            "id" => $this->id->getValue(),
            "title" => $this->title->getValue(),
            "status" => $this->status->getValue(),
            "createdAt" => $this->createdAt->getValue()->format(DATE_ATOM),
            "modifiedAt" => $this->modifiedAt->getValue()->format(DATE_ATOM),
        ];
    }
}