<?php

namespace App\Tests\Application\Command\PostCreate;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use App\Relation\Application\Command\PostCreate\PostCreateHandler;
use App\Relation\Application\Service\AssignPostToRelation;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PostCreateHandlerTest extends TestCase
{
    private PostCreateHandler $handler;
    private MockObject $postRepository;
    private MockObject $relationRepository;
    private MockObject $assignPostToRelation;

    protected function setUp(): void
    {
        $this->postRepository = $this->createMock(PostRepositoryInterface::class);
        $this->relationRepository = $this->createMock(RelationRepositoryInterface::class);
        $this->assignPostToRelation = $this->createMock(AssignPostToRelation::class);

        $this->handler = new PostCreateHandler(
            $this->postRepository,
            $this->relationRepository,
            $this->assignPostToRelation
        );
    }

    public function testHandleThrowsExceptionWhenRelationNotFound(): void
    {
        $command = new PostCreateCommand('507f1f77bcf86cd799439011', 'Lorem Ipsum');

        $this->relationRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn(null);

        $this->expectException(RelationNotFoundException::class);
        $this->handler->__invoke($command);
    }

    public function testHandleCreatesPostAndAddsItToRelation(): void
    {
        $command = new PostCreateCommand('507f1f77bcf86cd799439011', 'Lorem Ipsum');
        $relationId = new RelationId('507f1f77bcf86cd799439011');

        $relation = $this->createMock(Relation::class);

        $this->relationRepository
            ->expects($this->once())
            ->method('findById')
            ->with($relationId)
            ->willReturn($relation);

        $relation
            ->expects($this->once())
            ->method('addPost')
            ->with($this->isInstanceOf(Post::class));

        $this->assignPostToRelation
            ->expects($this->once())
            ->method('execute')
            ->with($relation);

        $this->postRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Post::class));

        $this->handler->__invoke($command);
    }

}