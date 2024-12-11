<?php
declare(strict_types=1);

namespace App\Relation\Domain\Model;


use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;

class Relation extends AggregateRoot
{
    protected function __construct(
        private readonly RelationId     $id,
        private readonly RelationTitle  $title,
        private readonly RelationStatus $status,
        private readonly CreatedAt      $createdAt,
        private readonly ModifiedAt     $modifiedAt,
        private readonly PostCollection $posts
    ) {
    }

    static function establish(
        RelationId     $id,
        RelationTitle  $title,
        RelationStatus $status,
        CreatedAt      $createdAt,
        ModifiedAt     $modifiedAt,
        PostCollection $posts
    ): Relation {
        return new self(
            $id,
            $title,
            $status,
            $createdAt,
            $modifiedAt,
            $posts
        );
    }

    public function getId(): RelationId {
        return $this->id;
    }

    public function getTitle(): RelationTitle {
        return $this->title;
    }

    public function getStatus(): RelationStatus {
        return $this->status;
    }

    public function getCreatedAt(): CreatedAt {
        return $this->createdAt;
    }

    public function getModifiedAt(): ModifiedAt {
        return $this->modifiedAt;
    }

    public function getPosts(): PostCollection {
        return $this->posts;
    }




}
