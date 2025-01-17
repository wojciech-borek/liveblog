<?php
declare(strict_types=1);

namespace App\Relation\Domain\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final  readonly class PostCreatedEvent implements DomainEventInterface
{
    public function __construct(
        private string $id,
        private int    $position,
        private string $content,
        private string $createdAt,
        private string $modifiedAt,
        private string $relationId,
        private ?string $temporaryId = null,
    ) {
    }

    public function getId(): string {
        return $this->id;
    }

    public function getTemporaryId(): ?string {
        return $this->temporaryId;
    }


    public function getRelationId(): string {
        return $this->relationId;
    }

    public function getPosition(): int {
        return $this->position;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function getModifiedAt(): string {
        return $this->modifiedAt;
    }


}