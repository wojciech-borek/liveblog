<?php

namespace App\Tests\Application\Command\RelationDelete;

use App\Relation\Application\Command\RelationDelete\RelationDeleteCommand;
use App\Relation\Application\Command\RelationDelete\RelationDeleteHandler;
use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class RelationDeleteHandlerTest extends TestCase
{
    private RelationDeleteHandler $handler;
    private MockObject $relationRepository;
    private MockObject $relationService;
    private MockObject $messageBus;

    protected function setUp(): void {
        $this->relationRepository = $this->createMock(RelationRepositoryInterface::class);
        $this->relationService = $this->createMock(RelationService::class);
        $this->messageBus = $this->createMock(MessageBusInterface::class);

        $this->handler = new RelationDeleteHandler(
            $this->relationRepository,
            $this->relationService,
            $this->messageBus,
        );
    }


    public function testHandleDeleteRelation(): void {

        $id = '507f1f77bcf86cd799439011';
        $command = new RelationDeleteCommand($id);

        $relationMock = $this->createMock(Relation::class);
        $relationMock->method('getId')->willReturn(new RelationId($id));

        $this->relationService->expects($this->once())->method('getRelation')->willReturn($relationMock);
        $relationMock->expects($this->once())->method('delete');
        $this->relationRepository->expects($this->once())->method('delete')->with($relationMock->getId());

        $this->handler->__invoke($command);
    }

    public function testHandleThrowsExceptionWhenRelationNotFound(): void {
        $command = new RelationDeleteCommand('507f1f77bcf86cd799439011');

        $this->relationService
            ->expects($this->once())
            ->method('getRelation')
            ->willReturn(null);

        $this->expectException(RelationNotFoundException::class);
        $this->handler->__invoke($command);
    }
//
//    public function testHandleThrowsExceptionWhenRelationTitleHasExceedLength(): void {
//        $command = new RelationCreateCommand(random_bytes(256));
//        $this->expectException(InvalidRelationTitleException::class);
//        $this->handler->__invoke($command);
//    }


}