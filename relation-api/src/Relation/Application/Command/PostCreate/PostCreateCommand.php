<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\PostCreate;

readonly class PostCreateCommand
{
    public function __construct(
        private string  $relationId,
        private string  $content,
        private bool    $isPublished,
        private ?string $temporaryId = null,
    ) {
    }

    public function getTemporaryId(): ?string {
        return $this->temporaryId;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getRelationId(): string {
        return $this->relationId;
    }

    public function isPublished(): bool {
        return $this->isPublished;
    }


}