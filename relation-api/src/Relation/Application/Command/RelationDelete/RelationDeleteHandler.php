<?php
declare(strict_types=1);

namespace App\Relation\Application\Command\RelationDelete;

use App\Relation\Application\Service\RelationService;
use App\Relation\Domain\Exception\RelationNotFoundException;
use App\Relation\Domain\Repository\PostRepositoryInterface;
use App\Relation\Domain\Repository\RelationRepositoryInterface;
use App\Relation\Domain\ValueObject\Relation\RelationId;
use App\Shared\Application\MessageCommandBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class RelationDeleteHandler
{
    public function __construct(
        private RelationRepositoryInterface $relationRepository,
        private PostRepositoryInterface     $postRepository,
        private RelationService             $relationService,
        private MessageCommandBusInterface  $messageBus,

    ) {
    }

    public function __invoke(RelationDeleteCommand $command): void {
        $id = new RelationId($command->getId());
        $relation = $this->relationService->getRelation($id);

        if (empty($relation)) {
            throw new RelationNotFoundException($id->getValue());
        }
        $relation->delete();

        $this->postRepository->deleteByRelationId($relation->getId());

        $this->relationRepository->delete($relation->getId());

        foreach ($relation->getDomainEvents() as $event) {
            $this->messageBus->dispatch($event);
        }
        $relation->clearDomainEvents();

    }

}