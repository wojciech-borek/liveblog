<?php

namespace App\Relation\Domain\Model;

use App\Relation\Domain\ValueObject\Relation\PostContent;
use App\Relation\Domain\ValueObject\Relation\PostId;
use App\Relation\Domain\ValueObject\Relation\PostStatus;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;

class Post
{
    private function __construct(
        private readonly PostId      $id,
        private readonly PostContent $content,
        private readonly PostStatus  $status,
//        private readonly int                $positionPublished,
//        private readonly int                $positionUnpublished,
        private readonly CreatedAt   $createdAt,
        private readonly ModifiedAt  $modifiedAt
    ) {
    }

    static function establish(
        PostId      $id,
        PostContent $content,
        PostStatus  $status,
        CreatedAt   $createdAt,
        ModifiedAt  $modifiedAt,
    ): Post {
        return new self($id, $content, $status, $createdAt, $modifiedAt);
    }


}