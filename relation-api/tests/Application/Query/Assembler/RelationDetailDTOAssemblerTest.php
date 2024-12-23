<?php

namespace App\Tests\Application\Query\Assembler;

use App\Relation\Application\Query\Assembler\PostListDTOAssembler;
use App\Relation\Application\Query\Assembler\RelationDetailDTOAssembler;
use App\Relation\Application\Query\Dto\RelationDetailDTO;
use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Model\PostCollection;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use PHPUnit\Framework\TestCase;

class RelationDetailDTOAssemblerTest extends TestCase
{
    public function testToDTO() {

        $relationId = new RelationId('507f1f77bcf86cd799439011');
        $relationTitle = new RelationTitle('Title 1');
        $relationStatus = new RelationStatus(RelationStatusEnum::DRAFT->value);
        $relationCreatedAt = new CreatedAt(new \DateTimeImmutable('2023-01-01 10:00:00'));
        $relationModifiedAt = new ModifiedAt(new \DateTimeImmutable('2023-01-01 10:00:00'));


        $relation = $this->createMock(Relation::class);
        $relation->method('getId')->willReturn($relationId);
        $relation->method('getTitle')->willReturn($relationTitle);
        $relation->method('getStatus')->willReturn($relationStatus);
        $relation->method('getCreatedAt')->willReturn($relationCreatedAt);
        $relation->method('getModifiedAt')->willReturn($relationModifiedAt);

        $postListMock = $this->createMock(PostCollection::class);
        $postListMock->method('getList')->willReturn([]);

        $postListDTOAssemblerMock = $this->createMock(PostListDTOAssembler::class);

        $assembler = new RelationDetailDTOAssembler($postListDTOAssemblerMock);
        $relationDTO = $assembler->toDTO($relation);
        $relationSerialize = $relationDTO->jsonSerialize();

        $this->assertInstanceOf(RelationDetailDTO::class, $relationDTO);

        $expected = [
            "id" => $relationId->getValue(),
            "title" => $relationTitle->getValue(),
            "status" => $relationStatus->getValue(),
            "createdAt" => $relationCreatedAt->getValue()->format(DATE_ATOM),
            "modifiedAt" => $relationModifiedAt->getValue()->format(DATE_ATOM),
            "postsPublished" => [],
            "postsUnpublished" => [],
        ];

        $this->assertEquals($expected, $relationSerialize);

    }
}