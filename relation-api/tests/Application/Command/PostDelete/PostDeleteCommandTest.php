<?php
declare(strict_types=1);

namespace App\Tests\Application\Command\PostDelete;

use App\Relation\Application\Command\PostCreate\PostCreateCommand;
use App\Relation\Application\Command\PostDelete\PostDeleteCommand;
use PHPUnit\Framework\TestCase;

class PostDeleteCommandTest extends TestCase
{
    private string $id;

    protected function setUp(): void {
        $this->id = '507f1f77bcf86cd799439011';
    }

    public function testGetRelationId(): void {
        $command = new PostDeleteCommand($this->id);
        $this->assertEquals($this->id, $command->getId());
    }


}