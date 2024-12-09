<?php

namespace App\Relation\Application\Command\RelationDelete;

readonly class RelationDeleteCommand
{
    public function __construct(private string $id) {
    }

    public function getId(): string {
        return $this->id;
    }

}