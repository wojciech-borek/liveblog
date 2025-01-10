<?php
declare(strict_types=1);

namespace App\Tests\Application\Command\RelationCreate;

use App\Relation\Application\Command\RelationCreate\RelationCreateCommand;
use App\Relation\Application\Command\RelationCreate\RelationCreateHandler;
use App\Relation\Domain\Exception\InvalidRelationTitleException;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RelationCreateHandlerTest extends TestCase
{
    private RelationCreateHandler $handler;
    private MockObject $relationRepository;

    protected function setUp(): void
    {
        $this->relationRepository = $this->createMock(RelationRepositoryInterface::class);

        $this->handler = new RelationCreateHandler(
            $this->relationRepository
        );
    }


    public function testHandleCreatesRelationAndSavesIt(): void{
        $command = new RelationCreateCommand('Lorem ipsum');

        $this->relationRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Relation::class));

        $this->handler->__invoke($command);

    }

    public function testHandleThrowsExceptionWhenRelationTitleIsEmpty(): void
    {
        $command = new RelationCreateCommand('');
        $this->expectException(InvalidRelationTitleException::class);
        $this->handler->__invoke($command);
    }

    public function testHandleThrowsExceptionWhenRelationTitleHasExceedLength(): void
    {
        $command = new RelationCreateCommand(random_bytes(256));
        $this->expectException(InvalidRelationTitleException::class);
        $this->handler->__invoke($command);
    }


}