<?php

namespace App\Relation\Infrastructure\Persistence\Repository;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Infrastructure\Persistence\MongoDB\Mapper\PostMapper;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class PostRepository extends DoctrineRepository implements PostRepositoryInterface
{

    public function save(Post $post): void {
        $postDocument = PostMapper::toDocument($post);
        $this->persist($postDocument);
    }
}