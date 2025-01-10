<?php
declare(strict_types=1);

namespace App\Tests\Application\Command\PostCreate;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use App\Relation\Application\Command\PostCreate\PostCreateHandler;
use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PostCreateHandlerTest extends TestCase
{
    private PostCreateHandler $handler;
    private MockObject $postRepository;
    private MockObject $relationService;

    protected function setUp(): void {
        $this->postRepository = $this->createMock(PostRepositoryInterface::class);
        $this->relationService = $this->createMock(RelationService::class);

        $this->handler = new PostCreateHandler(
            $this->postRepository,
            $this->relationService
        );
    }

    public function testHandleThrowsExceptionWhenRelationNotFound(): void {
        $command = new PostCreateCommand('507f1f77bcf86cd799439011', 'Lorem Ipsum',false);

        $this->relationService
            ->expects($this->once())
            ->method('getRelationByIdWithPosts')
            ->willReturn(null);

        $this->expectException(RelationNotFoundException::class);
        $this->handler->__invoke($command);
    }

    public function testHandleCreatesPostAndAddsItToRelation(): void {
        $command = new PostCreateCommand('507f1f77bcf86cd799439011', 'Lorem Ipsum', false);
        $relationId = new RelationId('507f1f77bcf86cd799439011');

        $relation = $this->createMock(Relation::class);

        $this->relationService
            ->expects($this->once())
            ->method('getRelationByIdWithPosts')
            ->with($relationId)
            ->willReturn($relation);

        $relation
            ->expects($this->once())
            ->method('addPost')
            ->with($this->isInstanceOf(Post::class));


        $this->postRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Post::class));

        $this->handler->__invoke($command);
    }

}