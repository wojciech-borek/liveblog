<?php

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

abstract class DoctrineRepository
{
    public function __construct(private readonly DocumentManager $documentManager) {}

    protected function documentManager(): DocumentManager
    {
        return $this->documentManager;
    }

    /**
     * @throws \Throwable
     * @throws MongoDBException
     */
    protected function persist($document): void
    {
        $this->documentManager()->persist($document);
        $this->documentManager()->flush();
    }

    /**
     * @throws \Throwable
     * @throws MongoDBException
     */
    protected function remove($document): void
    {
        $this->documentManager()->remove($document);
        $this->documentManager()->flush();
    }


    protected function repository(string $documentClass): DocumentRepository
    {
        return $this->documentManager->getRepository($documentClass);
    }
}