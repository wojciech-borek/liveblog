<?php
namespace App\Relation\Infrastructure\Repository;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use MongoDB\BSON\ObjectId;

class PostRepository extends DoctrineRepository implements PostRepositoryInterface
{

    public function delete(Post $post): void {
//        $this->dm->remove($post);
//        $this->dm->flush();
    }


    public function findById($id): ?Post {
        return $this->documentManager()->find(Post::class,$id);
    }

    public function deleteByRelationId(string $relationId): void {
        $qb = $this->documentManager()->getRepository(Post::class)->createQueryBuilder();
        $qb
            ->remove()
            ->field('relation.$id')->equals(new ObjectId($relationId))
            ->getQuery()
            ->execute();
    }
}