<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\RelationCreate;


readonly class RelationCreateCommand
{
    public function __construct(private string $title) {}

    public function getTitle(): string {
        return $this->title;
    }




}