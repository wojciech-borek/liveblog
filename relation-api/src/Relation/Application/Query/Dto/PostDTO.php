<?php
declare(strict_types=1);

namespace App\Relation\Application\Query\Dto;

use App\Relation\Domain\ValueObject\Post\IsPublished;
use App\Relation\Domain\ValueObject\Post\PostContent;
use App\Relation\Domain\ValueObject\Post\PostPosition;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use App\Shared\Domain\ValueObject\MongoObjectId;

readonly class PostDTO implements \JsonSerializable
{

    public function __construct(
        private MongoObjectId $id,
        private PostContent   $content,
        private PostPosition  $position,
        private IsPublished   $isPublished,
        private CreatedAt     $createdAt,
        private ModifiedAt    $modifiedAt,
    ) {

    }


    public function jsonSerialize(): array {
        return [
            "id" => $this->id->getValue(),
            "position" => $this->position->getValue(),
            "isPublished" => $this->isPublished->getValue(),
            "content" => $this->content->getValue(),
            "createdAt" => $this->createdAt->getValue()->format(DATE_ATOM),
            "modifiedAt" => $this->modifiedAt->getValue()->format(DATE_ATOM),
        ];
    }
}