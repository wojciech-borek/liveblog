<?php

namespace App\Relation\Application\Command\RemovePostByRelation;

readonly class PostDeleteByRelationIdCommand
{
    public function __construct(private string $relationId) {
    }
    public function getRelationId(): string {
        return $this->relationId;
    }
}