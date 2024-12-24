<?php

namespace App\Relation\Application\Command\RelationDelete;

class RelationDeleteCommand
{
    public function __construct(private string $id) {}

    public function getId(): string {
        return $this->id;
    }

}