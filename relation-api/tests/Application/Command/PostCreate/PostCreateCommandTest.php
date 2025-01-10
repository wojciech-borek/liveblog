<?php
declare(strict_types=1);

namespace App\Tests\Application\Command\PostCreate;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use PHPUnit\Framework\TestCase;

class PostCreateCommandTest extends TestCase
{
    private string $relationId;
    private string $content;
    private bool $isPublished;

    protected function setUp(): void {
        $this->relationId = '507f1f77bcf86cd799439011';
        $this->content = 'Lorem Ipsum';
        $this->isPublished = true;
    }

    public function testGetRelationId(): void {
        $command = new PostCreateCommand($this->relationId, $this->content, $this->isPublished);
        $this->assertEquals($this->relationId, $command->getRelationId());
    }

    public function testContent(): void {
        $command = new PostCreateCommand($this->relationId, $this->content, $this->isPublished);
        $this->assertEquals($this->content, $command->getContent());
    }

    public function testIsPublished(): void {
        $command = new PostCreateCommand($this->relationId, $this->content, $this->isPublished);
        $this->assertEquals($this->isPublished, $command->isPublished());
    }

}