<?php

namespace App\Relation\Infrastructure\Persistence\MongoDB\Mapper;

use App\Relation\Domain\Model\PostCollection;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Relation\Infrastructure\Persistence\MongoDB\Document\RelationDocument;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;

class RelationMapper
{
    public static function toDomain(RelationDocument $document): Relation {
        return Relation::establish(
            new RelationId($document->getId()),
            new RelationTitle($document->getTitle()),
            new RelationStatus($document->getStatus()),
            new CreatedAt($document->getCreatedAt()),
            new ModifiedAt($document->getModifiedAt()),
            new PostCollection()
        );
    }

    public static function toDocument(Relation $relation): RelationDocument {
        $document = new RelationDocument();
        $document->setId($relation->getId()->value());
        $document->setTitle($relation->getTitle()->value());
        $document->setStatus($relation->getStatus()->value());
        $document->setCreatedAt($relation->getCreatedAt()->value());
        $document->setModifiedAt($relation->getModifiedAt()->value());

        return $document;
    }
}