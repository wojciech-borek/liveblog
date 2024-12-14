<?php

namespace App\Relation\Application\Command\RelationPublish;

readonly class RelationPublishCommand
{
    public function __construct(private string $id) {
    }

    public function getId(): string {
        return $this->id;
    }

}