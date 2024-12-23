<?php
declare(strict_types=1);

namespace App\Relation\Domain\Model;

use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Event\RelationDeletedEvent;
use App\Relation\Domain\Exception\InvalidRelationStatusException;
use App\Relation\Domain\ValueObject\Post\IsPublished;
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
        private readonly ModifiedAt    $modifiedAt
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

    public function delete(): void
    {
        $this->domainEvents[] = new RelationDeletedEvent($this->getId()->getValue());
    }

    public function publish(): void {
        $newStatus = new RelationStatus(RelationStatusEnum::PUBLISHED->value);
        if ($this->status->equals($newStatus)) {
            throw new InvalidRelationStatusException('Relation is already published.');
        }
        $this->status = $newStatus;
    }

    public function publishPost(Post $post): void {
        /**
         * - find in unpublished collection (if not exists throw exception)
         * - change isPublished to true (if is true throw exception)
         * - move to published collection
         * - reorder published list
         * - add domain event post publish
         */
    }
    public function unpublishPost(Post $post): void {

    }

    public function unpublish(): void {
        $newStatus = new RelationStatus(RelationStatusEnum::DRAFT->value);
        if ($this->status->equals($newStatus)) {
            throw new InvalidRelationStatusException('Relation is already draft.');
        }
        $this->status = $newStatus;
    }

    public function addPost(Post $post): void {
        $post->getIsPublished()->equals(new IsPublished(true)) ? $this->addPublishedPost($post) : $this->addUnpublishedPost($post);
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
