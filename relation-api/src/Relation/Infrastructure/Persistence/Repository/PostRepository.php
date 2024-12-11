<?php
namespace App\Relation\Infrastructure\Persistence\Repository;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use MongoDB\BSON\ObjectId;

class PostRepository extends DoctrineRepository implements PostRepositoryInterface
{

    public function delete(Post $post): void {
//        $this->dm->remove($post);
//        $this->dm->flush();
    }


    public function findById(RelationId $relationId): ?Post {
        return $this->documentManager()->find(Post::class,$relationId->value());
    }

    public function deleteByRelationId(RelationId $relationId): void {
        $qb = $this->documentManager()->getRepository(Post::class)->createQueryBuilder();
        $qb
            ->remove()
            ->field('relation.$id')->equals(new ObjectId($relationId->value()))
            ->getQuery()
            ->execute();
    }
}