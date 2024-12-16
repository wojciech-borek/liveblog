<?php

namespace App\Relation\Infrastructure\Persistence\Repository;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\PostCollection;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Relation\Infrastructure\Persistence\MongoDB\Document\PostDocument;
use App\Relation\Infrastructure\Persistence\MongoDB\Mapper\PostMapper;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class PostRepository extends DoctrineRepository implements PostRepositoryInterface
{

    public function save(Post $post): void {

        $postDocument = PostMapper::toDocument($post);
        $this->persist($postDocument);
    }

    public function findByRelationId(RelationId $relationId): PostCollection {
        $posts = $this->repository(PostDocument::class)
            ->findBy(['relationId' => $relationId->getValue()]);

        $postCollection = new PostCollection();
        foreach ($posts as $post) {
            $postCollection->add(PostMapper::toDomain($post));
        }
        return $postCollection;
    }
}