<?php

namespace App\Relation\Infrastructure\Persistence\MongoDB\Mapper;

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
        $relation = Relation::establish(
            new RelationId($document->getId()),
            new RelationTitle($document->getTitle()),
            new RelationStatus($document->getStatus()),
            new CreatedAt($document->getCreatedAt()),
            new ModifiedAt($document->getModifiedAt()),
        );

        foreach ($document->getPosts() as $post) {
            $post = PostMapper::toDomain($post);
            if ($post->getIsPublished()) {
                $relation->addPublishedPost($post);
            } else {
                $relation->addUnpublishedPost($post);
            }
        }
        return $relation;
    }

    public static function toDocument(Relation $relation): RelationDocument {
        $document = new RelationDocument();
        $document->setId($relation->getId()->getValue());
        $document->setTitle($relation->getTitle()->getValue());
        $document->setStatus($relation->getStatus()->getValue());
        $document->setCreatedAt($relation->getCreatedAt()->getValue());
        $document->setModifiedAt($relation->getModifiedAt()->getValue());

        return $document;
    }
}