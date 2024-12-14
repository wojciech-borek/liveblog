<?php

namespace App\Relation\Infrastructure\Persistence\MongoDB\Mapper;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Model\PostCollection;
use App\Relation\Domain\ValueObject\Post\IsPublished;
use App\Relation\Domain\ValueObject\Post\PostContent;
use App\Relation\Domain\ValueObject\Post\PostId;
use App\Relation\Domain\ValueObject\Post\PostPosition;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Infrastructure\Persistence\MongoDB\Document\PostDocument;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;

class PostMapper
{
    public static function toDomain(PostDocument $document): Post {
        return Post::establish(
            new PostId($document->getId()),
            new RelationId($document->getRelation()->getId()),
            new PostContent($document->getContent()),
            new CreatedAt($document->getCreatedAt()),
            new ModifiedAt($document->getModifiedAt()),
            new IsPublished($document->isPublished()),
            new PostPosition($document->getPositionPublished()),
            new PostPosition($document->getPositionUnpublished()),
        );
    }


    public static function toDocument(Post $post): PostDocument {
        $document = new PostDocument();
        $document->setId($post->getId()->getValue());
        $document->setContent($post->getContent()->getValue());
        $document->setCreatedAt($post->getCreatedAt()->getValue());
        $document->setModifiedAt($post->getModifiedAt()->getValue());
        $document->setIsPublished($post->getIsPublished()->getValue());

        return $document;
    }
}