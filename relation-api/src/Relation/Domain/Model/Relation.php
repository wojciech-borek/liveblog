<?php
declare(strict_types=1);

namespace App\Relation\Domain\Model;

use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Exception\InvalidRelationStatusException;
use App\Relation\Domain\ValueObject\Relation\PostCollection;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;

class Relation extends AggregateRoot
{
    private PostCollection $postsPublished;
    private PostCollection $postsUnpublished;

    protected function __construct(
        private readonly RelationId    $id,
        private readonly RelationTitle $title,
        private RelationStatus         $status,
        private readonly CreatedAt     $createdAt,
        private readonly ModifiedAt    $modifiedAt,
    ) {
        $this->postsPublished = new PostCollection();
        $this->postsUnpublished = new PostCollection();
    }

    static function establish(
        RelationId     $id,
        RelationTitle  $title,
        RelationStatus $status,
        CreatedAt      $createdAt,
        ModifiedAt     $modifiedAt,
    ): Relation {
        return new self(
            $id,
            $title,
            $status,
            $createdAt,
            $modifiedAt
        );
    }

    public function publish(): void {
        if ($this->status->isPublished()) {
            throw new InvalidRelationStatusException('Relation is already published.');
        }
        $this->status = new RelationStatus(RelationStatusEnum::PUBLISHED->value);
    }

    public function unpublish(): void {
        if ($this->status->isDraft()) {
            throw new InvalidRelationStatusException('Relation is already draft.');
        }
        $this->status = new RelationStatus(RelationStatusEnum::DRAFT->value);
    }

    public function addPost(Post $post): void {
        $post->getIsPublished() ? $this->addPublishedPost($post) : $this->addUnpublishedPost($post);
    }

    protected function addUnpublishedPost(Post $post): void {
        $this->postsUnpublished->add($post);
    }

    protected function addPublishedPost(Post $post): void {
        $this->postsPublished->add($post);
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

    public function getPostsPublished(): PostCollection {
        return $this->postsPublished;
    }

    public function getPostsUnpublished(): PostCollection {
        return $this->postsUnpublished;
    }

}
