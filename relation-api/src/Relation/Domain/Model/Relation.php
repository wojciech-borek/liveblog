<?php
declare(strict_types=1);

namespace App\Relation\Domain\Model;

use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Shared\Domain\Aggregate\AggregateRoot;

class Relation extends AggregateRoot
{
    public function __construct(
        private readonly string             $id,
        private readonly string             $title,
        private readonly RelationStatusEnum $status,
        private readonly \DateTimeInterface $createdAt,
        private readonly \DateTimeInterface $modifiedAt,
        private readonly array              $posts = []
    ) {
    }

    public function getId(): string {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }


    public function getStatus(): RelationStatusEnum {
        return $this->status;
    }

    public function getCreatedAt(): \DateTimeInterface {
        return $this->createdAt;
    }

    public function getModifiedAt(): \DateTimeInterface {
        return $this->modifiedAt;
    }

    public function getPosts(): array {
        return $this->posts;
    }


}
