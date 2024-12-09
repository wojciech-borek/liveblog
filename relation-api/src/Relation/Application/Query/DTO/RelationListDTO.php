<?php
namespace App\Relation\Application\Query\DTO;

readonly class RelationListDTO
{
    public function __construct(private string $id,private string $title,private string $status) {
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

}