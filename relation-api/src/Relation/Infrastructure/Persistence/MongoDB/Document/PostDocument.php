<?php

namespace App\Relation\Infrastructure\Persistence\MongoDB\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(db: null, collection: 'post')]
class PostDocument
{
    #[MongoDB\Id(strategy: 'none')]
    private string $id;

    #[MongoDB\Field(type: 'string')]
    private string $content;

    #[MongoDB\Field(type: 'string')]
    protected string $relationId;

    #[MongoDB\Field(type: 'date')]
    private \DateTimeInterface $createdAt;

    #[MongoDB\Field(type: 'date')]
    private \DateTimeInterface $modifiedAt;

    #[MongoDB\Field(type: 'integer')]
    private int $positionPublished;
    #[MongoDB\Field(type: 'integer')]
    private int $positionUnpublished;
    #[MongoDB\Field(type: 'boolean')]
    private bool $isPublished;


    public function getId(): string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRelationId() {
        return $this->relationId;
    }

    /**
     * @param mixed $relationId
     */
    public function setRelationId($relationId): void {
        $this->relationId = $relationId;
    }


    public function getCreatedAt(): \DateTimeImmutable {
        return new \DateTimeImmutable($this->createdAt->format(DATE_ATOM));
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void {
        $this->createdAt = $createdAt;
    }

    public function getModifiedAt(): \DateTimeImmutable {
        return new \DateTimeImmutable($this->modifiedAt->format(DATE_ATOM));
    }

    public function setModifiedAt(\DateTimeInterface $modifiedAt): void {
        $this->modifiedAt = $modifiedAt;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function getPositionPublished(): int {
        return $this->positionPublished;
    }

    public function setPositionPublished(int $positionPublished): void {
        $this->positionPublished = $positionPublished;
    }

    public function getPositionUnpublished(): int {
        return $this->positionUnpublished;
    }

    public function setPositionUnpublished(int $positionUnpublished): void {
        $this->positionUnpublished = $positionUnpublished;
    }

    public function isPublished(): bool {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): void {
        $this->isPublished = $isPublished;
    }

}
