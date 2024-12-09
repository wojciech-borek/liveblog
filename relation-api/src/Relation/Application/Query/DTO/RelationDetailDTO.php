<?php
namespace App\Relation\Application\Query\DTO;

 readonly class RelationDetailDTO
{
    public function __construct(
        private string $id,
        private string $title,
        private string $status,
        private array $posts
    ) {
    }

     public function getId(): string {
         return $this->id;
     }

     public function getTitle(): string {
         return $this->title;
     }

     public function getStatus(): string {
         return $this->status;
     }

     public function getPosts(): array {
         return $this->posts;
     }


}