<?php
declare(strict_types=1);

namespace App\Relation\Domain\Exception;

use App\Shared\Domain\Exception\DomainException;

class PostNotFoundException extends DomainException
{
    public function __construct(string $id) {
        parent::__construct(sprintf('Post with ID %s was not found.', $id), 404);
    }

}