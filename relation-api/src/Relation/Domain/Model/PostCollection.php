<?php

namespace App\Relation\Domain\Model;

use App\Relation\Domain\Exception\PostNotFoundException;
use App\Relation\Domain\ValueObject\Post\PostId;
use App\Relation\Domain\ValueObject\Post\PostPosition;

class PostCollection
{
    /** @var Post[] */
    private array $list = [];

    public function add(Post $post): void {
        $this->list[] = $post;
    }


    public function toggleIsPublishedPost(Post $post): void {
        $post = $this->findById($post->getId());
        $post->getIsPublished()->toggle();
    }

    protected function sortByPosition(): void {
        usort($this->list, fn(Post $post, Post $nextPost) => $post->getPosition()->getValue() <=> $nextPost->getPosition()->getValue());
    }


    public function removeFromListsById(PostId $postId): void {
        foreach ($this->list as $index => $post) {
            if ($post->getId()->equals($postId)) {
                unset($this->list[$index]);
                break;
            }
        }
        $this->list = array_values($this->list);
    }

    protected function findById(PostId $postId): ?Post {
        foreach ($this->list as $post) {
            if ($post->getId()->equals($postId)) {
                return $post;
            }
        }
        throw new PostNotFoundException("Post with ID {$postId->getValue()} not found in  posts.");
    }

    public function clear(): void {
        $this->list = [];
    }

    /**
     *
     * @return Post[]
     */
    public function getList(): array {
        return $this->list;
    }

    public function count(): int {
        return count($this->list);
    }

    protected function getIdPositionMap(): array {
        return array_map(fn($post) => [
            'id' => $post->getId(),
            'position' => $post->getPosition(),
        ], $this->list);
    }

    public function renumber(): array {
        $this->sortByPosition();
        $position = new PostPosition(1);
        foreach ($this->list as $post) {
            $post->setPosition($position->increment());
        }
        return $this->getIdPositionMap();
    }

}