<?php
declare(strict_types=1);

namespace App\Relation\Infrastructure\Persistence\Repository;

use App\Relation\Domain\Model\Post;
use App\Relation\Domain\Model\PostCollection;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\ValueObject\Post\PostId;
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

    public function deleteByRelationId(RelationId $relationId): void {
        $this->documentManager()->getDocumentCollection(PostDocument::class)->deleteMany(['relationId' => $relationId->getValue()]);

    }

    public function updatePositions(PostCollection $postCollection): void {
        $postDocumentCollection = $this->documentManager()->getDocumentCollection(PostDocument::class);

        foreach ($postCollection->getList() as $post) {
            $postDocumentCollection->updateOne(
                ['_id' => $post->getId()],
                [
                    '$set' => [
                        'position' => $post->getPosition()->getValue()
                    ]
                ],
            );
        }
    }


    public function delete(PostId $id): void {
        $document = $this->documentManager()->find(PostDocument::class, $id->getValue());
        $this->remove($document);
    }

    public function findById(PostId $id): ?Post {
        $document = $this->documentManager()->find(PostDocument::class, $id->getValue());

        if (!$document) {
            return null;
        }
        return PostMapper::toDomain($document);
    }


    public function findByRelationId(RelationId $relationId): PostCollection {
        $posts = $this->repository(PostDocument::class)
            ->findBy(['relationId' => $relationId->getValue()], ['position' => 'desc']);

        $postCollection = new PostCollection();
        foreach ($posts as $post) {
            $postCollection->add(PostMapper::toDomain($post));
        }
        return $postCollection;
    }
}