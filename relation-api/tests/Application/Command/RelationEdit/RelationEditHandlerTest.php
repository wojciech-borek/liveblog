<?php
declare(strict_types=1);

namespace App\Tests\Application\Command\RelationEdit;

use App\Relation\Application\Command\RelationEdit\RelationEditCommand;
use App\Relation\Application\Command\RelationEdit\RelationEditHandler;
use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\InvalidRelationTitleException;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RelationEditHandlerTest extends TestCase
{
    private RelationEditHandler $handler;
    private MockObject $relationRepository;
    private MockObject $relationService;

    protected function setUp(): void {
        $this->relationRepository = $this->createMock(RelationRepositoryInterface::class);
        $this->relationService = $this->createMock(RelationService::class);

        $this->handler = new RelationEditHandler(
            $this->relationRepository,
            $this->relationService
        );
    }

    public function testHandleCreatesRelationAndSavesIt(): void {
        $command = new RelationEditCommand('507f1f77bcf86cd799439011', 'Lorem ipsum');

        $relationMock = $this->createMock(Relation::class);

        $this->relationService->expects($this->once())->method('getRelation')->willReturn($relationMock);
        $relationMock->expects($this->once())->method('changeTitle');

        $this->relationRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Relation::class));

        $this->handler->__invoke($command);

    }

    public function testHandleThrowsExceptionWhenRelationNotFound(): void {
        $command = new RelationEditCommand('507f1f77bcf86cd799439011', 'Lorem ipsum');

        $this->relationService
            ->expects($this->once())
            ->method('getRelation')
            ->willReturn(null);

        $this->expectException(RelationNotFoundException::class);
        $this->handler->__invoke($command);
    }

    public function testHandleThrowsExceptionWhenRelationTitleIsEmpty(): void {
        $command = new RelationEditCommand('507f1f77bcf86cd799439011', '');
        $relationMock = $this->createMock(Relation::class);
        $this->relationService->expects($this->once())->method('getRelation')->willReturn($relationMock);

        $this->expectException(InvalidRelationTitleException::class);
        $this->handler->__invoke($command);
    }

    public function testHandleThrowsExceptionWhenRelationTitleHasExceedLength(): void {
        $command = new RelationEditCommand('507f1f77bcf86cd799439011', random_bytes(256));

        $relationMock = $this->createMock(Relation::class);
        $this->relationService->expects($this->once())->method('getRelation')->willReturn($relationMock);

        $this->expectException(InvalidRelationTitleException::class);
        $this->handler->__invoke($command);
    }


}