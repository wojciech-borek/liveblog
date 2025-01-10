<?php
declare(strict_types=1);

namespace App\Tests\Application\Command\RelationDelete;

use App\Relation\Application\Command\RelationDelete\RelationDeleteCommand;
use PHPUnit\Framework\TestCase;

class RelationDeleteCommandTest extends TestCase
{
    private string $id;

    protected function setUp(): void {
        $this->id = '507f1f77bcf86cd799439011';
    }

    public function testDeleteRelationId(): void {
        $command = new RelationDeleteCommand($this->id);
        $this->assertEquals($this->id, $command->getId());
    }

}