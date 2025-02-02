<?php
declare(strict_types=1);

namespace App\Relation\Domain\Model;

use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Event\PostCreatedEvent;
use App\Relation\Domain\Event\PostDeletedEvent;
use App\Relation\Domain\Event\RelationDeletedEvent;
use App\Relation\Domain\Event\PostsRenumberedEvent;
use App\Relation\Domain\Event\ToggledIsPublishedPostEvent;
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

    private function __construct(
        private readonly RelationId $id,
        private RelationTitle       $title,
        private RelationStatus      $status,
        private readonly CreatedAt  $createdAt,
        private ModifiedAt          $modifiedAt
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
        $this->postsPublished->clear();
        $this->postsUnpublished->clear();
    }

    public function removePost(Post $post): void {
        $currentCollection = $this->selectCollection($post);
        $currentCollection->removeFromListsById($post->getId());
        $this->renumberPosts();
        $this->raiseEvent(new PostDeletedEvent(
            $post->getId()->getValue(),
            $post->getRelationId()->getValue(),
            $post->getIsPublished()->getValue()
        ));
    }


    public function toggleIsPublishedPost(Post $post): void {
        $currentCollection = $this->selectCollection($post);
        $currentCollection->removeFromListsById($post->getId());
        $currentCollection->toggleIsPublishedPost($post);
        $collection = $this->selectCollection($post);
        $post->setPosition(new PostPosition($collection->count() + 1));
        $collection->add($post);
        $this->renumberPosts();
        $this->raiseEvent(new ToggledIsPublishedPostEvent($post->getId()->getValue(), $post->getIsPublished()->getValue()));

    }

    private function renumberPosts(): void {
        $this->postsPublished->renumber();
        $this->postsUnpublished->renumber();
        $this->raiseEvent(new PostsRenumberedEvent(
                $this->getId()->getValue(),
                $this->postsPublished->getIdPositionMap(),
                $this->postsUnpublished->getIdPositionMap())
        );
    }

    private function updateModifiedAt(): void {
        $this->modifiedAt = new ModifiedAt(new \DateTimeImmutable());
    }

    public function changeStatus(RelationStatusEnum $status): void {
        $newStatus = new RelationStatus($status->value);
        if ($this->status->equals($newStatus)) {
            throw new InvalidRelationStatusException('Relation has the same status');
        }
        $this->status = $newStatus;
        $this->updateModifiedAt();
    }

    public function changeTitle(RelationTitle $title): void {
        $this->title = $title;
        $this->updateModifiedAt();
    }

    public function addPost(Post $post, ?string $temporaryId): void {
        $collection = $this->selectCollection($post);
        $post->setPosition(new PostPosition($collection->count() + 1));
        $collection->add($post);
        $this->raiseEvent(new PostCreatedEvent(
            $post->getId()->getValue(),
            $post->getPosition()->getValue(),
            $post->getIsPublished()->getValue(),
            $post->getContent()->getValue(),
            $post->getCreatedAt()->getValue()->format(DATE_ATOM),
            $post->getModifiedAt()->getValue()->format(DATE_ATOM),
            $post->getRelationId()->getValue(),
            $temporaryId,
        ));
    }

    public function loadPosts(PostCollection $postCollection): void {
        foreach ($postCollection->getList() as $post) {
            $this->selectCollection($post)->add($post);
        }
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
