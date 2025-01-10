<?php
declare(strict_types=1);

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

    #[MongoDB\Field(type: 'int')]
    private int $position;

    #[MongoDB\Field(type: 'bool')]
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

    public function getPosition(): int {
        return $this->position;
    }

    public function setPosition(int $position): void {
        $this->position = $position;
    }


    public function isPublished(): bool {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): void {
        $this->isPublished = $isPublished;
    }

}
