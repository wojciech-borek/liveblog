<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\RelationChangeStatus;

readonly class RelationChangeStatusCommand
{
    public function __construct(private string $id,private string $status) {
    }

    public function getId(): string {
        return $this->id;
    }

    public function getStatus(): string {
        return $this->status;
    }


}