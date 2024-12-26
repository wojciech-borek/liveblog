<?php

namespace App\Relation\Domain\Model;

use App\Relation\Domain\ValueObject\Post\IsPublished;
use App\Relation\Domain\ValueObject\Post\PostContent;
use App\Relation\Domain\ValueObject\Post\PostId;
use App\Relation\Domain\ValueObject\Post\PostPosition;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;

class Post
{
    private function __construct(
        private readonly PostId      $id,
        private readonly RelationId  $relationId,
        private readonly PostContent $content,
        private PostPosition         $position,
        private readonly CreatedAt   $createdAt,
        private readonly ModifiedAt  $modifiedAt,
        private IsPublished          $isPublished
    ) {
    }

    static function establish(
        PostId       $id,
        RelationId   $relationId,
        PostContent  $content,
        PostPosition $position,
        CreatedAt    $createdAt,
        ModifiedAt   $modifiedAt,
        IsPublished  $isPublished
    ): Post {
        return new self($id, $relationId, $content, $position, $createdAt, $modifiedAt, $isPublished);
    }

    public function getId(): PostId {
        return $this->id;
    }

    public function getRelationId(): RelationId {
        return $this->relationId;
    }

    public function getContent(): PostContent {
        return $this->content;
    }

    public function getCreatedAt(): CreatedAt {
        return $this->createdAt;
    }

    public function getModifiedAt(): ModifiedAt {
        return $this->modifiedAt;
    }

    public function getIsPublished(): IsPublished {
        return $this->isPublished;
    }

    public function getPosition(): PostPosition {
        return $this->position;
    }

    public function toggleIsPublished(): void {
        $this->isPublished = $this->isPublished->toggle();
    }


    public function setPosition(PostPosition $position): void {
        $this->position = $position;
    }


}