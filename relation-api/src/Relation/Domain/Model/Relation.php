<?php
declare(strict_types=1);

namespace App\Relation\Domain\Model;

use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Event\RelationDeletedEvent;
use App\Relation\Domain\Event\RelationRenumberedPostsEvent;
use App\Relation\Domain\Exception\InvalidRelationStatusException;
use App\Relation\Domain\ValueObject\Post\IsPublished;
use App\Relation\Domain\ValueObject\Post\PostPosition;
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

    public function delete(): void {
        $this->raiseEvent(new RelationDeletedEvent($this->getId()->getValue()));
    }

    public function toggleIsPublishedPost(Post $post): void {
        $currentCollection = $this->selectCollection($post);
        $currentCollection->removeFromListsById($post->getId());
        $currentCollection->toggleIsPublishedPost($post);
        $this->addPost($post);
        $this->renumberPosts();
    }

    private function renumberPosts(): void {
        $updatedPosts = array_merge(
            $this->postsPublished->renumber(),
            $this->postsUnpublished->renumber()
        );
        $this->raiseEvent(new RelationRenumberedPostsEvent($this->id->getValue(), $updatedPosts));
    }

    public function changeStatus(string $status): void {
        $status = RelationStatusEnum::tryFrom($status);
        $newStatus = new RelationStatus($status->value);
        if ($this->status->equals($newStatus)) {
            throw new InvalidRelationStatusException('Relation has the same status');
        }
        $this->status = $newStatus;
    }

    public function addPost(Post $post): void {
        $collection = $this->selectCollection($post);
        $post->setPosition(new PostPosition($collection->count() + 1));
        $collection->add($post);
    }

    private function selectCollection(Post $post): PostCollection {
        return $post->getIsPublished()->equals(new IsPublished(true))
            ? $this->postsPublished
            : $this->postsUnpublished;

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
