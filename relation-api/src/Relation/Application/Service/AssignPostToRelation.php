<?php

namespace App\Relation\Application\Service;

use App\Relation\Domain\Model\Relation;
use App\Relation\Domain\Repository\PostRepositoryInterface;

class AssignPostToRelation
{
    public function __construct(private PostRepositoryInterface $postRepository) {
    }

    public function execute(Relation $relation): void {
        $posts = $this->postRepository->findByRelationId($relation->getId());
        foreach ($posts->getList() as $post) {
            $relation->addPost($post);
        }
    }

}