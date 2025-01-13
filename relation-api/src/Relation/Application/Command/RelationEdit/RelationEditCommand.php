<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\RelationEdit;


readonly class RelationEditCommand
{
    public function __construct(private string $id,private string $title) {}

    public function getId(): string {
        return $this->id;
    }


    public function getTitle(): string {
        return $this->title;
    }




}