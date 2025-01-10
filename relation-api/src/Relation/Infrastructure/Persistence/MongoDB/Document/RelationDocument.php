<?php
declare(strict_types=1);

namespace App\Relation\Infrastructure\Persistence\MongoDB\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\PersistentCollection;

#[MongoDB\Document(db: null, collection: 'relation')]
class RelationDocument
{
    #[MongoDB\Id(strategy: 'none')]
    private string $id;

    #[MongoDB\Field(type: 'string')]
    private string $title;

    #[MongoDB\Field(type: 'string')]
    private string $status;

    #[MongoDB\Field(type: 'date')]
    private \DateTimeInterface $createdAt;

    #[MongoDB\Field(type: 'date')]
    private \DateTimeInterface $modifiedAt;

    public function getId(): string {
        return $this->id;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
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


}
