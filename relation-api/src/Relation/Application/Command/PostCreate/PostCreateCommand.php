<?php

namespace App\Relation\Application\Command\PostCreate;

readonly class PostCreateCommand
{
    public function __construct(
        private string $relationId,
        private string $content,
        private bool   $isPublished,
    ) {
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