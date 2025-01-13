<?php
declare(strict_types=1);

namespace App\Tests\Application\Query\Assembler;

use App\Relation\Application\Query\Assembler\RelationListDTOAssembler;
use App\Relation\Application\Query\Dto\RelationListDTO;
use App\Relation\Domain\Enum\RelationStatusEnum;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Domain\ValueObject\Relation\RelationStatus;
use App\Relation\Domain\ValueObject\Relation\RelationTitle;
use App\Shared\Domain\ValueObject\CreatedAt;
use App\Shared\Domain\ValueObject\ModifiedAt;
use PHPUnit\Framework\TestCase;

class RelationListDTOAssemblerTest extends TestCase
{
    public function testToDTOCollection() {

        $relation1Id = new RelationId('507f1f77bcf86cd799439011');
        $relation1Title = new RelationTitle('Title 1');
        $relation1Status = new RelationStatus(RelationStatusEnum::DRAFT->value);
        $relation1CreatedAt = new CreatedAt(new \DateTimeImmutable('2023-01-01 10:00:00'));
        $relation1ModifiedAt = new ModifiedAt(new \DateTimeImmutable('2023-01-01 10:00:00'));

        $relation1 = $this->createConfiguredMock(Relation::class, [
            'getId'=> $relation1Id,
            'getTitle'=> $relation1Title,
            'getStatus'=> $relation1Status,
            'getCreatedAt'=> $relation1CreatedAt,
            'getModifiedAt'=> $relation1ModifiedAt
        ]);


        $relation2Id = new RelationId('507f1f77bcf86cd799439012');
        $relation2Title = new RelationTitle('Title 2');
        $relation2Status = new RelationStatus(RelationStatusEnum::PUBLISHED->value);
        $relation2CreatedAt = new CreatedAt(new \DateTimeImmutable('2023-01-01 10:00:00'));
        $relation2ModifiedAt = new ModifiedAt(new \DateTimeImmutable('2023-01-01 10:00:00'));

        $relation2 = $this->createConfiguredMock(Relation::class, [
            'getId'=> $relation2Id,
            'getTitle'=> $relation2Title,
            'getStatus'=> $relation2Status,
            'getCreatedAt'=> $relation2CreatedAt,
            'getModifiedAt'=> $relation2ModifiedAt
        ]);

        $assembler = new RelationListDTOAssembler();

        $dtos = $assembler->toDTOCollection([$relation1, $relation2]);

        $this->assertInstanceOf(RelationListDTO::class, $dtos[0]);
        $this->assertInstanceOf(RelationListDTO::class, $dtos[1]);


        $relation1Serialize = $dtos[0]->jsonSerialize();
        $relation2Serialize = $dtos[1]->jsonSerialize();

        $this->assertCount(2, $dtos);


        $this->assertEquals($relation1Id->getValue(), $relation1Serialize['id']);
        $this->assertEquals($relation1Title->getValue(), $relation1Serialize['title']);
        $this->assertEquals($relation1Status->getValue(), $relation1Serialize['status']);
        $this->assertEquals($relation1CreatedAt->getValue()->format(DATE_ATOM), $relation1Serialize['createdAt']);
        $this->assertEquals($relation1ModifiedAt->getValue()->format(DATE_ATOM), $relation1Serialize['modifiedAt']);


        $this->assertEquals($relation2Id->getValue(), $relation2Serialize['id']);
        $this->assertEquals($relation2Title->getValue(), $relation2Serialize['title']);
        $this->assertEquals($relation2Status->getValue(), $relation2Serialize['status']);
        $this->assertEquals($relation2CreatedAt->getValue()->format(DATE_ATOM), $relation2Serialize['createdAt']);
        $this->assertEquals($relation2ModifiedAt->getValue()->format(DATE_ATOM), $relation2Serialize['modifiedAt']);
    }
}