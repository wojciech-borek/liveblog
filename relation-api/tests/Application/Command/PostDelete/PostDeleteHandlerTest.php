<?php
declare(strict_types=1);

namespace App\Tests\Application\Command\PostDelete;

use App\Relation\Application\Command\PostDelete\PostDeleteCommand;
use App\Relation\Application\Command\PostDelete\PostDeleteHandler;
use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\PostNotFoundException;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Model\PostCollection;
use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Post\PostId;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Application\MessageCommandBusInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PostDeleteHandlerTest extends TestCase
{
    private PostDeleteHandler $handler;
    private MockObject $postRepository;
    private MockObject $relationService;
    private MockObject $messageBus;

    protected function setUp(): void {
        $this->postRepository = $this->createMock(PostRepositoryInterface::class);
        $this->relationService = $this->createMock(RelationService::class);
        $this->messageBus = $this->createMock(MessageCommandBusInterface::class);

        $this->handler = new PostDeleteHandler(
            $this->postRepository,
            $this->relationService,
            $this->messageBus
        );
    }

    public function testHandleThrowsExceptionWhenPostNotFound(): void {
        $command = new PostDeleteCommand('507f1f77bcf86cd799439011');

        $this->postRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn(null);

        $this->expectException(PostNotFoundException::class);
        $this->handler->__invoke($command);
    }

    public function testHandleThrowsExceptionWhenRelationNotFound(): void {
        $command = new PostDeleteCommand('507f1f77bcf86cd799439011');
        $relationId = new RelationId('507f1f77bcf86cd799439011');

        $post = $this->createConfiguredMock(Post::class, [
            'getRelationId' => $relationId
        ]);

        $this->postRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($post);

        $this->relationService
            ->expects($this->once())
            ->method('getRelationByIdWithPosts')
            ->with($relationId)
            ->willReturn(null);

        $this->expectException(RelationNotFoundException::class);
        $this->handler->__invoke($command);
    }

    public function testHandleDeletePostAndRemoveItFromRelation(): void {
        $command = new PostDeleteCommand('507f1f77bcf86cd799439012');

        $postId = new PostId('507f1f77bcf86cd799439012');
        $relationId = new RelationId('507f1f77bcf86cd799439011');

        $post = $this->createConfiguredMock(Post::class, [
            'getId' => $postId,
            'getRelationId' => $relationId
        ]);
        $relation = $this->createMock(Relation::class);

        $this->postRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($post);


        $this->relationService
            ->expects($this->once())
            ->method('getRelationByIdWithPosts')
            ->with($relationId)
            ->willReturn($relation);

        $relation
            ->expects($this->once())
            ->method('removePost')
            ->with($post);

        $this->postRepository
            ->expects($this->exactly(2))
            ->method('updatePositions')
            ->with($this->isInstanceOf(PostCollection::class));

        $this->postRepository
            ->expects($this->once())
            ->method('delete')
            ->with($postId);

        $this->handler->__invoke($command);
    }

}